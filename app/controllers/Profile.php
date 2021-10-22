<?php

namespace app\controllers;

class Profile extends \app\core\Controller {

    public function create($username) {
        $profile = new \app\models\Profile();
        $user = new \app\models\User();
        $user = $user->getUser_id($username);
        if ($profile->get($user->user_id) == false) {
            if(isset($_POST['action'])) {
                if (!$_POST['first_name'] || !$_POST['last_name']) {   
                    $this->view('/Profile/create', "First name and last name must not be empty");
                }
                else {
                    $profile->user_id = $user->user_id;
                    $profile->first_name = $_POST['first_name'];
                    $profile->middle_name = $_POST['middle_name'];
                    $profile->last_name = $_POST['last_name'];
                    $profile->insert();
                    header("Location:/Main/Login"); // TO CHANGE
                }
            }
            else {
                $this->view('/Profile/create');
            }
        } else {
            header("Location:/Main/Login"); // TO CHANGE
        }
    }
}