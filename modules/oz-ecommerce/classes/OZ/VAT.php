<?php defined('SYSPATH') or die('No direct script access.');
/**
 * VAT helper class
 *
 * @author     Alex Cartwright <alex@openzula.org>
 * @copyright  Copyright (c) 2012 OpenZula
 * @license    http://openzula.org/license-bsd-3c BSD 3-Clause License
 */
class OZ_VAT {

	/**
	 * Returns the VAT rate, as configured in oz-ecommerce config file
	 *
	 * @return  float
	 */
	static public function rate()
	{
		return (float) Kohana::$config->load('oz-ecommerce.vat_rate');
	}

	/**
	 * Returns the given price inclusive of VAT
	 *
	 * @param   mixed  $price
	 * @param   float  $vat_rate
	 * @return  float
	 */
	static public function price($price, $vat_rate = NULL)
	{
		if ( ! $vat_rate)
		{
			$vat_rate = self::rate();
		}

		return $price * (1 + ($vat_rate / 100));
	}

}
