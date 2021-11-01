<?php
namespace app\models;

class User extends \app\core\Model{
	public $user_id;
	public $username;
	public $password_hash;
	public $password;
	public $two_factor_authentication;

	public function __construct(){
		parent::__construct();
	}

	public function get($username){
		$SQL = 'SELECT * FROM user WHERE username LIKE :username';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['username'=>$username]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\User');
		return $STMT->fetch();//return the record
	}

	public function insert(){
		$this->password_hash = password_hash($this->password, PASSWORD_DEFAULT);
		$SQL = 'INSERT INTO user(username, password_hash) VALUES (:username,:password_hash)';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['username'=>$this->username,'password_hash'=>$this->password_hash]);//associative array with key => value pairs
	}

	public function update() {
		$this->password_hash = password_hash($this->password, PASSWORD_DEFAULT);
		$SQL = 'UPDATE `user` SET password_hash=:password_hash WHERE user_id = :user_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['password_hash' => $this->password_hash, 'user_id' => $this->user_id]);//associative array with key => value pairs
	}

	public function updatetwofa() {
		$SQL = 'UPDATE `user` SET `two_factor_authentication`=:two_factor_authentication WHERE user_id = :user_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['two_factor_authentication'=>$this->two_factor_authentication, 'user_id' => $this->user_id]);//associative array with key => value pairs
	}
}