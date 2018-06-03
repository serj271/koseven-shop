<?php

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
//date_default_timezone_set('America/Chicago');
date_default_timezone_set('Asia/Yekaterinburg');
/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(['Kohana', 'auto_load']);

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

/**
 * Enable composer autoload libraries
 */
// require DOCROOT . '/vendor/autoload.php';

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

if (isset($_SERVER['SERVER_PROTOCOL']))
{
	// Replace the default protocol.
	HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php", if set to FALSE uses clean URLS     index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init([
	'base_url'   => '/koseven-shop/',
	'index_file'	=> FALSE,
	'errors' => FALSE,
//	'expose'
//	'cache_life'=>
]);

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules([
	// 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'encrypt'    => MODPATH.'encrypt',    // Encryption supprt
	 'auth'       => MODPATH.'auth',       // Basic authentication
	 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'database'   => MODPATH.'database',   // Database access
	 'image'      => MODPATH.'image',      // Image manipulation
	 'minion'     => MODPATH.'minion',     // CLI Tasks
	 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	 'pagination' => MODPATH.'pagination', // Pagination
	 'unittest'   => MODPATH.'unittest',   // Unit testing
	 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
//	'mysqli'   	=> MODPATH.'mysqli',   // Database access
	'kostache'	=>MODPATH.'KOstache-master',
	'csv'		=>MODPATH.'CSV-master',
//	'menu'        	=> MODPATH.'menu', 
//	'captcha'        	=> MODPATH.'captcha',  	
//	'ecommerce'	=> MODPATH.'oz-ecommerce',        // Object Relationship Mapping
	'pagination'	=>MODPATH.'pagination',
	'breadcrumbs'=> MODPATH.'breadcrumbs',
	'message'=> MODPATH.'message',
//	 'datalog'  	=> MODPATH.'datalog',  // 
//	'imagefly' => MODPATH.'imagefly',
//	'imagemagick' => MODPATH.'imagemagick',  // Image manipulation
	'media'		=> MODPATH.'media',
	'upload'	=> MODPATH.'kohana-upload-storage-master',   // Upload access
	'twig' => MODPATH.'twig',
//	'catalog-shop'=> MODPATH.'catalog-shop',
//	'admin'=>MODPATH.'admin',
	]);

/**
 * Cookie Salt
 * @see  http://kohanaframework.org/3.3/guide/kohana/cookies
 *
 * If you have not defined a cookie salt in your Cookie class then
 * uncomment the line below and define a preferrably long salt.
 */
// Cookie::$salt = NULL;
Cookie::$salt= 'mysaltqweretsllslsldlksasa4345sa5d54a@@'; 
/**
 * Cookie HttpOnly directive
 * If set to true, disallows cookies to be accessed from JavaScript
 * @see https://en.wikipedia.org/wiki/Session_hijacking
 */
// Cookie::$httponly = TRUE;
/**
 * If website runs on secure protocol HTTPS, allows cookies only to be transmitted
 * via HTTPS.
 * Warning: HSTS must also be enabled in .htaccess, otherwise first request
 * to http://www.example.com will still reveal this cookie
 */
// Cookie::$secure = isset($_SERVER['HTTPS']) AND $_SERVER['HTTPS'] == 'on' ? TRUE : FALSE;

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
ini_set('display_errors', TRUE);

Route::set('home', '(/<action>/(<pole>(/<id>(/<overflow>))))')
	->defaults(array(
		'controller' => 'Home',
		'action'     => 'index',
	));

/* Route::set('product', 'product0(/<action>)(/<item_uri>)', array(
	'item_uri'=>'.*'
	))->defaults(array(
		'directory' =>'Product0',
		'controller' => 'Main',
		'action'     => 'index',
		'index_file' =>''
	)); */
Route::set('Product', 'product(/<item_uri>)',array(
	'item_uri'=>'.*'
	))	
	->defaults(
		array(
			'directory'=>'Product',
			'controller' => 'Main',
			'action' => 'index'
		)
	)
	->filter(
		function(Route $route, $params, Request $request) 			
		{
//			Log::instance()->add(Log::NOTICE, Debug::vars('route++',$route, $params));
			$count = 1;
			$uri = $request::detect_uri();
//			$uri = str_replace('product','', $uri);
			$uri = rtrim($uri, '/');
			$asParts = @ explode('/',$uri);
//			$directory = @ $asParts[0];
//			$controller = @ $asParts[1];
//			$action = @ $asParts[1];
			$item_uri = @ $asParts[1];
	
			if($item_uri == ''){
//				Log::instance()->add(Log::NOTICE, Debug::vars('uri',$uri));				
				return TRUE;
			}
			
			/* if(!$action){
				$action = 'index';
			} */
			$params['directory'] =	'Product';		
		/* 	$params['controller'] = ucfirst($controller); */
			$params['controller'] = 'Main';		
			$params['action'] = 'read';					
			$params['item_uri'] = $item_uri;
//		Log::instance()->add(Log::NOTICE, Debug::vars($params,$uri));
			return $params;			
		}
	); 
Route::set('user', 'user(/<controller>(/<action>(/<id>)))',array('id'=>'[0-9a-z]+'))
	->defaults(array(
		'directory' =>'user',
		'controller' => 'main',
		'action'     => 'index',
	));

	Route::set('ajax/catalog', 'ajax/catalog(/<controller>(/<action>(/<id>)))')
	->defaults(array(
		'directory' =>'Ajax/Catalog',
		'controller' => '<controller>',
		'action'     => 'index',
	)); 	
	
	
	
/* 
Route::set('page', 'useradmin/users(/index/<pole>/<page>)',array('page'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'useradmin',
		'controller' => 'users',
		'action'     => 'index',
	)); */

Route::set('useradmin', 'useradmin(/<controller>(/<action>(/<id>)))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'useradmin',
		'controller' => 'main',
		'action'     => 'index',
	));

	Route::set('ajax/useradmin', 'ajax/useradmin(/<controller>(/<action>(/<id>)))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'Ajax/Useradmin',
		'controller' => '<controller>',
		'action'     => 'index',
	));
	
	
//	Log::instance()->add(Log::NOTICE, Debug::vars(Request::current()->headers));
	

Route::set('Admin', 'admin(/<controller>(/<action>(/<id>)))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'Admin',
		'controller' => 'Main',
		'action'     => 'index',
	));
 
Route::set('Adminmodel', 'adminmodel(/<model>(/<action>(/<id>)))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'Adminmodel',
		'controller' => 'Main',
		'action'     => 'index',
	))
	->filter(
		function(Route $route, $params, Request $request) 			
		{
//			Log::instance()->add(Log::NOTICE, Debug::vars('route++',$route, $params));
		
			$uri = $request::detect_uri();
			$uri = rtrim($uri, '/');
			$asParts = @ explode('/',$uri);
			$prefix = @ $asParts[0];//adminmodel
			$model = @ $asParts[1];
			$action = @ $asParts[2];
			$id = @ $asParts[3];
	
			$models = Kohana::$config->load('adminmodel.models');
			if($model && !in_array($model, array_keys($models))){
				return FALSE;
			}
			
			$params['directory'] =	'Adminmodel';		
			$params['controller'] = 'Main';		
			$params['action'] = 'index';					
//			$params['item_uri'] = $item_uri;
		Log::instance()->add(Log::NOTICE, Debug::vars($params,$uri,$model,array_keys($models)));
			return $params;			
		}
	); 
Route::set('basket', 'basket(/<action>(/<id>))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'basket',
		'controller' => 'main',
		'action'     => 'index',
	));
/*
Route::set('admin/basket', 'admin/basket(/<action>(/<id>))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'admin',
		'controller' => 'basket',
		'action'     => 'index',
	));
Route::set('admin/product', 'admin/product(/<action>(/<id>))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'admin',
		'controller' => 'product',
		'action'     => 'index',
	));	 */
	
/*
Route::set('blog/stats', 'blog/stats/<action>(/<limit>)', array(
		'limit' => '\d+',
	))->defaults(array(
		'directory'  => 'blog',
		'controller' => 'stats',
	));
*/
 /* 
Route::set('comments', 'comments/<action>(/<id>(/<page>))(<format>)', array(
		'id'     => '\d+',
		'page'   => '\d+',
		'format' => '\.\w+',
	))->defaults(array(
		'directory' =>'comments',
		'controller' => 'main',
//		'group'      => 'default',
		'format'     => '.json',
	));

Route::set('comment', 'comment(/<controller>(/<action>(/<id>)))',array('id'=>'[0-9]+'))
	->defaults(array(
		'directory' =>'comment',
		'controller' => 'main',
		'action'     => 'index',
	)); */
	
 Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults([
		'controller' => 'Welcome',
		'action'     => 'index',
	]);





