<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Shopping cart
 *
 * @package   Kohana/Cart
 * @author    WinterSilence
 * 
 *   $product = array(
 *               'id'      => 123, //or use sku '123ABC'
 *               'qty'     => 2,
 *               'price'   => 39.95,
 *               'name'    => 'T-Shirt',
 *               'options' => array(
 *                             '123' => array'id' => 134, 'name' => 'Size', 'value' => 'XL'), 
 *                             '13'  => array'id' => 34, 'name' => 'Color', 'value' => 'Red'), 
 *                           ),
 *           );
 *
 *  id      - Identifier, typically this will be an "sku" or other such identifier.
 *  qty     - The quantity being purchased.
 *  price   - The price of the item.
 *  name    - The name of the item.
 *  options - Any additional attributes that are needed to identify the product. These must be passed via an array. 
 * 
 *  Example:
 *  $cart = Cart::instance();
 *  $cart->set($id, $qty, $options);
 *  $product = $cart->get($id, $options);
 *  $all_products = $cart->get(); or $cart->products // get all
 *  $name_first_product = $cart->products[0]['name'];
 *  $cart->delete($id); // delet item
 *  $cart->delete(); // delete all
 *  $total_cost     = $cart->total['cost'];
 *  $total_discount = $cart->total['discount'];
 *  $total_count    = $cart->total['count'];
 *  $cart->delete($id1)->set($id2, $qty2, $options2)->set($id3, $qty3);
 * 
 */
abstract class Model_Cart extends Model
{
	// Cart instance
	protected static $_instance;
	
	// Configuration
	protected $_config = array();
	
	// Session object
	protected $_session;
	
	// ORM product model
	protected $_model_product;
	
	// Cart items and total cost & count
	protected $_content = array();
	
	// Private clone method 
	protected function __clone(){}
	
	// Private wakeup method 
	protected function __wakeup(){}
	
	private static $_mCartId;
	
	// Protect construct method 
	protected function __construct()
	{
		// Load configuration
		$this->_config = Kohana::$config->load('cart')->as_array();
		
		// Load Session object
		$this->_session = Session::instance($this->_config['session']['type']);
		
		// Grab the shopping cart array from the session table, if it exists
		if ( ! $this->_content = $this->_session->get($this->_config['session']['key']))
		{
			// Cart not exists, set basic values
			$this->_content = array(
				'products' => array(),
				'total'    => array('cost' => 0, 'count' => 0, 'discount' => 0),
			);
		}
	}
	
	// Get instance of class
	public static function instance()
	{
		// Recreate object if you set new config
		if ( ! self::$_instance)
		{
			self::$_instance = new Cart;
		}
		return self::$_instance;
	}
	/* public function addProduct($cart_id,$product_id, $attributes){
		$query = "CALL shopping_cart_add_product(:cart_id, :product_id, :attributes)";
		return DB::query(Database::SELECT, $query)->parameters(array(
			':cart_id'=>$cart_id,
			':product_id'=>$product_id,
			':attributes'=>$attributes,
		))->execute();
	} */
		
	public static function UpdateProduct($inItemId,$inQuantity=1){
		$query = "call shopping_cart_update("."'$inItemId'".","."'$inQuantity'".")";
		$results = [];
		$result = $db->query(Database::SELECT, $query)->current();
		$results[] = $result;
		while($db->next_result()){
			$result = $db->query(Database::SELECT, $query)->current();
			$results[] = $result;
		}
		return $results;
	}
	
	public static function GetProducts($inCartId){
		$db = Database::instance();
		$query = "CALL shopping_cart_get_products("."'$inCartId'".")";
		$results = [];
		$result = $db->query(Database::SELECT, $query)->current();
		$results[] = $result;
		while($db->next_result()){
			$result = $db->query(Database::SELECT, $query)->current();
			$results[] = $result;
		}
		return $results;
	}
	
	public static function GetTotalAmount($inCartId){
		$db = Database::instance();
		$query = "CALL shopping_cart_get_total_amount("."'$inCartId'".")";
		$results = [];
		$result = $db->query(Database::SELECT, $query)->current();
		$results[] = $result;
		while($db->next_result()){
			$result = $db->query(Database::SELECT, $query)->current();
			$results[] = $result;
		}
		return $results;
	}
		
	public static function SaveProduct($inItemId){
		$query = "CALL shopping_cart_save_product_for_later("."'$inItemId'".")";
		$results = [];
		$result = $db->query(Database::SELECT, $query)->current();
		$results[] = $result;
		while($db->next_result()){
			$result = $db->query(Database::SELECT, $query)->current();
			$results[] = $result;
		}
		return $results;		
	}
	
	public static function MoveProduct($inItemId){//delete cart from shopping cart to id
		$query = "CALL shopping_cart_remove_product_to_cart("."'$inItemId'".")";
		$results = [];
		$result = $db->query(Database::SELECT, $query)->current();
		$results[] = $result;
		while($db->next_result()){
			$result = $db->query(Database::SELECT, $query)->current();
			$results[] = $result;
		}
		return $results;	
	}
		
	public static function AddProduct($cart_id,$product_id, $attributes)
	{
		$db = Database::instance();
		$query = "CALL shopping_cart_add_product("."'$cart_id'".","."'$product_id'".", "."'$attributes'".")";
		$results = [];
		$result = $db->query(Database::SELECT, $query)->current();
		$results[] = $result;
		while($db->next_result()){
			$result = $db->query(Database::SELECT, $query)->current();
			$results[] = $result;
		}
		return $results;
	}
	
	/**
	 * Magic Get to config & content 
	 *
	 * $cart->config->template_short
	 * $cart->content->products
	 */
	 
	 
	public function __get($key)
	{
//		Log::instance()->add(Log::NOTICE, Debug::vars('----------'.$key));
		if ($key == 'config' OR $key == 'content')
		{
			return $this->{'_'.$key};
		}
	}
	
	// Calc & get discount
	protected function _get_discount()
	{
		// TODO: 
	}
	
	// Set new total values
	protected function _set_total()
	{
		$this->_content['total'] = array('cost' => 0, 'count' => 0, 'discount' => 0);
		
		if ( ! empty($this->_content['products']))
		{
			foreach ($this->_content['products'] as $product)
			{
				$this->_content['total']['cost']  += $product['price'] * $product['qty'];
				$this->_content['total']['count'] += $product['qty'];
			}
			
			// Discount
			$this->_content['total']['discount'] = $this->_get_discount();
			$this->_content['total']['cost'] -= $this->_content['total']['discount'];
		}
		
		return $this;
	}
	
	// Save cart content
	protected function _save()
	{
		// recalc result
		$this->_set_total();
		// save in session
		$this->_session->set(
			$this->_config['session']['key'],
			$this->_content,
			$this->_config['session']['lifetime']
		);
		return $this;
	}
	
	// Generate complete id
	protected function _get_mix_id($id, array $options = array())
	{
		foreach ($options as $key => $value)
		{
			$id .= '_'.$key.':'.$value;
		}
		return $id;
	}
	
	/**
	 * Get product(s) with options from database
	 * TODO: add options
	 */
	protected function _get_product($id, $qty = 1, array $options = NULL)
	{
		// Create model only when it's needed
		if ( ! is_object($this->_model_product))
		{
			$this->_model_product = ORM::factory($this->_config['model_product']);
		}
		// Get product(s) in cart format
		return $this->_model_product->get_product($id, $qty, $options);
	}
	
	// Set(add) product(s) from cart content
	public function set($id, $qty = 1, array $options = NULL)
	{

		if (Arr::is_array($id))
		{
			// TODO: not work !
			$products = $this->_get_product(
				Arr::get($id, 'id'), 
				Arr::get($id, 'qty'),
				Arr::get($id, 'options')
			);
			// $products = $this->_get_product($id, $qty, $options);
			$products = $this->_get_product($id, $qty, $options);
		}
		else
		{
			$qty = max(1, $qty);
			$products[0] = $this->_get_product($id, $qty, $options);
		}
		
		foreach ($products as $product)
		{
			$product['options'] = Arr::get($product, 'options', array());
			// Composite identifier
			$mix_id = $this->_get_mix_id($product['id'], $product['options']);
			
			if (isset($this->_content['products'][$mix_id]))
			{
				if ($product['qty'] >= ($this->_content['products'][$mix_id]['qty'] + $qty))
				{
					$this->_content['products'][$mix_id]['qty'] += $qty;
				}
				else
				{
					throw new Kohana_Exception('In stock only :qty items', 
						array(':qty' => $product['qty']));
					// return FALSE;
				}
			}
			else
			{
				//$product['qty'] = $qty;
				$this->_content['products'][$mix_id] = $product;
			}
		}
		
		return $this->_save();
	}
	
	// Get product(s) from cart content
	public function get($id = NULL, array $options = NULL)
	{
		if (empty($id))
		{
			// Get all
			return $this->_content['products'];
		}
		else
		{
			// Get one
			$id = $this->_get_mix_id($id, $options);
			return $this->_content['products'][$id];
		}
	}
	
	// Delete product(s) from cart content
	public function delete($id = NULL, array $options = NULL)
	{
		if (empty($id)) 
		{
			// Delete all
			$this->_content['products'] = array();
		}
		else
		{
			// Delete one
			$id = $this->_get_mix_id($id, $options);
			unset($this->_content['products'][$id]);
		}
		return $this->_save();
	}
	
	public static function SetCartId()
	{
		$session = Session::instance();
		$key = 'mCartId';
	// If the cart ID hasn't already been set ...
		if (self::$_mCartId == '')
		{
			// If the visitor's cart ID is in the session, get it from there
			$mCartId = $session->get('mCartId');
//			if (isset ($_SESSION['cart_id']))
			if($mCartId)
			{
//				self::$_mCartId = $_SESSION['cart_id'];
				self::$_mCartId = $mCartId;
			}
			// If not, check whether the cart ID was saved as a cookie
			/* elseif (isset ($_COOKIE['cart_id']))
			{
				// Save the cart ID from the cookie
				self::$_mCartId = $_COOKIE['cart_id'];
				$_SESSION['cart_id'] = self::$_mCartId;
				// Regenerate cookie to be valid for 7 days (604800 seconds)
//				setcookie('cart_id', self::$_mCartId, time() + 604800);
			} */
			else
			{
				/* Generate cart id and save it to the $_mCartId class member,
				the session and a cookie (on subsequent requests $_mCartId
				will be populated from the session) */
				self::$_mCartId = md5(uniqid(rand(), true));
				$session->set($key, self::$_mCartId);
				// Store cart id in session
//				$_SESSION['cart_id'] = self::$_mCartId;
				// Cookie will be valid for 7 days (604800 seconds)
//				setcookie('cart_id', self::$_mCartId, time() + 604800);
			}
		}
	}
		
	public static function GetCartId()
	{
		// Ensure we have a cart id for the current visitor
		if (!isset (self::$_mCartId))
		self::SetCartId();
		return self::$_mCartId;
	}	
		
	
	
	
	
	
	
	
	
	
	
	
	
	
} // End Model_Cart