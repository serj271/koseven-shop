<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Product_Description extends ORM {
protected $_table_name = 'image';
protected $_primary_key = 'id';

protected $_has_many = array(
		
	);

	protected $_table_columns = array(
			'id'=>'id',
			'product_id'=>'product_id',
			'language_id'=>'language_id',
			'name'=>'name',
			'description'=>'description',
			'meta_description'=>'meta_description',
			'meta_keyword'=>'meta_keyword',
	
	);
	
	public function labels()
	{
		return array(
			
		);
	}

	

	public function rules()
	{
		return array(
				'id'=>array(
			array('not_empty',array(':value')),
						array('digit'),
						),
				'product_id'=>array(
			array('not_empty',array(':value')),
						array('digit'),
						),
				'language_id'=>array(
			array('not_empty',array(':value')),
						array('digit'),
						),
				'name'=>array(
			array('not_empty',array(':value')),
						),
				'description'=>array(
			array('not_empty',array(':value')),
						),
				'meta_description'=>array(
			array('not_empty',array(':value')),
						),
				'meta_keyword'=>array(
			array('not_empty',array(':value')),
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
	
}
