<?php defined('SYSPATH') or die('No direct script access.');

class Task_Adminmodel_Createview extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'action'   => 'read',
		'controller'=> 'Main',
	);
	
	protected function _execute(array $params)
	{				
		 
// var_dump($employee);
		$directory = 'Adminmodel';
		$controller = $params['controller'];
		$action = $params['action'];		
//		$model = 'Employee_Department';
			
//		Minion_CLI::write('create  path_view -'.$path_view);
		
/*create directory view from model file from action *******************	*/
		$path_view = 'classes/View/'.$directory.'/'.ucfirst($controller);		
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
		file_put_contents($file_path, $content);//create view class	

/* create template view from model file from action ******************* */
		$path_template = APPPATH.'templates/'.strtolower($directory).'/'.strtolower($controller);
		Minion_CLI::write('create  path_template -'.$path_template);
		if (!is_dir($path_template)) {
			mkdir($path_template, 0777, true);
			Minion_CLI::write('create template  ok -'.$path_template.'/'.strtolower($action).'.mustache');
		}
		$file_out = fopen($path_template.'/'.strtolower($action).'.mustache', "w") or die("Unable to open file!");
		fclose($file_out);

/*create directory navigator view from model file  *******************	*/
		/* $path_view = 'classes/View/'.$directory.'/'.ucfirst($controller);
		$file_view = ucfirst('navigator');
		$file_view_tpl = 'navigator';
		$twig = Twig::factory( 'twig/'.$file_view_tpl);
		$twig->php = "<?php";

		$class = str_replace('classes/','',$path_view.'/'.$file_view);
		$class = str_replace('/','_',$class);
		$twig->class = $class;
		$file = Kohana::find_file($path_view, $file_view,'php');//if exist source file
		if($file === FALSE){
//			$current = file_get_contents($file);
			$directory_view = APPPATH.$path_view;
			$file_path = $directory_view.'/'.$file_view.'.php';
			if (!is_dir($directory_view)) {
				mkdir($directory_view, 0777, true);									
				Minion_CLI::write('create view directory  -'.$path_view);
			}
			$file_out = fopen($file_path, "w") or die("Unable to open file!");
			fclose($file_out);
			$content = $twig->render();
			file_put_contents($file_path, $content);//create view class	
		} */

/* create template navigator view from model file  ******************* */
		/* $path_template = APPPATH.'templates/'.strtolower($directory).'/'.strtolower($controller);
		Minion_CLI::write('create  path_template -'.$path_template);
		if (!is_dir($path_template)) {
			mkdir($path_template, 0777, true);			
			Minion_CLI::write('create template  ok -'.$path_template.'.mustache');
		}
		$file_out = fopen($path_template.'/navigator'.'.mustache', "w") or die("Unable to open file!");
		fclose($file_out); */

	}
	
	
	
	
	
	
	
} // End Welcome
//  ./minion --help --task=createuser