<?php defined('SYSPATH') or die('No direct script access.');

class Task_Product_Createmodel extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'action'   => 'index',
		'controller'=> 'department',
	);

	private $enterprises = array();
	private $departments = array();
	private $employees = array();
	
	protected function _execute(array $params)
	{				
		/* $enterprise_orm = ORM::factory('Employee_Enterprise');				
		$department_orm = ORM::factory('Employee_Department'); */
 
// var_dump($employee);
		$directory = 'Product';
		$controller = $params['controller'];
		$action = $params['action'];		
		$model = 'Product_Description';
		$table_name = 'product_description';
		$path_model ='classes/Model';
		
		
		$file_controller_tpl = 'Template';
		$model_class = 'Desc';
		
		$twig = Twig::factory( 'twig/model/'.$file_controller_tpl);
		$twig->model = $model;
		$file = Kohana::find_file($path_model, $model_class,'php');//if exist source file
		if($file === FALSE){
			$file_out = fopen(APPPATH.$path_model.'/'.$model_class.'.php', 'w') or die('Error opening file: '+$file_name); 
			fclose($file_out);			
		}
//		$file = Kohana::find_file($path_model, $model_class,'php');
		$content = $twig->render();
		file_put_contents($file, $content);//create controller
		
		Minion_CLI::write('create model product description -');
		
		$db = Database::instance();
		$list_columns = $db->list_columns($db->table_prefix().$table_name);
		
		ORM::factory('Product_Description');
		
//		Log::instance()->add(Log::NOTICE, Debug::vars($list_columns));
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

/*   create controller from model ************* */
		/* $file_controller_tpl = 'controller';
		$controller_class = ucfirst($controller);
		$path_controller ='classes/Controller/'.$directory;	
//		Minion_CLI::write('create  path_controller -'.$path_controller);
		$twig = Twig::factory( 'twig/'.$file_controller_tpl);
		$twig->defined = "<?php defined('SYSPATH') or die('No direct script access.');";
		
		$twig->class = "Controller_Useradmin_$controller_class";
		$twig->extends = "Controller_Useradmin";
		$twig->model = $model;
		$file = Kohana::find_file($path_controller, $controller_class,'php');//if exist source file
		if($file === FALSE){
			$file_out = fopen(APPPATH.$path_controller.'/'.$controller_class.'.php', 'w') or die('Error opening file: '+$file_name); 
			fclose($file_out);			
		}
		$file = Kohana::find_file($path_controller, $controller_class,'php');
		$content = $twig->render();
		file_put_contents($file, $content);//create controller */
				
		
/*create directory view from model file from action *******************	*/
	/* 	$path_view = 'classes/View/'.$directory.'/'.ucfirst($controller);		
		$file_view = ucfirst($action);
		$directory_view = APPPATH.$path_view;
		$file_path = $directory_view.'/'.$file_view.'.php';
		$file_view_tpl = $action;
		$twig = Twig::factory( 'twig/view/'.$file_view_tpl);
		$twig->php = "<?php";

		$class = str_replace('classes/','',$path_view.'/'.$file_view);
		$class = str_replace('/','_',$class);
		$twig->class = $class;
		$file = Kohana::find_file($path_view, $file_view,'php');//if exist source file
		if($file === FALSE){
//			$current = file_get_contents($file);			
			if (!is_dir($directory_view)) {
				mkdir($directory_view, 0777, true);
			}
			
			$file_out = fopen($file_path, "w") or die("Unable to open file!");
			fclose($file_out);	
			Minion_CLI::write('create view directory  -'.$path_view);
		}
		$content = $twig->render();
		file_put_contents($file_path, $content);//create view class	 */

/* create template view from model file from action ******************* */
		/* $path_template = APPPATH.'templates/'.strtolower($directory).'/'.strtolower($controller);
		Minion_CLI::write('create  path_template -'.$path_template);
		if (!is_dir($path_template)) {
			mkdir($path_template, 0777, true);
			Minion_CLI::write('create template  ok -'.$path_template.'/'.strtolower($action).'.mustache');
		}
		$file_out = fopen($path_template.'/'.strtolower($action).'.mustache', "w") or die("Unable to open file!");
		fclose($file_out);


/* create template navigator view from model file  ******************* */
		/* $path_template = APPPATH.'templates/'.strtolower($directory).'/'.strtolower($controller);
		Minion_CLI::write('create  path_template -'.$path_template);
		if (!is_dir($path_template)) {
			mkdir($path_template, 0777, true);			
			Minion_CLI::write('create template  ok -'.$path_template.'.mustache');
		}
		$file_out = fopen($path_template.'/navigator'.'.mustache', "w") or die("Unable to open file!");
		fclose($file_out); */
		
//		$file = Kohana::find_file('views/twig', $file_controller_tpl,'php');//if exist source file		
//		$config = Kohana::$config->load('twig');
		
//		$twig = Twig::factory('twig/default');
//		$loader = new Twig_Loader_Filesystem(APPPATH.'views');
//		$twig = new Twig_Environment($loader, array(
//			'cache' => APPPATH.'cache',
//		));
//		$twig->load('twig/default.php');
//		$twig->defined = "<?php defined('SYSPATH') or die('No direct script access.');";
		
//		$class_name = ucfirst($model);
//		$twig->class = "Controller_Useradmin_$class_name";
		
//		$controller = $twig->render();
//		Log::instance()->add(Log::NOTICE, Debug::vars($controller,$twig));
//		file_put_contents($file, $controller);//create view class	
//		$path_tpl = APPPATH.'templates';
//		$templates = League/Plates/Engine::create($path_tpl); 
		
//		$view_file = fopen($path_view.'/'.$action.'.php', "w") or die("Unable to open file!");
/* 		$txt = "<?php defined('SYSPATH') or die('No direct script access.');";
		fwrite($view_file, $txt);
		$txt = "Jane Doe\n";
		fwrite($view_file, $txt); */
//		fclose($view_file);
//		Minion_CLI::write('create template conroller ok -');
	}
	
	
	
	
	
	
	
} // End Welcome
//  ./minion --help --task=createuser