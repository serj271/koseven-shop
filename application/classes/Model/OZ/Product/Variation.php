<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Product variation model
 *
 * @package    openzula/kohana-oz-ecommerce
 * @author     Alex Cartwright <alex@openzula.org>
 * @copyright  Copyright (c) 2011, 2012 OpenZula
 * @license    http://openzula.org/license-bsd-3c BSD 3-Clause License
 */
abstract class Model_OZ_Product_Variation extends ORM {
	protected $_table_name = 'product_variations';
	protected $_belongs_to = array(
		'product' => array(
			'model' => 'Product',
		),
	);

	protected $_table_columns = array(
		'id'         => array('type' => 'int'),
		'product_id' => array('type' => 'int'),
		'name'       => array('type' => 'string'),
		'price'      => array('type' => 'float'),
		'sale_price' => array('type' => 'float'),
		'discounted_price'=> array('type' => 'float'),
		'quantity'   => array('type' => 'int'),
	);
	public function labels(){
		return array(
		'id'         => 'id',
		'product_id' => 'product_id',
		'name'       => 'name',
		'price'      => __('price'),
		'sale_price' => __('sale price'),
		'discounted_price'=> __('discounted price'),
		'quantity'   => __('quantity'),	
		);
	}
	
	public function rules()
	{
		return array(
			'product_id' => array(
				array('not_empty'),
				array('digit'),
//				array('gt', array(':value', 0)),
			),
			'name' => array(
//				array('not_empty'),
			),
			'price' => array(
				array('not_empty'),
				array('numeric'),
			),
			'sale_price' => array(
				array('numeric'),
				array('Validation::lt', array(':value', array($this->price))),
//				array(array($this, 'check_sale')),
			),
			'discounted_price' => array(
				array('not_empty'),
				array('numeric'),
			),
			'quantity' => array(
				array('not_empty'),
				array('digit'),
			),
		);
	}


	/**
	 * Overload the save method to set the sale_price to NULL if an empty
	 * or 0.00 value was given
	 *
	 * @param   Validation  $validation
	 * @return  mixed
	 */
	public function save(Validation $validation=NULL)
	{
		if ( ! $this->sale_price)
		{
			$this->sale_price = NULL;
		}
		return parent::save($validation);
	}

}
