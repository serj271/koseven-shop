

class Model_Product_Description extends ORM {
protected $_has_many = array(
		
	);

	protected $_table_columns = array(
		

	);
	
	public function labels()
	{
		return array(
			
		);
	}

	

	public function rules()
	{
		return array(
			

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