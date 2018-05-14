<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shopping_Cart extends ORM_Base {

	protected $_table_name = 'shopping_cart';
//	protected $_sorting = array('basket_id' => 'ASC');
//	protected $_deleted_column = 'delete_bit';

	protected $_belongs_to = array(
//		'basket' => array(
//			'model' => 'basket',
//			'foreign_key' => 'basket_id',
//		),
		'product' => array(
			'model' => 'Product',
			'foreign_key' => 'product_id',
		),
	);

	protected $_table_columns = array(
		'id'                => array('type' => 'int'),
//		'name'              => array('type' => 'string'),
		'attributes'       => array('type' => 'string'),
		'product_id'  => array('type' => 'int'),
		'cart_id'  => array('type' => 'string'),
		'added_on' => array('type' => 'string'),
		'quantity'           => array('type' => 'int'),
		'buy_now'           	=> array('type' => 'string'),

	);
//	public function list_columns(){
//	    return array(
//		'product_id'=>'product_id'
//	    );	
//	} 

	/**
	 * Return the primary product photo
	 *
	 * @return  Model_Product
	 */
	public function product()
	{
		return ORM::factory('Product', $this->product_id);
	}
	
	public function product_variation()
	{
		return ORM::factory('Product_Variation')->where('product_id','=',$this->product_id)->find();
	}
	
	public function labels()
	{
		return array(
			'cart_id' => __('Cart'),
//			'product_id' => 'Product',
			'quantity' => __('Quantity'),
			'price' => 'Price',
			'attributes' => __('Attributes'),
			'name'=> __('Product'),
			'subtotal'=> __('Subtotal'),
			'total_amount'=> __('Total Amount'),
//			'discount' => 'Discount',
		);
	}

	public function rules()
	{
		return array(
			'id' => array(
				array('digit'),
			),
//			'basket_id' => array(
//				array('not_empty'),
//				array('digit'),
//			),
			'product_id' => array(
				array('not_empty'),
				array('digit'),
			),
			'cart_id' => array(
				array('not_empty'),
				array('alpha_numeric'),
			),

			'quantity' => array(
				array('not_empty'),
				array('digit'),
			),
			'attributes' => array(
//				array('not_empty')
			
			),
//			'price' => array(
//				array('not_empty'),
//				array('max_length', array(':value', 255)),
//			),
//			'discount' => array(
//				array('max_length', array(':value', 255)),
//			),
		);
	}

	public function filters()
	{
		return array(
//			TRUE => array(
//				array('trim'),
//				array('strip_tags'),
//			),
		);
	}
	
}
