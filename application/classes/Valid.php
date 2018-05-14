<?php defined('SYSPATH') OR die('No direct script access.');

class Valid extends Kohana_Valid {
    public static function in_array_($key, $array){//array
	return array_key_exists($key, $array);
    }

}
