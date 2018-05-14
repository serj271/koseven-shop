<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Common_Useradmin extends Controller_Common {
    public $template='useradmin';
    public $ajaxAllow =true;

    public function before(){
	parent::before();
	View::set_global('title','useradmin');
	View::bind_global('page_title', $this->page_title);
	View::set_global('head','useradmin');
	$this->template->styles=array('bootstrap','common_v6');
	$this->template->scripts=array('vendor/jquery/jquery');
#	$title=Kohana::$config->load('personal.user.title');	    
#	$this->template->title=$title;
//	I18n::lang('ru');	
    }
} 
