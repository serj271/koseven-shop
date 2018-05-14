<?php defined('SYSPATH') or die('No direct script access.');
class Validate extends Kohana_Validate {
    public function errors($file=NULL,$translate=TRUE){
	if($file){
	    return parent::errors($file,$translate);
	}
	$messages=array();
	foreach($this->_errors as $field=>$set){
	    list($error,$params)=$set;
	    $message=Kohana::message($file,"{$field}.{$error}");
	}
	$messages[$field]=$mesage;
    }
    return $messages;

} // End a 
