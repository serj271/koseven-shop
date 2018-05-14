<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Image extends ORM {
    // Table columns
    // Field nam e=> Label
    protected $_table_name = 'image';
    protected $_primary_key = 'id';

    protected $_table_columns = array(
		'id'=>'id',
		'caption'=>'name',
		'comment'=>'comment',		
		'contentSize'=>'size',
		'representativeOfPage' => 'representativeOfPage',
		'thumbnail'=>'thumbnail',   
//		'contentSize' => 'contentSize',
		'contentUrl'  => 'contentUrl',
		'thumbnailUrl' => 'thumbnailUrl',
		'height' => 'height',
		'width' =>'width',
		'position'=> 'position',
		'uploadDate' => 'uploadDate',  
    
    );
	
	public function __construct() {
		// load database library into $this->db (can be omitted if not required)
		parent::__construct();

//		$this->validation = new Validation($_POST);
//		$this->validation->pre_filter('trim','caption');
//		$this->validation->add_rules('clientName','required');
	}

    public function filters(){
		return array(
			TRUE	=>array(  // for all  fields
				array('trim'),
#			array('strtolower'),
			),
			'caption' => array(
				array(array($this, 'firstLetter'))
//				array(array($this, 'clearText'))
			),
			'comment' => array(
				array(array($this, 'clearText'))
			),	

		);
    }
    public function firstLetter($text){
		return ucfirst($text);     
    }

    public function clearText($text){
		return preg_replace('/ +/',' ',$text);
    }

    public function labels(){
		return array(
			'file'=>'File',
			'dscription'=>'Description',	
		);    
    }

    public function rules(){
		return array(
			'caption'	=>array(
			    array('not_empty', array(':value')),
			),
			'width'=> array(
				array('not_empty'),
				array('digit'),
//				array('gt', array(':value', 0)),
			),
				
		);
    }
    public function uploades_dir(){
		return DOCROOT.'uploads'.DIRECTORY_SEPARATOR;
    }
    public function file_save($file){
		$uploaded = Upload::save($file, $file['name'], $this->uploades_dir());
		if($uploaded){
			$this->set('file',$file['name']);
			$this->set('type',strtolower(pathinfo($file['name'],PATHINFO_EXTENSION)));
			$this->set('size',$file['size']);	
		}
		return $uploaded;
    }
    
	public function save(Validation $validation = NULL)
	{
//		$datalog = new DataLog($this->_table_name, $this->_original_values);
//		$parent = parent::save($validation);
//		$datalog->save($this->pk(), $this->_object, $this->_belongs_to);
		return parent::save();
	}
	
	public function delete(Validation $validation = NULL)
	{
//		$datalog = new DataLog($this->_table_name, $this->_original_values);
		$parent = parent::save($validation);
		$this->_object['contentSize'] = NULL;
//		$datalog->save($this->pk(), $this->_object, $this->_belongs_to);
		return parent::delete();
	}

	
	// This class can be replaced or extended


} // End User Model