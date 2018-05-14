<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Common_Product extends Controller_Common {
    public $template='main';
    public $ajaxAllow =true;

    public function before(){
	parent::before();
//	View::bind_global('title',$this->title);
	View::set_global('title','shop');
	$this->template->scripts=array();
	$this->template->styles=array('bootstrap','common_v6');
//	$resultCss = Compress::instance('stylesheets')->styles(array('css/flags.css'),'css/out.css');
//	$this->template->resultCss = $resultCss;
//	I18n::lang('ru');	
//	$lang = Lang::instance()->get();
//	Log::instance()->add(Log::NOTICE, $lang);
//	if($lang == 'ru'){
//	    I18n::lang('ru');	
//	} else {
//	    I18n::lang('en-us');		
//	}
    }
} 
