<?php defined('SYSPATH') or die('No direct script access.');

class ORM_Helper_Catalog_Element extends ORM_Helper_Property_Support {

	protected $_property_config = 'catalog.properties.element';
	protected $_safe_delete_field = 'delete_bit';
	protected $_file_fields = array(
		'image_1' => array(
			'path' => "upload/images/catalog/element",
			'uri'  => NULL,
			'on_delete' => ORM_File::ON_DELETE_RENAME,
			'on_update' => ORM_File::ON_UPDATE_RENAME,
			'allowed_src_dirs' => array(),
		),
		'image_2' => array(
			'path' => "upload/images/catalog/element",
			'uri'  => NULL,
			'on_delete' => ORM_File::ON_DELETE_RENAME,
			'on_update' => ORM_File::ON_UPDATE_RENAME,
			'allowed_src_dirs' => array(),
		),
	);

	public function file_rules()
	{
		return array(
			'image_1' => array(
//				array('Ku_File::valid'),
//				array('Ku_File::size', array(':value', '3M')),
//				array('Ku_File::type', array(':value', 'jpg, jpeg, bmp, png, gif')),
			),
			'image_2' => array(
//				array('Ku_File::valid'),
//				array('Ku_File::size', array(':value', '3M')),
//				array('Ku_File::type', array(':value', 'jpg, jpeg, bmp, png, gif')),
			),
		);
	}
	
	protected function _initialize_file_fields()
	{
		$this->_file_fields['image_1']['allowed_src_dirs'] = array( DOCROOT.'upload/tmp/' );
		$this->_file_fields['image_2']['allowed_src_dirs'] = array( DOCROOT.'upload/tmp/' );
	
		parent::_initialize_file_fields();
	}
}
