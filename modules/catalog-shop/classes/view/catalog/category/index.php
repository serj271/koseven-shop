<?php defined('SYSPATH') or die('No direct script access.');

class View_Catalog_Category_Index {

    public function __construct(){	
		
		$this->value=6;
    }
    public $value=9;
    public $results = array();
    public $title;

    public $breadcrumbs = array();
     
    public $categories = array();  

    public $name='name';
	public function bold()
	{	    
		return function($text) {
//		    return ucfirst((string) $text);
			return '<b>'.$text.'</b>';
		};
	}

    public function linkUser()
	{
		return function($text)
		{
	//	    return "<a href='#'>".$text."</a>";
			return HTML::anchor('personalviewerproperty/id/'.$text, $text);
		};
    
    }

	public function anchor()
	{
		return function($text)
		{
		    return "<a href='#'>".$text."</a>";
//			return HTML::anchor($item['link'], $item['title']);
		};    
    }
	
	protected $_result;
	
	
	public function result(){
		if ($this->_result !== NULL)
			return $this->_result;
		
		$result = array();
		
		$result['rows'] = array();
		
		foreach ($this->categories as $category){
			
			$result['rows'][] = array(
					'category'		=> array('link'=>'r','title'=>'y'),
					'link'		=> function(){
						return HTML::anchor('e','e');
					},
//					'options' 	=> $options,
//					'values' 	=> $values,
				);
		}
//		Log::instance()->add(Log::NOTICE, Debug::vars($result));
		return $this->_result = $result;
	}
	

/* 
	public static function addBase($url){		
		return URL::base().$url;			
	} 	 */
	
    public $products = array();

    public function count_products(){
		return count($this->products);
    }
    
    














	
}
