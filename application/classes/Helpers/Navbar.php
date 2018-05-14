<?php defined('SYSPATH') or die('No direct script access.');
class Helpers_Navbar {
    public static function active($uri='', $uri_item='') {
		if($uri == $uri_item) return TRUE ;
		return FALSE;
    }
	public static function home($uri='', $uri_item='') {
		if($uri == '/') return TRUE ;
		return FALSE;
    }
}