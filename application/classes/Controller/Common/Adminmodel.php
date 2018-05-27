<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Common_Adminmodel extends Controller_Common {
    public $template='admin';
    public $ajaxAllow =true;

    public function before(){
	parent::before();
//	View::bind_global('title',$this->title);
	View::set_global('title','admin');
//	$this->template->content='';
//	$this->template->navigator='';
//	$this->template->menu='';
//	$this->template->cart= NULL;
//	$this->template->scripts=array();
	$this->template->styles=array('bootstrap','common_v6');
//	$resultCss = Compress::instance('stylesheets')->styles(array('css/flags.css'),'css/out.css');
//	$this->template->resultCss = $resultCss;
//	I18n::lang('ru');	

    }
} 
