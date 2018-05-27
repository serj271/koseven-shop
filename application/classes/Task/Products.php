<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Products extends Minion_Task {
	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);
	
	private $product_id;
	private $photo_id;
	private $products = array();
	private $rating = 5;

	protected function _execute(array $params)
	{
		spl_autoload_register(array('Kohana', 'auto_load'));
		set_error_handler(array('Kohana','error_handler'));
#		Kohana::$log->attach(new Log_File(APPPATH.'logs'));
#		set_exception_handler(array('Kohana_Exception_Handler','handle'));
		Kohana::$config->attach(new Config_File);		
		$db = Database::instance();
		// Get the table name from the ORM model	
		$this->product_id = 1;
		$this->photo_id =1;
		$this->parent_id = 1;
		$this->catalog_category_id = 0;
		$this->catalog_id = 0;
		$this->level = 0;
		
		$modals = array('Product','Product_Photo','Product_Specification',
		'Product_Categories_Product','Catalog_Category','Product_Category');
		foreach($modals as $modal){
			$this->clear_model($modal);
		}			
			
		$this->clear_model();
		$this->clear_model('Catalog_Category');
			
		$this->create_product(
			$name='name product'.$this->product_id,
			$description='description product'.$this->product_id,
			$uri='uri_product_'.$this->product_id,
			$product_id = $this->product_id,
			$photo_id = $this->product_id
		);
	
		$this->create_catalog_category(
			$title = 'catalog_category title'.$this->catalog_category_id,
			$text = 'catalog_category text'.$this->catalog_category_id,
			$uri ='catalog_category_uri'.$this->catalog_category_id,
			$catalog_category_id = 0,//parent id
			$level = 0
		);
		
		$this->create_catalog_category(
			$title = 'catalog_category title'.$this->catalog_id,
			$text = 'catalog_category text'.$this->catalog_id,
			$uri ='catalog_category_uri'.$this->catalog_id,
			$catalog_category_id = $this->catalog_id,//parent id
			$level = 1
		);
		$this->add_category(1, $this->catalog_id);//product_id catalog_category_id
		
		$this->product_id = 2;
		$this->photo_id =2;
		$this->parent_id = 2;
			
		$this->create_product(
			$name='name product'.$this->product_id,
			$description='description product'.$this->product_id,
			$uri='uri_product_'.$this->product_id,
			$product_id = $this->product_id,
			$photo_id = $this->product_id
		);
		$this->add_category(2, $this->catalog_id);//product_id catalog_category_id
		
		/* $this->create_product($this->product_id,$this->photo_id);
		$this->create_photo($this->product_id,$this->photo_id);
		$this->product_reviews($this->product_id);
		$this->product_specification($this->product_id);
		
	
		$this->product_id = 3;
		$this->photo_id =3;
		$this->parent_id = 3;
		
		$this->create_product($this->product_id,$this->photo_id);
		$this->create_photo($this->product_id,$this->photo_id);
		$this->product_reviews($this->product_id);
		$this->product_specification($this->product_id);
		$this->create_variation(1);		 */
	
//		$this->create_category($this->parent_id);
			
		Minion_CLI::write('Create products instance');

	}
	
			
	protected function create_catalog_category($title='',$text='',$uri='',$catalog_category_id=0, $level =0)
	{		
		$catalog_category = ORM::factory('Catalog_Category');			
//		$catalog_category->id = $id;
		$catalog_category->catalog_category_id = $catalog_category_id;	
		$catalog_category->title = $title;		
		$catalog_category->text = $text;
		$catalog_category->level = $level;
		$catalog_category->uri = $uri;
		$file =  'media/img/category/'.$this->catalog_id.'.jpg';
		$with = 200;
		$height = 150;
		$text = 'Catalog_Category'.$this->catalog_id;
		$this->image_create($file, $with, $height, $text);
		$catalog_category->image = $file;
		
		try{			
			$category_item = $catalog_category->save();
			$this->catalog_id = $category_item->id;
			Minion_CLI::write('id create - '.$category_item->id);
		}
		catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
		} 
	}
	
	protected function add_category($product_id=NULL, $catalog_category_id=NULL){
		if($product_id){
			try
			{					
				$query = DB::insert('product_categories_products',array('product_id', 'catalog_category_id'))
					->values(array($product_id,$catalog_category_id));				
					$query->execute();						
				Minion_CLI::write('Create  product_categories_products  '.$product_id.' '.$catalog_category_id);
				
			}
			catch (ORM_Validation_Exception $e)
			{
	//			Minion_CLI::write(Kohana::message('product_variation', 'Validation::lt'));
	//			$errors = $extra_validation->errors('validation_', TRUE)	;	
				$errors = $e->errors();		
				foreach($errors as $key=>$value){
					Log::instance()->add(Log::NOTICE, Debug::vars($value));//+ field				
				}
				Minion_CLI::write($errors);		
				Log::instance()->add(Log::NOTICE, Debug::vars($e));//+ field			
			}
		}		
	}
	
	
	protected function product_reviews($product_id=1)
	{		
		$model = 'Product_Review';
		$orm = ORM::factory($model);
		$orm->id = $product_id;	
		$orm->product_id = $product_id;		
		$orm->name = 'name '.$product_id;
		$orm->rating = $this->rating;		
		$orm->summary = 'summary'.$product_id;
		$orm->body = 'body'.$product_id;
		$this->rating++;		

		try
		{			
			$orm_id = $orm->save();
			Minion_CLI::write('id create  product_reviews- '.$orm_id->id);		
		}
		 catch (ORM_Validation_Exception $e)
		{
//			Minion_CLI::write(Kohana::message('product_variation', 'Validation::lt'));
//			$errors = $extra_validation->errors('validation_', TRUE)	;	
			$errors = $e->errors();		
			foreach($errors as $key=>$value){
//				Log::instance()->add(Log::NOTICE, Debug::vars('Product_Review error',$key,$value));//+ field
				Minion_CLI::write($key.' -- '.$value[0]);						
			}					
		}
	}
		
	protected function product_specification($product_id=1)
	{		
		$model = 'Product_Specification';
		$orm = ORM::factory($model);				
//		$orm->id = 1;		
		$orm->name = 'name '.$product_id;	
		$orm->value = 'value'.$product_id;	
		$orm->product_id = $product_id;

		try
		{			
			$orm_id = $orm->save();			
//			Log::instance()->add(Log::NOTICE, Debug::vars($product->id));
			Minion_CLI::write('id create  Product_Specifications- '.$orm_id->id);			
		}
		 catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();		
			foreach($errors as $key=>$value){
//				Log::instance()->add(Log::NOTICE, Debug::vars('Product_Review error',$key,$value));//+ field
				Minion_CLI::write($key.' -- '.$value[0]);						
			}					
		}		
			
	}
	
	protected function create_variation($product_id=1)
	{		
		$model = 'Product_Variation';
		$variation_orm = ORM::factory($model);
//		$variation_orm->id = 1;
		$variation_orm->product_id = $product_id;
		$variation_orm->name = 'name variation '.$product_id;
		$variation_orm->price = $product_id * 10.00;
		$variation_orm->sale_price = $product_id * 8.00;
		$variation_orm->quantity = $product_id * 1;
		$variation_orm->discounted_price = 0;
		$external_values= array();		
		$extra_validation = Validation::factory($external_values);
//		$extra_validation->bind(':model', $variation_orm);
//		$extra_validation->rules('sale_price', array(
//			array('not_empty'),array('Validation::lt',array(':value'))
//		));
//		$extra_validation->rule('username', 'Validation::lt', array(':model'));
//		Log::instance()->add(Log::NOTICE, Debug::vars($extra_validation->check()));
//		Minion_CLI::write(Kohana::message('hello', 'hello_guest'));
	
		try
		{			
			$variation_id = $variation_orm->save($extra_validation);			
//			Log::instance()->add(Log::NOTICE, Debug::vars($product->id));
			Minion_CLI::write('id create  variation- '.$variation_id->id);
			
		}
		 catch (ORM_Validation_Exception $e)
		{
			Minion_CLI::write(Kohana::message('product_variation', 'Validation::lt'));
//			$errors = $extra_validation->errors('validation_', TRUE)	;	
			$errors = $e->errors();		
			foreach($errors as $key=>$value){
				Log::instance()->add(Log::NOTICE, Debug::vars('product_variation',$key,$value));//+ field				
			}
			Minion_CLI::write($errors);		
//			Log::instance()->add(Log::NOTICE, Debug::vars($errors));//+ field			
		}		
	}
	
	protected function create_product($name='', $description='', $uri='', $product_id=1, $photo_id=1)
	{
		$products_orm = ORM::factory('Product');	
		$products_orm->id = $product_id;
		$products_orm->name = $name;
		$products_orm->description = $description;
		$products_orm->primary_photo_id = $photo_id ;
		$products_orm->uri = $uri;
//		$products_orm->avg_review_rating = 
//		$products_orm->visible = '0';	
//		$rules = $products_orm->rules();
	
		
		try
		{			
			$product = $products_orm->save();		
//			Log::instance()->add(Log::NOTICE, Debug::vars($product->id));
			Minion_CLI::write('id create  products_orm- '.$products_orm->id);
			$this->create_photo($this->product_id,$this->photo_id);
			$this->product_reviews($this->product_id);
			$this->product_specification($this->product_id);
			$this->create_variation($this->product_id);
			
		}
		 catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();
			
			foreach($errors as $key=>$value){
//				Minion_CLI::write($key.$value);//+ field
//				$error_extact = Arr::extract($value, $rules);			
				Minion_CLI::write($key.' -- '.$value[0]);	
			}
//			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
		}		
	}
	
		
	protected function create_photo($product_id=1,$photo_id=1){
		$photos = ORM::factory('Product_Photo');	
		$photos->id = $photo_id;
		$photos->product_id = (int) $product_id;
		$path_fullsize =  'media/img/products/'.$product_id.'.jpg';
		$photos->path_fullsize = $path_fullsize;
				
		$path_thumbnail= 'media/img/thumbnail/'.$product_id.'.jpg';
		$photos->path_thumbnail = $path_thumbnail;
//		$image = new Image_GD(APPPATH.'media/img/22.jpg');
		$text = 'A Product_Photo '.$product_id;
		$with = 800;
		$height = 600;
		$this->image_create($path_fullsize, $with, $height, $text);
		$with = 200;
		$height = 100;
		$this->image_create($path_thumbnail, $with, $height, $text);
		
		try
		{			
			$photo = $photos = $photos->save();
			Minion_CLI::write('id create - photos '.$photos->id);
		
		}
		 catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
		}
	}

	
	protected function clear_model($model=NULL){
		if($model){
			$items = ORM::factory($model);
			foreach($items->find_all() as $item)
			{
			   $item->delete();
			}			
		}		
	}
	
	protected function image_create($file, $with, $height, $text){
		$file =  APPPATH.$file;
		if (is_file($file))
		{
			unlink($file);
			/* if ( ! is_writable($file))
			{
				throw new Kohana_Exception('File must be writable: :file',
					[':file' => Debug::path($file)]);
			} */
		}
			// Get the directory of the file
			$directory = realpath(pathinfo($file, PATHINFO_DIRNAME));
			if(! is_dir($directory))
			{
//				Directory does not exist, so lets create it.
				mkdir(dirname($file), 0755);
			}
			$directory = realpath(pathinfo($file, PATHINFO_DIRNAME));
			if (! is_writable($directory))
			{
				throw new Kohana_Exception('Directory must be writable: :directory',
					[':directory' => Debug::path($directory)]);
			}			
			
			$im = imagecreatetruecolor($with, $height);
			$bg = imagecolorallocate($im, 100, 100, 100);
			imagefill($im, 0, 0, $bg);
			$text_color = imagecolorallocate($im, 222, 222, 222);
			imagestring($im, 20, 25, 25, $text, $text_color);		
			imagejpeg($im, $file);
			imagedestroy($im);
	}
}







