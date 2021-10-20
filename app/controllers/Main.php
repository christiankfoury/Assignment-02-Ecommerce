<?php
namespace app\controllers;

class Main extends \app\core\Controller{

	public function index(){//listing the records
		//instead of
		$myAnimal = new \app\models\Animal();

		$results = $myAnimal->getAll();

		//TODO: we want to get all models to extend a Model base class in app\core.
		//1- create a Model base class with a constructor method
		//2- extend this base class in your Animal model

		//note: the paths here are not subject to namespacing because these are NOT classes
		$this->view('Main/index',$results);
	}

	public function insert(){//insert a new record ne known PK yet
		//2 steps
		//2 get the information from the user and input it in the DB
		if(isset($_POST['action'])){//verify that the user clicked the submit button
			$animal = new \app\models\Animal();
			$animal->setSpecies($_POST['species']);
			$animal->setColour($_POST['colour']);
			$animal->insert();
			//redirect the user back to the index
			header('location:/Main/index');

		}else //1 present a form to the user
			$this->view('Main/addAnimal');
	}

	public function delete($animal_id){//delete a record with the known animal_id PK value
		$animal = new \app\models\Animal;
		$animal->delete($animal_id);
		header('location:/Main/index');
	}

	public function edit($animal_id){//edit a record for te record with known animal_id PK
		$animal = new \app\models\Animal;
		$animal = $animal->get($animal_id);

		if(isset($_POST['action'])){//am i submitting the form?
			//handle the input overwriting the existing properties
			$animal->setSpecies($_POST['species']);
			$animal->setColour($_POST['colour']);
			$animal->update();//call the update SQL
			//redirect after changes
			header('location:/Main/index');
		}else
			$this->view('Main/edit',$animal);
	}

	public function details($animal_id){
		$animal = new \app\models\Animal;
		$animal = $animal->get($animal_id);
		$this->view('Main/details',$animal);
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
				header('location:/Secure/index');
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