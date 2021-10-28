<?php

namespace app\models;

class Message extends \app\core\Model{
    public $message_id;
    public $sender;
    public $receiver;
    public $message;
    public $timestamp;
    public $read_status;
    public $private_status;

    public function __construct(){
        parent::__construct();
    }

    public function getAll(){
        $SQL = 'SELECT * FROM message';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute([]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Message');
		return $STMT->fetchAll();//returns an array of all the records
    }

    public function get($message_id){
        $SQL = 'SELECT * FROM message WHERE message_id = :message_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['message_id'=>$message_id]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Message');
		return $STMT->fetch();//return the record
    }

    public function insert(){
		//here we will have to add `` around field names
		$SQL = 'INSERT INTO message(sender, receiver, message, timestamp, read_status, private_status) 
        VALUES (:sender, :receiver, :message, :timestamp, :read_status, :private_status)';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['sender'=>$this->sender, 'receiver'=>$this->receiver,
        'message'=>$this->message,'timestamp'=>'UTC_TIMESTAMP()','read_status'=>'unread','private_status'=>$this->private_status]);
	}

    public function update(){//update an picture record but don't hange the FK value and don't change the picture filename either....
		$SQL = 'UPDATE `message` SET `read_status`=:read_status WHERE message_id = :message_id';//always use the PK in the where clause
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['read_status'=>$this->read_status,'message_id'=>$this->message_id]);//associative array with key => value pairs
	}

	public function delete($message_id){//delete a message record
		$SQL = 'DELETE FROM `message` WHERE message_id = :message_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['message_id'=>$message_id]);//associative array with key => value pairs
	}
}