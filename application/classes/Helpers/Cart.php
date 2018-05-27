<?php defined('SYSPATH') or die('No direct script access.');
class Helpers_Cart {
    public static function getQuantity($mCartId=NULL) {
		
		if($mCartId){
			$carts = Cart::GetProducts($mCartId);
//			Log::instance()->add(Log::NOTICE, Debug::vars($carts));
//			$carts = $results->as_array();
			$quantity=0;
			if(count($carts)){
				foreach($carts as $cart){
					$quantity += $cart['quantity'];
				}
			}		
			return $quantity;			
		} 
		return FALSE;
    }
	public static function getTotal($mCartId=NULL) {
		if($mCartId){
			$total_amount = Cart::GetTotalAmount($mCartId);
			return $total_amount[0]['total_amount'];			
		} 
		return FALSE;
		
    }
}