<?php

namespace app\models;

class Profile extends \app\core\Model {
  public $profile_id;
  public $user_id;
  public $first_name;
  public $middle_name;
  public $last_name;

    public function __construct() {
		parent::__construct();
    }

    public function insert(){
		$SQL = 'INSERT INTO profile(user_id, first_name, middle_name, last_name) VALUES (:user_id,:first_name,:middle_name,:last_name)';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['user_id'=>$this->user_id, 'first_name'=>$this->first_name, 'middle_name'=>$this->middle_name, 'last_name'=>$this->last_name]);//associative array with key => value pairs
	}

	public function get($user_id) {
		$SQL = 'SELECT * FROM profile WHERE user_id = :user_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['user_id' => $user_id]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Profile');
		return $STMT->fetch();
	}

	public function getWithProfile($profile_id) {
		$SQL = 'SELECT * FROM profile WHERE profile_id = :profile_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['profile_id' => $profile_id]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Profile');
		return $STMT->fetch();
	}

	public function update() {
		$SQL = 'UPDATE `profile` SET first_name=:first_name, middle_name=:middle_name, last_name=:last_name WHERE user_id = :user_id';//always use the PK in the where clause
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['first_name'=>$this->first_name, 'middle_name'=>$this->middle_name, 'last_name'=>$this->last_name, 'user_id' => $this->user_id]);//associative array with key => value pairs
	}

	public function search($string){
		$SQL = 'SELECT * FROM profile WHERE first_name LIKE :first_name OR middle_name LIKE :middle_name OR last_name LIKE :last_name';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['first_name' => "%$string%",'middle_name' => "%$string%",'last_name' => "%$string%"]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Profile');
		return $STMT->fetchAll();
	}
}