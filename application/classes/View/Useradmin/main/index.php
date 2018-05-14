<?php defined('SYSPATH') or die('No direct script access.');

class View_Useradmin_Main_Index {


	public function model()
	{
		return Inflector::humanize($this->model);
	}	




    public function message(){
	return 'Hello useradmin';	

    }   

	
}
