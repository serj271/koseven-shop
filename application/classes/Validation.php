<?php defined('SYSPATH') OR die('No direct script access.');

class Validation extends Kohana_Validation {


    public static function lt($sale_price, $price){//array
//		Log::instance()->add(Log::NOTICE, Debug::vars('lt ',$sale_price,$price[0]));
		return $sale_price <= $price[0];
//		return TRUE;
    }

    public static function gt($test, $value){//array
		return $test >= $value[0];
    }
	
    public function filters($name, $filters){
//		Log::instance()->add(Log::NOTICE, Debug::vars('model_commnets-',$name,$filters));
		/* return array(
			TRUE	=>array(  // for all  fields
				array('trim'),
#			array('strtolower'),
			),
//			'text' => array(
//				array($this, 'clearText')
//			),
//			'comment' => array(
//				array(array($this, 'clearText'))
//			),	

		); */
    }
}
