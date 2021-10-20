<?php
namespace app\controllers;

class Vaccine extends \app\core\Controller{

	public function index($animal_id){//listing the records related to an animal
		$myVaccine = new \app\models\Vaccine();
		$results = $myVaccine->getAll($animal_id);//get all shots for this one animal

		$myAnimal = new \app\models\Animal;
		$myAnimal = $myAnimal->get($animal_id);

		$this->view('Vaccine/index',['vaccines'=>$results,'animal'=>$myAnimal]);
	}


	public function insert($animal_id){//insert a new record ne known PK yet but I know the FK
		$animal = new \app\models\Animal;
		$animal = $animal->get($animal_id);
		if(isset($_POST['action'])){//verify that the user clicked the submit button
			$vaccine = new \app\models\Vaccine();
			$vaccine->animal_id = $animal_id;
			$vaccine->type = $_POST['type'];
			$vaccine->date = $_POST['date'];
			$vaccine->insert();
			//redirect the user back to the index
			header("location:/Vaccine/index/$animal_id");

		}else //1 present a form to the user
			$this->view('Vaccine/create',$animal);
	}

//continue from this point********
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

}