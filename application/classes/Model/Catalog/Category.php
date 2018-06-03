<?php defined('SYSPATH') or die('No direct script access.');

class Model_Catalog_Category extends ORM_Base {

	protected $_table_name = 'catalog_categories';
	protected $_sorting = array('position' => 'ASC');
	protected $_deleted_column = 'delete_bit';
	protected $_active_column = 'active';
	protected $_primary_id='id';

	protected $_has_many = array(
//		'items' => array(
//			'model' => 'Catalog_Element',
//			'foreign_key' => 'category_id',
//		),
		'categories' => array(
			'model' => 'Catalog_Category',
			'foreign_key' => 'catalog_category_id',
		),
		    'products' => array(
			'model'       => 'Product',
			'through' => 'product_categories_products',
			'far_key'=>'product_id',
//			'foreign_key' => 'product_id',
		    ),

	);
	
	protected $_belongs_to = array(
		'parent' => array(
			'model' => 'Catalog_Category',
			'foreign_key' => 'catalog_category_id',
		),
	);

	public function labels()
	{
		return array(
			'catalog_category_id' => 'Category',
			'level' => 'Level',
			'uri' => 'URI',
			'code' => 'Code',
			'title' => 'Title',
			'image' => 'Image',
			'text' => 'Text',
			'active' => 'Active',
			'position' => 'Position',
//			'title_tag' => 'Title tag',
//			'keywords_tag' => 'Keywords tag',
//			'description_tag' => 'Desription tag',
		);
	}

	public function rules()
	{
		return array(
			'id' => array(
				array('digit'),
			),
			'catalog_category_id' => array(
				array('not_empty'),
				array('digit'),
			),
			'level' => array(
				array('digit'),
			),
			'uri' => array(
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 255)),
				array('alpha_dash'),
				array(array($this, 'check_uri')),
			),
			'code' => array(
				array('max_length', array(':value', 255)),
				array('alpha_dash'),
			),
			'title' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 255)),
			),
			'image' => array(
				array('max_length', array(':value', 255)),
			),
			'position' => array(
				array('digit'),
			),
			'title_tag' => array(
				array('max_length', array(':value', 255)),
			),
			'keywords_tag' => array(
				array('max_length', array(':value', 255)),
			),
			'description_tag' => array(
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
//			'uri' => array(
//				array('Ku_Text::slug'),
//			),
			'title' => array(
				array('strip_tags'),
			),
//			'active' => array(
//				array(array($this, 'checkbox'))
//			),
			'title_tag' => array(
				array('strip_tags'),
			),
			'keywords_tag' => array(
				array('strip_tags'),
			),
			'description_tag' => array(
				array('strip_tags'),
			),
		);
	}
	
	public function check_uri($value)
	{
		if ( ! $this->active) {
			return TRUE;
		}
	
		$orm = clone $this;
		$orm->clear();
	
		if ($this->loaded()) {
			$orm
				->where('id', '!=', $this->id);
		}
	
		$orm
			->where('catalog_category_id', '=', $this->category_id)
			->where('uri', '=', $this->uri)
			->where('delete_bit', '=', 0)
			->find();
	
		return ! $orm->loaded();
	}
	private function parse_categories(array $list)
	{
		$result = array();
		foreach ($list as $_orm) {
			$_item = array(
				'id' => $_orm->id,
				'code' => $_orm->code,
				'title' => $_orm->title,
			);
			
			if ($_orm->level == 0) {
				$_item['path'] = array(
					$_orm->title
				);
			} elseif (array_key_exists($_orm->category_id, $result)) {
				$_item['path'] = $result[$_orm->category_id]['path'];
				$_item['path'][] = 	$_orm->title;
			} else {
				continue;
			}
			
			$result[$_orm->id] = $_item;
		}
		
		return $result;
	}

}
