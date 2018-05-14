<?php

class View_User_Headermenu_Index
{
	
		public function personalHead()
		{
			return __(Kohana::$config->load('user.headermenu.personal.head'));
		}
		
		public function personalHref()
		{
			return Kohana::$config->load('user.headermenu.personal.href');
		}


		public function avatarHead()
		{
			return __(Kohana::$config->load('user.headermenu.avatar.head'));			
		}

		public function avatarHref()
		{
			return Kohana::$config->load('user.headermenu.avatar.href');			
		}
		
		public function usersHead()
		{
			return __(Kohana::$config->load('user.headermenu.users.head'));			
		}

		public function usersHref()
		{
			return Kohana::$config->load('user.headermenu.users.href');			
		}
		
		public function loginHead()
		{
			return __(Kohana::$config->load('user.headermenu.login.head'));			
		}

		public function loginHref()
		{
			return Kohana::$config->load('user.headermenu.login.href');			
		}
		public function logoutHead()
		{
			return __(Kohana::$config->load('user.headermenu.logout.head'));			
		}

		public function logoutHref()
		{
			return Kohana::$config->load('user.headermenu.logout.href');			
		}
		public function registrationHead()
		{
			return __(Kohana::$config->load('user.headermenu.registration.head'));			
		}

		public function registrationHref()
		{
			return Kohana::$config->load('user.headermenu.registration.href');			
		}
   
		public function isAuth()
		{
		    if(Auth::instance()->get_user())
		    {
			return TRUE;
		    } else {
			return FALSE;
		    }		
		}   



}