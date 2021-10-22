<?php
namespace app\controllers;

class Main extends \app\core\Controller{

	public function index(){ //listing the records
		// //TODO: register session variables to stay logged in
		// if (isset($_POST['action'])) { //verify that the user clicked the submit button
		// 	$user = new \app\models\User();
		// 	$user = $user->get($_POST['username']);

		// 	if ($user != false && password_verify($_POST['password'], $user->password_hash)) {
		// 		$_SESSION['user_id'] = $user->user_id;
		// 		$_SESSION['username'] = $user->username;
		// 		header('location:/Secure/index');
		// 	} else {
		// 		$this->view('Main/login', 'Wrong username and password combination!');
		// 	}
		// } else //1 present a form to the user
		// 	$this->view('Main/login');
	}

	public function register(){
		if(isset($_POST['action']) && $_POST['password'] == $_POST['password_confirm']){//verify that the user clicked the submit button
			$user = new \app\models\User();
			$user->username = $_POST['username'];
			$user->password = $_POST['password'];
			$user->insert();//password hashing done here
			//redirect the user back to the index
			header('location:/Main/login');

		}else //1 present a form to the user
			$this->view('Main/register');
	}
	
	public function login(){
		//TODO: register session variables to stay logged in
		if(isset($_POST['action'])){//verify that the user clicked the submit button
			$user = new \app\models\User();
			$user = $user->get($_POST['username']);

			if($user!=false && password_verify($_POST['password'], $user->password_hash)){
				$_SESSION['user_id'] = $user->user_id;
				$_SESSION['username'] = $user->username;
				header("location:/Profile/create/$user->username");
			}else{
				$this->view('Main/login','Wrong username and password combination!');
			}

		}else //1 present a form to the user
			$this->view('Main/login');
	}


	public function logout(){
		//destroy session variables
		session_destroy();
		header('location:/Main/login');
	}

}