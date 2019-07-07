<?php

class View_Home_Index
{
	
	public function before() 
	{
		// Do inherited before
		parent::before();		
                /** otherstuff **/
		
//		$this->html = Kostache::factory('html');
	}
	public function after()
	{
		if ($this->view)
		{
//		$this->html->content     = $this->view;
//		$this->request->response = $this->html;
		}
		parent::after();
	}
	
	
    public function __construct(){
		$value=0;
//		$this->image = $image;
    }

//    public function contentUrl(){
//	return $this->image->contentUrl;
//    }  

	public function test(){
		return 'ok';
	}
   
}