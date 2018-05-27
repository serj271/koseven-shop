<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Common extends Controller_Template {
    public $template='main';
    public $ajaxAllow =true;

    public function before(){
	parent::before();
	View::set_global('title','shop-element');
	View::set_global('head','shop-element');
	$this->template->content='';
	$this->template->navigator='';
	$this->template->cart= NULL;
	$this->template->menu= '';
	$this->template->styles=array();
	$this->template->scripts=array();
	$this->template->fixedTop='';	
	$this->template->navbar='';	
	$header = View::factory('header/row');
	$this->template->header=$header;	
	$this->template->breadcrumbs = '';
	$lang = Lang::instance()->get();
	if($lang == 'ru'){
	    I18n::lang('ru');	
	} else {
	    I18n::lang('en-us');		
	}
//		$session = Session::instance('native');
//		Cart::SetCartId();//		
//		$this->_mCartId = $session->get('mCartId', false);



    }
    
//    public function after(){
//    	$header = View::factory('header/row');
//	$this->template->header=$header;	    
//    }
} 
