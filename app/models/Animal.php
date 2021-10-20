<?php
namespace app\models;

class Animal extends \app\core\Model{
	public $species;
	public $colour;
	static $number;

	public function __construct(){
		parent::__construct();
		self::$number += 1;
	}

	public function getNumberOfAnimals(){
		return self::$number;
	}

	public function setSpecies($species){
		$this->species = $species;
	}

	public function getSpecies(){
		return $this->species;
	}

	public function setColour($colour){
		$this->colour = $colour;
	}

	public function getColour(){
		return $this->colour;
	}

	public function getAll(){
		$SQL = 'SELECT * FROM animal';
		$STMT = self::$_connection->query($SQL);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Animal');
		return $STMT->fetchAll();//returns an array of all the records
	}

	public function get($animal_id){
		$SQL = 'SELECT * FROM animal WHERE animal_id = :animal_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['animal_id'=>$animal_id]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Animal');
		return $STMT->fetch();//return the record
	}

	public function insert(){
		$SQL = 'INSERT INTO animal(species, colour) VALUES (:species,:colour)';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['species'=>$this->species,'colour'=>$this->colour]);//associative array with key => value pairs
	}

	public function update(){//update an animal record
		$SQL = 'UPDATE `animal` SET `species`=:species,`colour`=:colour WHERE animal_id = :animal_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['species'=>$this->species,'colour'=>$this->colour,'animal_id'=>$this->animal_id]);//associative array with key => value pairs
	}

	public function delete($animal_id){//update an animal record
		$SQL = 'DELETE FROM `animal` WHERE animal_id = :animal_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['animal_id'=>$animal_id]);//associative array with key => value pairs
	}

}