<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Auth_User {
    protected $_table_name = 'users';
    protected $_primary_key = 'id';

    public function filters(){
		return array(
			TRUE	=>array(  // for all  fields
			array('trim'),
			),
	#	    'username'	=>array(
	#		array('strtolower'),
	#	    ),
	#	    'login_count'=>array(
	#		array('intval'),
	#	    ),
	#	    'text'	=>array(
	#		array('text::limit_chars',array(':value',100,'')),
	#	    ),
			'password'=>array(
			array(array(Auth::instance(), 'hash'))
			)
	#	    'password'=>array(
	#		array(array($this,'hash_password')),
	#	    )
		);
    }
    
//    public function ignored_columns(){
//	return array('password_confirm','password','logins');
//
//    }
    
    public function controls(){
	    return array(
			'username'=>'',
//			'email'=>'',
			'password'=>'',			
	    );    
    }


    public function labels()
    {
	return array(
	    'email'=>'email address',
	    'username'=>'account username'
	);
    }

    public function rules(){
		return array(
			'username'	=>array(
			array('not_empty'),
			array('min_length',array(':value',2)),
			array('max_length',array(':value',32)),
			array(array($this,'unique'),array('username',':value')),
			array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
			),
			'password'	=>array(
			array('not_empty'),
			array('min_length',array(':value',1)),
			array('max_length',array(':value',127)),
	//		array('matches',array(':validation','password','password_confirm')),
			),
			'email'	=>array(
			array('not_empty'),
			array('email'),		
			array('min_length',array(':value',2)),
			array('max_length',array(':value',127)),
			array(array($this,'unique'),array('email',':value')),
//			array('regex', array(':value', '/^[\pL\pN.]++$/uD')),
			),
		
	//	    'password_confirm'	=>array(
	//		array('matches',array(':validation',':field','password')),
	//	    ),
		);
    }
	// This class can be replaced or extended
    public function firstLetter($text){
	return ucfirst($text);     
    }

    public function clearText($text){
	return preg_replace('/ +/',' ',$text);
    }


    public function getUsers(){
		$model_user = ORM::factory('User');
		$users = $model_user->find_all();
		$usernames = array();
		foreach($users as $user){
			array_push($usernames, $user->username);
		}    
		return $usernames;
    }


} // End User Model