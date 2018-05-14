<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Common_Basket extends Controller_Common {
    public $template='main';
    public $ajaxAllow =true;

    public function before(){
	parent::before();
	View::set_global('title','basket');
	View::bind_global('page_title', $this->page_title);
	View::set_global('head','basket');
//	$this->template->content='';
//	$this->template->navigator='';
//	$this->template->menu='';
//	$this->template->cart= NULL;
	$this->template->styles=array('bootstrap.min','common_v6','basket');
	$this->template->scripts=array('jquery');
#	$title=Kohana::$config->load('personal.user.title');	    
#	$this->template->title=$title;
//	$this->template->scripts=array('personal_v1');	
//	I18n::lang('ru');	
	
//	$this->template->breadcrumbs = '';
	
    }
} 
