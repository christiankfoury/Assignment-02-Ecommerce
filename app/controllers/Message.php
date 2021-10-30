<?php
namespace app\controllers;

class Message extends \app\core\Controller {

    #[\app\filters\Login]
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

    #[\app\filters\Login]
    public function readMessage($message_id){
        $message = new \app\models\Message();
        $message = $message->get($message_id);
        if($message->read_status == "unread" || $message->read_status == "to_reread"){
            $message->read_status = "read";
            $message->update();
        }
        $this->view('Message/readMessage',$message);
    }

    #[\app\filters\Login]
    public function toRereadMessage($message_id){
        $message = new \app\models\Message();
        $message = $message->get($message_id);
        $message->read_status = "to_reread";
        $message->update();

        $profile = new \app\models\Profile();
        $profile = $profile->get($message->receiver);
        header("location:/Profile/inbox");
    }

    #[\app\filters\Login]
    public function deleteMessage($message_id){
        $message = new \app\models\Message();
        $message = $message->get($message_id);
        $profile = new \app\models\Profile();
        $profile = $profile->get($message->sender);

        $message->delete();
        header("location:/Profile/outbox");
    }
}