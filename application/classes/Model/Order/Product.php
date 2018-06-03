<?php defined('SYSPATH') or die('No direct script access.');

class Model_Order_Product extends ORM {
	
	protected $_belongs_to = array(
		'order' => array(
			'model' => 'Order',
		),
	);

	protected $_table_columns = array(
		'id'             => array('type' => 'int'),
		'order_id'       => array('type' => 'int'),
		'product_id'     => array('type' => 'int'),
		'product_name'   => array('type' => 'string'),
		'variation_id'   => array('type' => 'int'),
		'variation_name' => array('type' => 'string'),
		'quantity'       => array('type' => 'int'),
		'price'          => array('type' => 'float'),
	);

	public function rules()
	{
		return array(
			'order_id' => array(
				array('not_empty'),
				array('digit'),
//				array('gt', array(':value', 0)),
			),
			'product_id' => array(
				array('not_empty'),
				array('digit'),
//				array('gt', array(':value', 0)),
			),
			'product_name' => array(
				array('not_empty'),
			),
			'variation_id' => array(
				array('digit'),
			),
			'variation_name' => array(
				array('not_empty'),
			),
			'quantity' => array(
				array('not_empty'),
				array('digit'),
//				array('gt', array(':value', 0)),
			),
			'price' => array(
				array('not_empty'),
				array('numeric'),
//				array('gte', array(':value', 0)),
			),
		);
	}

	/**
	 * Overload save() to stop existing entries being edited
	 *
	 * @param   Validation  $validation
	 * @return  mixed
	 */
	public function save(Validation $validation = NULL)
	{
		if ($this->loaded())
			throw new Kohana_Exception('existing order products can not be modified');

		$this->product_name = DB::select('name')
			->from('products')
			->where('id', '=', $this->product_id)
			->execute()
			->get('name');

		$this->variation_name = DB::select('name')
			->from('product_variations')
			->where('id', '=', $this->variation_id)
			->execute()
			->get('name');

		return parent::save($validation);
	}

	/**
	 * Overload delete() to stop existing entries being deleted
	 *
	 * @return  mixed
	 */
	public function delete()
	{
		if ($this->loaded())
			throw new Kohana_Exception('existing order products can not be deleted');

		return parent::delete();
	}
}
