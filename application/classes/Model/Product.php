<?php defined('SYSPATH') or die('No direct script access.');

class Model_Product extends ORM {
protected $_has_many = array(
		'categories' => array(
			'model'   => 'Catalog_Category',
			'through' => 'product_categories_products',
			'far_key'=> 'catalog_category_id',
//			'foreign_key' =>'category_id'
		),
		'photos' => array(
			'model' => 'Product_Photo',
//			'through' => 'product_photos',
		),
		'reviews' => array(
			'model' => 'Product_Review',
			'far_key'=> 'product_id',
		),
		'specifications' => array(
			'model' => 'Product_Specification',
		),
		'variations' => array(
			'model' => 'Product_Variation',
			'far_key'=> 'product_id',
		),
	);

	protected $_table_columns = array(
		'id'                => array('type' => 'int'),
		'name'              => array('type' => 'string'),
		'description'       => array('type' => 'string'),
		'primary_photo_id'  => array('type' => 'int'),
		'avg_review_rating' => array('type' => 'float'),
		'visible'           => array('type' => 'int'),
		'uri'           	=> array('type' => 'string'),

	);
	
	public function labels()
	{
		return array(
			'id' => 'id',		
			'uri' => 'URI',
			'name' => __('name of product'),
			'uri' => 'uri',
			'description' => __('description of product'),		
			'primary_photo_id' => 'photo id',
			'avg_review_rating' => 'Avg_review_rating tag',
		);
	}

	

	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
			),
			'description' => array(
				array('not_empty'),
			),
			'primary_photo_id' => array(
				array('digit'),
//				array('gt', array(':value', 0)),
			),
			'visible' => array(
				array('digit'),
			),
			'avg_review_rating' => array(
				array('not_empty'),
				array('digit'),
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
			TRUE => array(
				array('trim'),
				array('strip_tags'),
			),
		);
	}
	/**
	 * Finds all uncategorised products
	 *
	 * @return  Model_OZ_Product
	 */
	public function uncategorised()
	{
		return $this->join(array('product_categories_products', 'pivot'), 'LEFT')
			->on($this->object_name().'.id', '=', 'pivot.product_id')
			->where('pivot.id', 'IS', NULL);
	}

	/**
	 * Return the primary product photo
	 *
	 * @return  Model_OZ_Product_Photo
	 */
	public function primary_photo()
	{
		return ORM::factory('Product_Photo', $this->primary_photo_id);
	}

	/**
	 * Return the sum of the "quantity" property of all variations this product
	 * has.
	 *
	 * @return  int
	 */
	public function available_quantity()
	{
		if ( ! $this->loaded())
			return 0;

		return (int) DB::select(array(DB::expr('SUM("quantity")'), 'quantity_sum'))
			->from('product_variations')
			->where('product_id', '=', $this->pk())
			->execute()
			->get('quantity_sum');
	}
	
//	public function getId()
//	{
//	    return $this->primary_photo_id;	
//	}

	/**
	 * Overload the delete method to remove all photos first. This is
	 * so the physical files (and any resulting dangling directories)
	 * get removed as well, using the code present in
	 * Model_Product_Photo::delete()
	 *
	 * @return  mixed
	 */
	public function delete()
	{
		foreach ($this->photos->find_all() as $photo)
		{
//			$photo->delete();
		}

		return parent::delete();
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
