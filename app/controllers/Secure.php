<?php

// change the database to include a "role" field that can be set to "user" or "admin"
// add the proper session variable(s) to remember the role in the application
// add a filter to prevent normal users from accessing parts reserved to the "admin"
// demonstrate with a controller of your choice


namespace app\controllers;

#[\app\filters\Login]
class Secure extends \app\core\Controller{

	//application of the Login attribute to enable login checks
	
	public function index(){
		echo 'actually secure';
	}

	public function alsosecure(){
		echo 'not secure';
	}
	
	public function hello(){
		echo 'hello';
	}

}