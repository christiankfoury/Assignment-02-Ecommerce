<?php
namespace app\models;

class Vaccine extends \app\core\Model{
	public $vaccine_id;
	public $animal_id;
	public $type;
	public $date;

	public function __construct(){
		parent::__construct();
	}

	public function getAll($animal_id){//be careful to restrict by parent
		$SQL = 'SELECT * FROM vaccine WHERE animal_id=:animal_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['animal_id'=>$animal_id]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Vaccine');
		return $STMT->fetchAll();//returns an array of all the records
	}

	public function get($vaccine_id){
		$SQL = 'SELECT * FROM vaccine WHERE vaccine_id = :vaccine_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['vaccine_id'=>$vaccine_id]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Vaccine');
		return $STMT->fetch();//return the record
	}

	public function insert(){
		//here we will have to add `` around field names
		$SQL = 'INSERT INTO vaccine(animal_id, type, date) VALUES (:animal_id, :type, :date)';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['animal_id'=>$this->animal_id,'type'=>$this->type,'date'=>$this->date]);//associative array with key => value pairs
	}

	public function update(){//update an vaccine record but don't hange the FK value
		$SQL = 'UPDATE `vaccine` SET `type`=:type,`date`=:date WHERE vaccine_id = :vaccine_id';//always use the PK in the where clause
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['type'=>$this->type,'date'=>$this->date,'vaccine_id'=>$this->vaccine_id]);//associative array with key => value pairs
	}

	public function delete($vaccine_id){//delete a vaccine record
		$SQL = 'DELETE FROM `vaccine` WHERE vaccine_id = :vaccine_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['vaccine_id'=>$vaccine_id]);//associative array with key => value pairs
	}

}