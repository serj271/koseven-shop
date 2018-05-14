<?php

class View_User_Avatar
{
#    public $labelUsername;
    public $username;
    public function button(){    
	return Kohana::$config->load('personal.user.private.avatar.button');
    }
#    public $password;
   
}