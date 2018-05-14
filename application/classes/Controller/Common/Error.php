<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Common_Error extends Controller_Common {
//    public $template='main';
//    public $ajaxAllow =true;

    public function before(){
	parent::before();
	View::set_global('title','error');
	View::set_global('head','error');
//	$this->template->content='';
//	$this->template->navigator='';
//	$this->template->menu='';
	$this->template->styles=array('bootstrap.min','common_v6');
	$this->template->scripts=array('jquery','library');
//	$title=Kohana::$config->load('personal.user.title');	    
//	$this->template->title=$title;
//	$this->template->scripts=array('personal_v1');	
//	I18n::lang('ru');	
    }
} 
