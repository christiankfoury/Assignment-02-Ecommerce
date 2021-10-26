<?php
namespace app\models;

class Picture extends \app\core\Model{
	public $picture_id;
	public $profile_id;
	public $filename;
	public $caption;

	public function __construct(){
		parent::__construct();
	}

	public function getAll(){
		$SQL = 'SELECT * FROM picture';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute([]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Picture');
		return $STMT->fetchAll();//returns an array of all the records
	}

	public function get($picture_id){
		$SQL = 'SELECT * FROM picture WHERE picture_id = :picture_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['picture_id'=>$picture_id]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Picture');
		return $STMT->fetch();//return the record
	}

	public function insert(){
		//here we will have to add `` around field names
		$SQL = 'INSERT INTO picture(profile_id, filename, caption) VALUES (:profile_id, :filename, :caption)';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['profile_id'=>$this->profile_id, 'filename'=>$this->filename, 'caption'=>$this->caption]);//associative array with key => value pairs
	}

	public function update(){//update an picture record but don't hange the FK value and don't change the picture filename either....
		$SQL = 'UPDATE `picture` SET `filename`=:filename WHERE picture_id = :picture_id';//always use the PK in the where clause
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['filename'=>$this->filename,'picture_id'=>$this->picture_id]);//associative array with key => value pairs
	}

	public function delete($picture_id){//delete a picture record
		$SQL = 'DELETE FROM `picture` WHERE picture_id = :picture_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['picture_id'=>$picture_id]);//associative array with key => value pairs
	}

}