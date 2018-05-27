<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Common_Home {
//    public $template ='template';
	protected $config = 'example';
	
//	public function before()
//	{
//		parent::before();
/*		$session = Session::instance('native');
		Cart::SetCartId();//		
		$this->_mCartId = $session->get('mCartId', false);
		// Set security headers
		$this->response
			->headers('x-content-type-options','nosniff')
			->headers('x-frame-options','SAMEORIGIN')
			->headers('x-xss-protection','1; mode=block');
		// Check if user is allowed to continue	

		if($this->request->query('lang')){
			if($this->request->query('lang') == 'ru' || $this->request->query('lang') == 'en-us'){
				Lang::instance()->set($this->request->query('lang'));
				$this->redirect($this->request->route()->uri(array(
					'controller'=> $this->request->controller(),
					'action'=>'index',
				)));
			}
		}
*/
//	}
		
	
    public function action_index(){
//		$this->title = Kohana::$config->load('personal.personal.title');	    
//	Kohana::message('forms','foobar');
//            throw new Kohana_Exception('That user does not exist.', NULL, 404);
        $message = __("Hello, Guest");
		$session = Session::instance();
//		Message::set('success', __('Form was successfully submitted.'));
//		$key='id_user';
//		$value="1018";
//		$session->set($key, $value);
//	$message = __('Hello, :user', array(':user'=>$username));
//	$message = $_SERVER['HTTP_HOST'];
//	$message = Debug::source(__FILE__, __LINE__);
//	$message = Debug::vars($username);
//	$data = 'test';
//	Cookie::set('test', $data);
//	Cookie::encrypt('test', $data);
//	$encrypt = Encrypt::instance('default');	
	
//	Kohana::$environment = Kohana::PRODUCTION;//10
//	Kohana::$environment = Kohana::DEVELOPMENT;//40
//	$message = Kohana::$environment;	    
//	$message = Kohana::$environment;

        $content = View::factory('/home/content');
//		$this->menu = Menu::factory($this->config);
		$this->menu = '';		
		
//		$this->template->content = '';		
//		$this->template->breadcrumbs = '';
        
//        $navigator=View::factory('/home/navigator')
//    	    ->set('message',$message);

 //       $this->template->navigator=$navigator;
//		$cart_quantity = NULL;
//		$cart_quantity = View::factory('/basket/navbar')->bind('quantity',$quantity);
//		$this->template->cart = $basket;
//		Kohana::auto_load('Kostache');
//		$renderer = Kostache::factory(); 
//				list($view_name, $view_path) = static::find_view($this->request);
//				Log::instance()->add(Log::NOTICE,$view_name);
//				if (Kohana::find_file('classes', $view_path))
//				{		
					
//				}
		
#		$headermenu = new View_headermenu_index(); 
		
#		$menu = $renderer->render($headermenu);		
//		$menu = View::factory('/personal/menu')
//			->set('lang',$lang);
		
#		$this->template->menu = $menu;		    
		/* $captcha = Captcha::instance('alpha');
		$captcha_image = $captcha->render(); */
//	    Log::instance()->add(Log::NOTICE, Debug::vars($captcha->render()));
//		$this->template->captcha = $captcha->image_render(TRUE);
//		$this->template->$captcha->image_render(TRUE);
//		$src = URL::base().'imagefly/w200-h200/1.jpg';
		$content = View::factory('home/content');
			/* ->bind('captcha_image',$captcha_image); */
//			->bind('src',$src);
	/* 	$jade = JadeView::factory('jtemplate',array('hello'=>'hello world')); */

//		$this->template->content = $jade->render();		

		/* $this->template->content =$content;

		$login = FALSE;
		if (Auth::instance()->logged_in('login'))
		{
		    $login = TRUE;
		} */

		/* $quantity = Helpers_Cart::getQuantity($this->_mCartId);
		$total_amount = Helpers_Cart::getTotal($this->_mCartId);
		$fixedTop = View::factory('fixed/top')
			->bind('quantity',$quantity)
			->bind('total_amount',$total_amount)
			->bind('login', $login);
		$this->template->fixedTop = $fixedTop; */
		
		/* $lang = Lang::instance()->get();
		$lang_title='';
		$lang_url='';
		if($lang == 'en-us'){
			$lang_title='Ru';
			$lang_url='?lang=ru';
		} else {
			$lang_title='En';
			$lang_url='?lang=en-us';
		}
		
		$navbar_items  = array(
			array(
				'url'=>'',
				'text'=>__('Home'),
				'active'=>Helpers_Navbar::home($this->request->uri()),
			),			
			array(
				'url'=>'catalog',
				'text'=>__('List Catalog'),
				'active'=>Helpers_Navbar::active($this->request->uri(),'catalog'),
			),	
			array(
				'url'=>'product',
				'text'=>__('List Product'),
				'active'=>Helpers_Navbar::active($this->request->uri(),'product'),
			),	
			array(
				'url'=>'basket',
				'text'=>__('Basket'),
				'active'=>Helpers_Navbar::active($this->request->uri(),'basket'),
			),
			array(
				'url'=>$lang_url,
				'text'=>$lang_title,
				'active'=>FALSE
			),
		
		); 
		$navbar = View::factory('navbar/home')
			->bind('navbar_items',$navbar_items);
		$this->template->navbar = $navbar; */
	
		    
    }



    
    public function action_contacts(){

    }

} // End 
