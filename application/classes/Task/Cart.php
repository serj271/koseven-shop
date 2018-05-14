<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Cart extends Minion_Task {
	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);
	
	private $cart_id;
	private $basket_id;
	private $model;

	protected function _execute(array $params)
	{
		spl_autoload_register(array('Kohana', 'auto_load'));
		set_error_handler(array('Kohana','error_handler'));
#		Kohana::$log->attach(new Log_File(APPPATH.'logs'));
#		set_exception_handler(array('Kohana_Exception_Handler','handle'));
		Kohana::$config->attach(new Config_File);		
		$db = Database::instance();	
		// Get the table name from the ORM model			
		
		$cart = Cart::instance();
		$productId = 1;
		$attributes = 'a';
		$this->model = 'Shopping_Cart';		
		$this->delete_item();
		
		$this->cart_id = md5(uniqid(rand(), true));
		
		
		$shopping_cart = ORM::factory($this->model);	
		$shopping_cart->cart_id = $this->cart_id;
		$shopping_cart->product_id = 1; 
		$shopping_cart->quantity = 2;
		$shopping_cart->attributes = 'a';
		
		try{			
			$product = ORM::factory('Product',$productId);
			
			$products_as_array = $product->as_array();
			
			Log::instance()->add(Log::NOTICE, Debug::vars($productId,$product->variations->find()->price));//get price
			$results = Cart::AddProduct(0,$productId, $attributes);
			foreach($results as $result){
				Minion_CLI::write('id cart - '.$result['cart_id'].' quontity '.$result['quantity']);			
			}
			
			$results = Cart::AddProduct(1,$productId, $attributes);
			$results = Cart::AddProduct(1,$productId, $attributes);
			foreach($results as $result){
				Minion_CLI::write('id cart - '.$result['cart_id'].' quontity '.$result['quantity']);			
			}
			$total = Cart::GetTotalAmount(1);//inCart
//			
			foreach($total as $result){
				Minion_CLI::write('total_amount -  '.$result['total_amount']);			
			}
			
			$products = Cart::GetProducts(0);
			Log::instance()->add(Log::NOTICE, Debug::vars($products));
//		$query = "call shopping_cart_add_product(1, 1, 'a')";
//			$query = "SELECT * from products";
//			$result = DB::query(Database::SELECT, $query)->execute();
			
			/* foreach($results as $result){
				$id = $result['id'];
				Minion_CLI::write('id create - '.$id);				
//				Log::instance()->add(Log::NOTICE, Debug::vars($result['product_id']));	
				$query = "call shopping_cart_remove_product(:inItemId)";
				$deleteId = DB::query(Database::SELECT, $query)->parameters(array(
					':inItemId'=>$id,					
				))->execute();	 *			
//				$results = $cart->deleteProduct($id);
//				$results = $cart->updateProduct($id,0);//id, quantity of product
				Log::instance()->add(Log::NOTICE, Debug::vars($results->as_array()));
//				Minion_CLI::write('id delete - '.$id);				
			}	 */
//				$query = "call shopping_cart_remove_product(:inItemId)";
//				
//				$query = "SELECT * from products";
//				while(DB::next_result()) DB::store_result();
/* 				DB::select()->from('products')->execute(); */
					

			
		}
		 catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
		}
		
		
		
		
		
	/* 	$this->model = 'Basket';
		
		$basket = ORM::factory($this->model);	
		
		$this->delete_item();
		
		
		try{			
			$basket = $basket->save();
			$this->basket_id = $basket->id;
			Minion_CLI::write('id create - '.$this->basket_id);
			
		}
		 catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
		}
		
		
		$this->model_list = 'Catalog_Basket_List';
		$basket_list = new Model_Basket_List();
		$basket_list->basket_id = $this->basket_id;
		$basket_list->product_id = 1;
		$basket_list->quantity = 1;
		
		try{			
			$basket_list = $basket_list->save();
			
			Minion_CLI::write('id basket_list create - '.$basket_list->id);
			
		}
		 catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
		}
		 */
		
		
		
		Minion_CLI::write('Create Cart instance');
		
		

	}
	
	

	protected function delete_item(){		
		$items = ORM::factory($this->model);		
		foreach($items->find_all() as $item)
		{
		   $item->delete();
		}
	}
	

}


//./minion --task=cart




