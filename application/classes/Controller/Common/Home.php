<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Common_Home extends Controller_Common {
    public $template='main';
    public $ajaxAllow =true;

    public function before(){
	parent::before();
//	View::bind_global('title',$this->title);
	View::set_global('title','shop');
//	$this->template->content='';
//	$this->template->navigator='';
//	$this->template->menu='';
//	$this->template->cart= NULL;
	
	$this->template->styles=array('bootstrap','common_v6');
	$this->template->breadcrumbs = '';
	
	$scripts = array();
	/* $cfs_file = Kohana::find_file('views', 'assets.json', FALSE);
	if($cfs_file){
		$assets = json_decode(file_get_contents(DOCROOT.'application/views/assets.json'), TRUE);
		$scripts = Arr::pluck($assets,'js');
		
	} */
//	Log::instance()->add(Log::NOTICE, Debug::vars($scripts));
	
	$this->template->scripts=$scripts;
//	$resultCss = Compress::instance('stylesheets')->styles(array('css/flags.css'),'css/out.css');
//	$this->template->resultCss = $resultCss;
//	I18n::lang('ru');	
	$lang = Lang::instance()->get();
//	Log::instance()->add(Log::NOTICE, Debug::vars($lang, I18n::lang()));
//	if($lang == 'ru'){
//	    I18n::lang('ru');	
//	} else {
//	    I18n::lang('en-us');		
//	}
    }
} 
