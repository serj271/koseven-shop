<?php defined('SYSPATH') or die('No direct script access.');
/**
 * SagePay Form intergration
 *
 * @package    openzula/kohana-oz-ecommerce
 * @author     Alex Cartwright <alex@openzula.org>
 * @copyright  Copyright (c) 2012 OpenZula
 * @license    http://openzula.org/license-bsd-3c BSD 3-Clause License
 */
class OZ_Payment_Sagepay_Form {

	/**
	 * Toggle development mode to use development/sandbox URLs
	 * @var bool
	 */
	protected $_development;

	/**
	 * SagePay vendor
	 * @var string
	 */
	protected $_vendor;

	/**
	 * SagePay vendor email
	 * @var string
	 */
	protected $_vendor_email;

	/**
	 * Encryption password
	 * @var string
	 */
	protected $_encryption_pwd;

	/**
	 * Constructor
	 * Set various properties that we will need to know
	 *
	 * @param   string  $vendor
	 * @param   string  $vendor_email
	 * @param   string  $encryption_pwd
	 * @param   bool    $development     Enable development/sandbox URL
	 * @return  void
	 */
	public function __construct($vendor, $vendor_email, $encryption_pwd, $development=NULL)
	{
		$this->_vendor         = $vendor;
		$this->_vendor_email   = $vendor_email;
		$this->_encryption_pwd = $encryption_pwd;

		if (NULL === $development)
		{
			$this->_development = (Kohana::DEVELOPMENT == Kohana::$environment);
		}
		else
		{
			$this->_development = (bool) $development;
		}
	}

	/**
	 * Returns the URL that the HTTP POST request should go to
	 *
	 * @return  string
	 */
	public function url()
	{
		if ($this->_development)
			return 'https://test.sagepay.com/gateway/service/vspform-register.vsp';

		return 'https://live.sagepay.com/gateway/service/vspform-register.vsp';
	}

	/**
	 * Returns the vendor currently being used
	 *
	 * @return  string
	 */
	public function vendor()
	{
		return $this->_vendor;
	}

	/**
	 * Returns the vendor email currently being used
	 *
	 * @return  string
	 */
	public function vendor_email()
	{
		return $this->_vendor_email;
	}

	/**
	 * Converts the given Model_Order instance into the secure crypt
	 * data format that SagePay wants us to pass in the HTTPS POST
	 * request, as the "crypt" field.
	 *
	 * @param   Model_Order  $order
	 * @return  string
	 */
	public function crypt_order(Model_Order $order)
	{
		if ( ! $order->loaded())
			throw new InvalidArgumentException;

		$locale_info = localeconv();

		$amount = $order->amount();
		if ($order->vat_rate > 0)
		{
			$amount = round($amount * (1 + ($order->vat_rate / 100)), 2);
		}

		// Get the firstname and lastname as separate variables
		list($b_firstname, $b_lastname) = array_pad(explode(' ', $order->billing_name, 2), 2, 'unknown');
		list($d_firstname, $d_lastname) = array_pad(explode(' ', $order->shipping_name, 2), 2, 'unknown');

		$crypt_data = array(
			'VendorTxCode'       => uniqid($order->pk().'-'),
			'VendorEmail'        => $this->_vendor_email,

			'Amount'             => $amount,
			'Currency'           => trim($locale_info['int_curr_symbol']),
			'Description'        => sprintf('%d items', $order->products->count_all()),

			'SuccessURL'         => URL::site('shop/checkout/complete', Request::current()),
			'FailureURL'         => URL::site('shop/checkout/failure', Request::current()),

			'CustomerName'       => $order->billing_name,
			'CustomerEmail'      => $order->email,

			'BillingSurname'     => $b_lastname,
			'BillingFirstnames'  => $b_firstname,
			'BillingAddress1'    => $order->billing_addr1,
			'BillingAddress2'    => $order->billing_addr2,
			'BillingCity'        => $order->billing_addr3,
			'BillingPostCode'    => $order->billing_postal_code,
			'BillingCountry'     => $order->billing_country,
			'BillingPhone'       => $order->billing_telephone,

			'DeliverySurname'    => $d_lastname,
			'DeliveryFirstnames' => $d_firstname,
			'DeliveryAddress1'   => $order->shipping_addr1,
			'DeliveryAddress2'   => $order->shipping_addr2,
			'DeliveryCity'       => $order->shipping_addr3,
			'DeliveryPostCode'   => $order->shipping_postal_code,
			'DeliveryCountry'    => $order->shipping_country,
			'DeliveryPhone'      => $order->shipping_telephone,
		);

		/**
		 * Basket contents (incl. any discounst & shipping costs)
		 */
		$crypt_data['Basket'] = sprintf('%d:%s:---:---:---:---:%01.2f',
			$order->products->count_all() + ($order->discount ? 2 : 1),
			'Delivery',
			$order->shipping_price
		);

		foreach ($order->products->find_all() as $op)
		{
			$crypt_data['Basket'] .= sprintf(
				':%s (%s):%d:%01.2f:::%01.2f',
				$op->product_name,
				$op->variation_name,
				$op->quantity,
				$op->price,
				$op->price * $op->quantity
			);
		}

		if ($order->discount)
		{
			$crypt_data['Basket'] .= sprintf(':%s:---:---:---::-%01.2f', 'Discount', $order->discount);
		}

		/**
		 * Encryption of all the data
		 */
		$crypt = NULL;
		foreach ($crypt_data as $k=>$v)
		{
			$crypt .= "{$k}={$v}&";
		}
		$crypt = rtrim($crypt, '&');

		$padlength = 16 - (strlen($crypt) % 16); # 16 = blocksize
		for ($i = 1; $i <= $padlength; $i++) {
			$crypt .= chr($padlength);
		}

		return '@'.bin2hex(mcrypt_encrypt(
			MCRYPT_RIJNDAEL_128,
			$this->_encryption_pwd,
			$crypt,
			MCRYPT_MODE_CBC,
			$this->_encryption_pwd
		));
	}

	/**
	 * Decrypts a message from SagePay and returns it as an associative
	 * array.
	 *
	 * @param   string  $crypt
	 * @return  array
	 */
	public function decrypt($crypt)
	{
		parse_str(mcrypt_decrypt(
			MCRYPT_RIJNDAEL_128,
			$this->_encryption_pwd,
			pack('H*', substr($crypt, 1)),
			MCRYPT_MODE_CBC,
			$this->_encryption_pwd
		), $data);

		return $data;
	}

}
