<?php

namespace app\controllers;

class Profile extends \app\core\Controller {

	#[\app\filters\Login]
    public function index($profile_id){ //listing the records
		if (isset($_POST['search'])) { // if form was submitted
			$profile = new \app\models\Profile();
			$string = $_POST['searchTextbox'];
			header("Location:/Profile/search/$string");
		}
		else{
			$picture = new \app\models\Picture();
			$picture->profile_id = $profile_id;
			$pictures = $picture->getPicturesFromProfile();
			$pictureLike = new \app\models\PictureLike();
			$likesNumber = [];
			foreach ($pictures as $picture) {
				array_push($likesNumber, $pictureLike->getNumberOfLikes($picture->picture_id));
			}
			$profile = new \app\models\Profile();
			$profile = $profile->get($_SESSION['user_id']);
			// print_r($likesNumber);
			$this->view('Profile/index', ['pictures' => $pictures, 'likesNumber' => $likesNumber, 'profile'=>$profile]);
		}
	}

	public function register(){
		if(isset($_POST['action']) && $_POST['password'] == $_POST['password_confirm']){//verify that the user clicked the submit button
			$user = new \app\models\User();
			$user->username = $_POST['username'];
			$user->password = $_POST['password'];
			$user->insert();//password hashing done here
			//redirect the user back to the index
			header('location:/Profile/login');

		}else //1 present a form to the user
			$this->view('Profile/register');
	}
	
	public function login(){
		//TODO: register session variables to stay logged in
		if(isset($_POST['action'])){//verify that the user clicked the submit button
			$user = new \app\models\User();
			$user = $user->get($_POST['username']);

			if($user!=false && password_verify($_POST['password'], $user->password_hash)){
				$_SESSION['user_id'] = $user->user_id;
				$_SESSION['username'] = $user->username;
				header("location:/Profile/create/$user->username");
			}else{
				$this->view('Profile/login','Wrong username and password combination!');
			}

		}else //1 present a form to the user
			$this->view('Profile/login');
	}


	public function logout(){
		//destroy session variables
		session_destroy();
		header('location:/Profile/login');
	}

    public function create($username) {
        $profile = new \app\models\Profile();
        $user = new \app\models\User();
        $user = $user->getUser_id($username);
        $profile = $profile->get($user->user_id);
        if ($profile == false) {
            if(isset($_POST['action'])) {
                if (!$_POST['first_name'] || !$_POST['last_name']) {   
                    $this->view("/Profile/create", "First name and last name must not be empty");
                }
                else {
					$profile = new \app\models\Profile();
                    $profile->user_id = $user->user_id;
                    $profile->first_name = $_POST['first_name'];
                    $profile->middle_name = $_POST['middle_name'];
                    $profile->last_name = $_POST['last_name'];
                    $profile->insert();
					$profile = new \app\models\Profile();
                    $profile = $profile->get($user->user_id);
                    header("Location:/Profile/index/$profile->profile_id");
                }
            }
            else {
                $this->view("/Profile/create");
            }
        } else {
            header("Location:/Profile/index/$profile->profile_id");
        }
    }

	public function editProfile() {
		$profile = new \app\models\Profile();
		$profile = $profile->get($_SESSION['user_id']);
		if (isset($_POST['action'])) {
			if (!$_POST['first_name'] || !$_POST['last_name']) {
				$this->view("/Profile/create", "First name and last name must not be empty");
			} else {
				$profile->user_id = $_SESSION['user_id'];
				$profile->first_name = $_POST['first_name'];
				$profile->middle_name = $_POST['middle_name'];
				$profile->last_name = $_POST['last_name'];
				$profile->update();
				$profile = new \app\models\Profile();
				$profile = $profile->get($_SESSION['user_id']);
				header("Location:/Profile/index/$profile->profile_id");
			}
		} else {
			$this->view("/Profile/create", ['first_name' => $profile->first_name,'middle_name' => $profile->middle_name,'last_name' => $profile->last_name]);
		}
	}

	public function settings() {
		$profile = new \app\models\Profile();
		$profile = $profile->get($_SESSION['user_id']);
		$this->view("/Profile/settings", $profile);
	}

	public function search($string){
		$profile = new \app\models\Profile();
		$profile = $profile->search($string);
		$this->view("/Profile/searchResults",$profile);
	}

	public function wall($profile_id){
		$picture = new \app\models\Picture();
		$picture->profile_id = $profile_id;
		$pictures = $picture->getPicturesFromProfile();
		$pictureLike = new \app\models\PictureLike();
		$likesNumber = [];
		foreach ($pictures as $picture) {
			array_push($likesNumber, $pictureLike->getNumberOfLikes($picture->picture_id));
		}
		$profile = new \app\models\Profile();
		$profile = $profile->get($profile_id);

		$messages = new \app\models\Message();
		$messages->sender = $profile_id;
		$messages = $messages->getPublicMessages();

		$profiles = [];
		foreach ($messages as $message) {
			array_push($profiles, $profile->get($message->receiver));
		}
		$this->view('Profile/wall', ['pictures' => $pictures, 'likesNumber' => $likesNumber, 'profile'=>$profile, 'messages' => $messages, 'profiles'=>$profiles]);
	}
	// likes
	// send msg to this user
}