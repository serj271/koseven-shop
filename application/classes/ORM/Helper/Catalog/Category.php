<?php defined('SYSPATH') or die('No direct script access.');

class ORM_Helper_Catalog_Category extends ORM_Helper_Property_Support {

	protected $_property_config = 'catalog.properties.category';
	protected $_safe_delete_field = 'delete_bit';
	protected $_on_delete_cascade = array('categories', 'items');
	
	protected $_position_fields = array(
		'position' => array(
			'group_by' => array('category_id'),
		),
	);

	protected $_file_fields = array(
		'image' => array(
			'path' => "upload/images/catalog/category",
			'uri'  => NULL,
			'on_delete' => ORM_File::ON_DELETE_RENAME,
			'on_update' => ORM_File::ON_UPDATE_RENAME,
			'allowed_src_dirs' => array(),
		),
	);
	
	public function file_rules()
	{
		return array(
			'image' => array(
//				array('Ku_File::valid'),
//				array('Ku_File::size', array(':value', '3M')),
//				array('Ku_File::type', array(':value', 'jpg, jpeg, bmp, png, gif')),
			),
		);
	}
}
