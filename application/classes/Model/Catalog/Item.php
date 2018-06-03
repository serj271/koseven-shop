<?php defined('SYSPATH') or die('No direct script access.');

class Model_Catalog_Item extends ORM_Base {

	protected $_table_name = 'catalog_items';
//	protected $_sorting = array('sort' => 'ASC', 'title' => 'ASC');
//	protected $_deleted_column = 'delete_bit';
//	protected $_active_column = 'active';

//	protected $_belongs_to = array(
//		'category' => array(
//			'model' => 'catalog_Category',
	//		'foreign_key' => 'category_id',
//		),
//	);
	
	public function labels()
	{
		return array(
			'category_id' => 'Category',		
			'image_1' => 'Image 1',
			'image_2' => 'Image 2',		
			'description' => 'Desription',
		);
	}

	public function rules()
	{
		return array(
			'id' => array(
				array('digit'),
			),
			'category_id' => array(
				array('not_empty'),
				array('digit'),
			),
			'slug' => array(
				array('max_length', array(':value', 255)),
			),
			'sky' => array(				
				array('max_length', array(':value', 255)),
			),
			'brand' => array(				
				array('max_length', array(':value', 32)),
			),
			'uri' => array(
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 100)),
				array('alpha_dash'),
			),
			'image_1' => array(
				array('max_length', array(':value', 255)),
			),
			'image_2' => array(
				array('max_length', array(':value', 255)),
			),
			
		);
	}

	public function filters()
	{
		return array(
			TRUE => array(
				array('trim'),
			),
			'title' => array(
				array('strip_tags'),
			),
//			'uri' => array(
//				array('Ku_Text::slug'),
//			),
//			'active' => array(
//				array(array($this, 'checkbox'))
//			),

		);
	}
	
}
