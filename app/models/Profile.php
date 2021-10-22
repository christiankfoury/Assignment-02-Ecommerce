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
}