<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Db_Procedure extends Minion_Task {

	protected function _execute(array $params)
	{
				
		$db = Database::instance();
//		Log::instance()->add(Log::NOTICE, Debug::vars($db));
//		$db->disconnect();
//		Log::instance()->add(Log::NOTICE, Debug::vars($db));
		
		Minion_CLI::write('DB connect - ');
		$inCartId = 1;
		$inProductId = 1;
		$inAttributes = 0;
		/* $query = "CALL shopping_cart_add_product(0, 1, 0)";
		$q = DB::query(Database::SELECT, $query)->parameters(array(
//			':id'=>$inItemId,
		))->execute();
	
		$q = DB::query(Database::SELECT, $query)->parameters(array(
//			':id'=>$inItemId,
		))->execute();	 */
		/* $column = $db->quote_column(DB::expr('COUNT(`id`)'));
		Log::instance()->add(Log::NOTICE, Debug::vars($column->execute())); */
//		$query = DB::select(DB::expr("shopping_cart_add_product(0,1,0)"))
//			->from('shopping_cart')
//			->execute();
		/* if($result){
//			Log::instance()->add(Log::NOTICE, Debug::vars($result));
			foreach($result as $value){
//				Log::instance()->add(Log::NOTICE, Debug::vars($value));
			}
			
			
//			$db->close();
//			$result->next();
//			Log::instance()->add(Log::NOTICE, Debug::vars($result));
		} */
//		$db->connect();
		$query =  "call shopping_cart_add_product($inCartId,$inProductId,$inAttributes)";
		$result = $db->query(Database::SELECT,$query, true);
		Log::instance()->add(Log::NOTICE, Debug::vars($result->current()));
		$db->next_result();
		$result = $db->query(Database::SELECT,$query, true);
		Log::instance()->add(Log::NOTICE, Debug::vars($result->current()));
//		$result->next();
//		Log::instance()->add(Log::NOTICE, Debug::vars($result->current()));
//		$result->next();
//		Log::instance()->add(Log::NOTICE, Debug::vars($result->current()));
	
//			Log::instance()->add(Log::NOTICE, Debug::vars($result));
		
		
//		Database_MySQLi::disconnect();
		/* $result = DB::query(Database::SELECT,$query, $as_object=true)
			->parameters(array(
				':inCartId'=>$inCartId,
				':inProductId'=>$inProductId,
				':inAttributes'=>$inAttributes
			))
			->execute()->as_array();
		if($result){
			Log::instance()->add(Log::NOTICE, Debug::vars($result));
			foreach($result as $value){
				Log::instance()->add(Log::NOTICE, Debug::vars($value));
			}
		} */
		
		
		/* $db = new mysqli('localhost','user_db','123456s','shop');		
		if(mysqli_connect_errno()){
			echo mysqli_connect_error();
		}
		$user_arr = array();
		/* $result = $db->query("call shopping_cart_get_total_amount('0')");
		if($result){
			while ($row = $result->fetch_object()){
				$user_arr[] = $row;
			}
			Log::instance()->add(Log::NOTICE, Debug::vars($user_arr));
//			$result->close();
//			$db->next_result();
		}
		$result = $db->query("call shopping_cart_add_product(0,1,0)");
		if($result){
			while ($row = $result->fetch_object()){
				$user_arr[] = $row;
			}
			Log::instance()->add(Log::NOTICE, Debug::vars($user_arr));
//			$result->close();
//			$db->next_result();
		}
		$result = $db->query("call shopping_cart_add_product(0, 1, 0)");
		if($result){
			while ($row = $result->fetch_object()){
				$user_arr[] = $row;
			}
			Log::instance()->add(Log::NOTICE, Debug::vars($user_arr));
//			$result->close();
//			$db->next_result();
		} */
		
		
		
		



	}

}
