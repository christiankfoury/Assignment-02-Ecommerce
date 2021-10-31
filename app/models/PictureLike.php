<?php

namespace app\models;

class PictureLike extends \app\core\Model
{
    public $picture_id;
    public $profile_id;
    public $timestamp;
    public $read_status;

    public function __construct()
    {
        parent::__construct();
    }

    public function get($picture_id)
    {
        $SQL = 'SELECT * FROM picture_like WHERE picture_id = :picture_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['picture_id' => $picture_id]);
        $STMT->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Picture');
        return $STMT->fetch(); //return the record
    }

    public function getNumberOfLikes($picture_id) {
        $SQL = 'SELECT COUNT(*) FROM picture_like WHERE picture_id = :picture_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['picture_id' => $picture_id]);
        return $STMT->fetch(); //return the record
    }

    public function isLiked($picture_id, $profile_id) {
        $SQL = 'SELECT * FROM picture_like WHERE picture_id = :picture_id AND profile_id = :profile_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['picture_id' => $picture_id, 'profile_id'=>$profile_id]);
        return $STMT->fetch(); //return the record
    }

    public function insert()
    {
        //here we will have to add `` around field names
        $SQL = 'INSERT INTO picture_like(picture_id,profile_id,timestamp,read_status) VALUES (:picture_id,:profile_id,:timestamp,:read_status)';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['picture_id'=>$this->picture_id,'profile_id'=>$this->profile_id,'timestamp'=>'UTC_TIMESTAMP()','read_status'=>'unseen']); //associative array with key => value pairs
    }

    // TODO

    // public function update()
    // { //update an picture record but don't hange the FK value and don't change the picture filename either....
    //     $SQL = 'UPDATE `picture` SET `filename`=:filename WHERE picture_id = :picture_id'; //always use the PK in the where clause
    //     $STMT = self::$_connection->prepare($SQL);
    //     $STMT->execute(['filename' => $this->filename, 'picture_id' => $this->picture_id]); //associative array with key => value pairs
    // }

    public function delete()
    {
        $SQL = 'DELETE FROM `picture_like` WHERE picture_id = :picture_id AND profile_id = :profile_id';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['picture_id' => $this->picture_id,'profile_id'=>$this->profile_id]); //associative array with key => value pairs
    }

    public function getUnreadLikes($picture_id){
        $SQL = 'SELECT COUNT(*) FROM picture_like WHERE picture_id = :picture_id AND read_status = :read_status';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['picture_id' => $picture_id,'read_status'=>'unseen']);
        return $STMT->fetch(); //return the record
    }

    public function getUnseenLikes($picture_id) {
        $SQL = 'SELECT * FROM picture_like WHERE picture_id = :picture_id AND read_status = :read_status ORDER BY timestamp DESC';
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['picture_id' => $picture_id,'read_status'=>'unseen']);
        $STMT->setFetchMode(\PDO::FETCH_CLASS, 'app\\models\\Picture');
        return $STMT->fetchAll(); //return the record
    }

    public function updateNotificationSeen($picture_id, $profile_id) {
        $SQL = 'UPDATE picture_like SET read_status=:read_status WHERE picture_id = :picture_id AND profile_id = :profile_id'; //always use the PK in the where clause
        $STMT = self::$_connection->prepare($SQL);
        $STMT->execute(['read_status' => "seen", 'picture_id' => $picture_id, 'profile_id'=>$profile_id]); //associative array with key => value pairs
    }
}
