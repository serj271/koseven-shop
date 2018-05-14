<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Catalog_Category extends Controller_Catalog {
	protected $_model = 'Catalog_Category';
	

	public function action_index(){	
		$request = $this->request->current();
		$query_controller = $request->query('controller');		
		$uri = $this->request->param('category_uri');
		$uri = rtrim($uri, '/');
		if($uri == 'catalog'){					
//			return TRUE;
		}
		$asParts = @ explode('/',$uri);
		$prefix = @ $asParts[0];
//		$action = @ $asParts[1];
		if($prefix !== 'catalog'){
//			return FALSE;
		}		
		
		$uri = str_replace('catalog/','', $uri);	
//		if (!in_array($uri, $categories)) {
//			return FALSE;
//		}	
		$category_uri = $asParts[count($asParts)-1];
		$category = ORM::factory('Catalog_Category')
			->where('uri','=',$category_uri)->find();//category_uri unique must be
			
		$categories = ORM::factory('Catalog_Category')->find_all()->as_array();	//uri => title
	
//		$products = $category->products->find_all();		
//		$this->view->products = $products;		
//		$brearcrBreadcrumb = Breadcrumb::factory()->set_title("Added Crumb")->set_url("http://example.com/");
		Breadcrumbs::add(array('home',URL::base()));
		Breadcrumbs::generate_from_request($this->request);
//		Breadcrumbs::clear();
		foreach (Breadcrumbs::get() as $breadcrumb){
			foreach($categories as $cat){
				if($breadcrumb->get_title() == $cat->uri){
					$breadcrumb->set_title($cat->title);
				}
			}				
		}

		
		$this->template->breadcrumbs = Breadcrumbs::render("breadcrumbs/layout");
		
//		$this->view->breadcrumbs = Breadcrumbs::get();
//		Log::instance()->add(Log::NOTICE, Debug::vars('read',Breadcrumbs::get()));
		/* $breadcrumbs = array();
		foreach (Breadcrumbs::get() as $breadcrumb){
			$breadcrumbs[] = array('title'=>$breadcrumb->get_title(),'url'=>$breadcrumb->get_url());			
		} */
//		Log::instance()->add(Log::NOTICE, Debug::vars('breadcrumb',Breadcrumbs::get()));
//		$this->view->breadcrumbs = Breadcrumbs::get();
//		$this->view->breadcrumbs = Breadcrumbs::render();
//		$this->view->countBreadcrumbs = count($breadcrumbs)
//		$sep = Kohana::$config->load('breadcrumbs.separator');


	/* 	Breadcrumbs::template('breadcrumbs/bootstrap');
		Breadcrumbs::set('/','Home');
		Breadcrumbs::set_auto($this);
		$data = array(
//			'template' => 'breadcrumbs_template_path',
			'items' => array(
				'/posts/'    => 'Posts',
				'/post/124/' => 'Post 124 title',				
			),
		);
		$this->template->breadcrumbs = Request::factory('breadcrumbs')->query($data)->execute()->body(); */
	
		$config = Kohana::$config->load('pagination.default');
		$count = $category->products
				->count_all();
			$pagination = Pagination::factory(array(
				'items_per_page'=> $config['items_per_page'],
				'total_items' 	=> $count,
			))->route_params(array(
				'directory' 	=> $this->request->directory(),
				'controller' 	=> $this->request->controller(),
				'action'		=> $this->request->action(),
				'category_uri'	=> $uri,
				'pole'			=>'id',
				'view'			=> $config['view'],
				));
				
//			$products_orm = ORM::factory('Product')
			$products = $category->products
				->limit($pagination->items_per_page)
				->offset($pagination->offset)
				->order_by('id')
				->find_all();
				
			$result = array();
			foreach ($products as $product){
				$products_as_array = $product->as_array();				
				$photo = $product->primary_photo()->as_array();
				$photo = Arr::map(array(array(__CLASS__,'addBase')), $photo, array('path_fullsize','path_thumbnail'));
				$products_as_array['photo'] = $photo;
				$reviews = $product->reviews->find()->as_array();
				$specifications = $product->specifications->find()->as_array();
				$products_as_array['specifications'] = $specifications;
				$products_as_array['reviews'] = $reviews;
				$link = $this->createLink($product->uri);
				$products_as_array['link'] = $link;
				$variations = $product->variations->find();
				$products_as_array['variations'] = $variations;
				$result[] = $products_as_array;	
			}
			if(empty($result)){
	/* 			$this->view->pagination = $pagination;
				$this->view->products = $products;
				$this->view->product = $result;	 */	
				if($uri == ""){
					$categories_orm = ORM::factory('Catalog_Category')->where('level','=','0')->find_all();
					
					
				
				} else {
					$category_from_uri = ORM::factory('Catalog_Category')->where('uri','=',$category_uri)->find();
					$categories_orm = ORM::factory('Catalog_Category')->where('catalog_category_id','=',$category_from_uri->id)->find_all();
				}				
					$category_list = array();
					
						
						foreach ($categories_orm as $_category){
							$category = new stdClass;
							$link = Route::get('catalog/main')->uri(array(
								'directory' =>'catalog',
								'controller' => 'category',
								'action'     => 'index',
								'category_uri' => $uri.'/'.$_category->uri
							));								
//							Log::instance()->add(Log::NOTICE,Debug::vars('link',$link));
							$category->title = $_category->title;
							$category->link = URL::base().$link;							
							$category_list[] = $category;
						}						
									
					$this->view->categories = $category_list;					
//					Log::instance()->add(Log::NOTICE,Debug::vars('category_list+-----',$category_list));
			} else {
				$this->view->pagination = $pagination;
				$this->view->products = $products;
				$this->view->product = $result;				
			}
			
//			Log::instance()->add(Log::NOTICE,Debug::vars('+++++++-----',$uri));
	}
	
	public static function addBase($url){
		return URL::base().$url;			
	} 
	/* public static function createUri($id){
		$categories = ORM::factory('Catalog_Category')->where('catalog_category_id','=',$id)->find_all();
//		Log::instance()->add(Log::NOTICE,Debug::vars($categories->as_array()));
		$list_category = array();
		$category = new stdClass;
		foreach($categories as $i){
			$category->uri = $i->uri;
			$category->title = $i->title;
			$list_category[] = $category;
			
		}
		$link = Route::get('catalog/main')->uri(array(
			'directory' =>'catalog',
			'controller' => 'category',
			'action'     => 'index',
			'category_uri' => $uri			
		));
		return $list_category;		
	} */
	public static function createLink($uri){//get one product
		$link = Route::get('product')->uri(array(
			'directory' =>'product',
			'controller' => 'main',
			'action'     => 'read',
			'item_uri' => $uri			
		));//URL::site('product');
		return URL::base().'product/read/'.$uri;			
	} 
	
} // End Controller_Catalog

