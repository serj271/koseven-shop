<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Product variation model
 *
 * @package    openzula/kohana-oz-ecommerce
 * @author     Alex Cartwright <alex@openzula.org>
 * @copyright  Copyright (c) 2011, 2012 OpenZula
 * @license    http://openzula.org/license-bsd-3c BSD 3-Clause License
 */
abstract class Model_OZ_Product_Categories_Product extends ORM {

	protected $_table_name='product_categories_products';
	protected $_primary_key = 'id';
	protected $_has_many = array(
		'product' => array(
			'model' => 'Product',
			'through'=>'products',
			'far_key'=>'product_id',
			'foreign_key'=>'id'
		),
		'category' => array(
			'model' => 'Catalog_Category',
			'through'=>'catalog_categories',
			'far_key'=>'catalog_category_id',
			'foreign_key'=>'id'
		),
	);

//	protected $_has_many = array(
//		'category' => array(
//			'model'   => 'Product_Categories_Product',
//			'through' => 'categories_posts',
//		),
//	);
	protected $_table_columns = array(
		'id'         => array('type' => 'int'),
		'product_id' => array('type' => 'int'),
		'catalog_category_id' => array('type' => 'int'),
#		'name'       => array('type' => 'string'),
#		'price'      => array('type' => 'float'),
#		'sale_price' => array('type' => 'float'),
#		'quantity'   => array('type' => 'int'),
	);

	public function rules()
	{
		return array(
			'product_id' => array(
				array('not_empty'),
				array('digit'),
//				array('gt', array(':value', 0)),
			),
			'category_id' => array(
				array('not_empty'),
				array('digit'),
//				array('gt', array(':value', 0)),
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

}
