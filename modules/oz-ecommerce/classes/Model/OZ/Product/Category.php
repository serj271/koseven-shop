<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Product category model
 *
 * @package    openzula/kohana-oz-ecommerce
 * @author     Alex Cartwright <alex@openzula.org>
 * @copyright  Copyright (c) 2011, 2012 OpenZula
 * @license    http://openzula.org/license-bsd-3c BSD 3-Clause License
 */
abstract class Model_OZ_Product_Category extends ORM {
	protected $_table_name='product_categories';

	protected $_has_many = array(
		'products' => array(
			'model'       => 'Product',
			'through'     => 'product_categories_products',
			'foreign_key' => 'category_id',
		)
	);

	protected $_table_columns = array(
		'id'          => array('type' => 'int'),
		'name'        => array('type' => 'string'),
		'description' => array('type' => 'string'),
//		'order'       => array('type' => 'int'),
		'parent_id'   => array('type' => 'int'),
		'image'       => array('type' => 'string'),
		'uri'          	=> array('type' => 'string'),
	);

	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
			),
			/* 'order' => array(
				array('not_empty'),
				array('digit'),
			), */
			'parent_id' => array(
				array('digit'),
//				array('gt', array(':value', 0)),
			),
			'image' => array(
				array('is_file'),
			),
			'uri' => array(
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 255)),
				array('alpha_dash'),
				array(array($this, 'check_uri')),
			),

		);
	}

	public function filters()
	{
		return array(
			'name'        => array(array('trim')),
			'description' => array(array('trim')),
		);
	}

	/**
	 * Overload ORM::delete() to provide additional logic.
	 *
	 * @return  mixed
	 */
	public function delete()
	{
		$image = $this->image;
		$foo = parent::delete();

		if ($image AND file_exists($image))
		{
			try
			{
//				unlink($image);
			}
			catch (Exception $e)
			{
				Kohana::$log->add(Log::WARNING, $e->getMessage());
			}
		}

		return $foo;
	}

	/**
	 * Returns a full tree of nested product categories started at a category
	 *
	 * @param   int    $start
	 * @param   int    $stop      do not return this category ID
	 * @param   array  $order_by
	 * @return  array
	 */
	public function full_tree($start = NULL, $stop = NULL, array $order_by = array('name', 'ASC'))//order
	{
		$tree = array();

		$product_categories = ORM::factory('Product_Category')
			->where('parent_id', '=', $start)
			->order_by($order_by[0], $order_by[1])
			->find_all();

		foreach ($product_categories as $category)
		{
			if ($stop == $category->id)
				continue;

			$tree[] = $category->as_array() + array(
				'children' => $this->full_tree($category->id, $stop, $order_by)
			);
		}
		return $tree;
	}

	/**
	 * Gets the reverse tree of categories, selecting the first parent. Useful
	 * when need to generate breadcrumb type feature
	 *
	 * @param   int   $start
	 * @return  array
	 */
	public function reverse_tree($start)
	{
		$tree = array();

		$category = ORM::factory('Product_Category', $start);
		$tree[] = $category;

		while ($category->parent_id)
		{
			$category = ORM::factory('Product_Category', $category->parent_id);
			$tree[] = $category;
		}

		return array_reverse($tree);
	}

	/**
	 * Find all of the cheapest products (sale_price takes preference over price
	 * in this case) within the category.
	 *
	 * @return  mixed
	 */
	public function cheapest_products()
	{
		if ( ! $this->loaded())
			return $this->products;

		$minprice = $this->products
			->select(array(DB::expr('LEAST(MIN(price), MIN(sale_price))'), 'minprice'))
			->find()
			->minprice;

		return $this->products
			->where('price', '=', $minprice)
			->or_where('sale_price', '=', $minprice);
	}

	/**
	 * Finds the most expensive (dearest) products within the category.
	 *
	 * @return  mixed
	 */
	public function dearest_products()
	{
		if ( ! $this->loaded())
			return $this->products;

		$maxprice = $this->products
			->select(array(DB::expr('MAX(price)'), 'maxprice'))
			->find()
			->maxprice;

		return $this->products
			->where('price', '=', $maxprice);
	}
	
	public function check_uri($value)
	{
//		if ( ! $this->active) {
//			return TRUE;
//		}
	
		$orm = clone $this;
		$orm->clear();
	
		if ($this->loaded()) {
			$orm
				->where('id', '!=', $this->id);
		}
	
		$orm
//			->where('category_id', '=', $this->category_id)
			->where('uri', '=', $this->uri)
//			->where('delete_bit', '=', 0)
			->find();
	
		return ! $orm->loaded();
	}

}
