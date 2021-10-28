<?php
namespace app\controllers;

class Message extends \app\core\Controller {
    
    public function createMessage($receiver){
        if(isset($_POST['action'])){
            $message = new \app\models\Message();
            $profile = new \app\models\Profile();
            $profile = $profile->get($_SESSION['user_id']);
            $message->sender = $profile->profile_id;
            $message->receiver = $receiver;
            $message->message = $_POST['message'];
            $message->private_status = $_POST['private_status'];
            $message->insert();
            header("location:/Profile/wall/$receiver");
        }
        else{
            $this->view('Message/createMessage');
        }
    }

    public function deleteMessage(){

    }
}