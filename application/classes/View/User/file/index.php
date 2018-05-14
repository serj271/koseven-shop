<?php

class View_User_File_Index	
{
    public function button(){    
	return Kohana::$config->load('personal.user.private.avatar.button');
    }
#    public $labelUsername;
#    public $username;
#    public $password;
   
}