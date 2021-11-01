<?php

namespace app\controllers;

class Profile extends \app\core\Controller {

	#[\app\filters\Login]
    public function index(){ //listing the records
		if (isset($_POST['search'])) { // if form was submitted
			$profile = new \app\models\Profile();
			$string = $_POST['searchTextbox'];
			header("Location:/Profile/search/$string");
		}
		else{
			$picture = new \app\models\Picture();
			$picture->profile_id = $_SESSION['profile_id'];
			$pictures = $picture->getPicturesFromProfile();
			$pictureLike = new \app\models\PictureLike();
			$notificationsCount = 0;
			$likesNumber = [];
			foreach ($pictures as $picture) {
				array_push($likesNumber, $pictureLike->getNumberOfLikes($picture->picture_id));
				$notificationsCount += ($pictureLike->getUnreadLikes($picture->picture_id))['COUNT(*)'];
			}
			$profile = new \app\models\Profile();
			$profile = $profile->get($_SESSION['user_id']);

			$messages = new \app\models\Message();
			$messages->sender = $_SESSION['profile_id'];
			$messages = $messages->getPublicMessages();

			$profiles = [];
			$profileObject = new \app\models\Profile();
			foreach ($messages as $message) {
				array_push($profiles, $profileObject->getWithProfile($message->receiver));
			}

			$this->view('Profile/index', ['pictures' => $pictures, 'likesNumber' => $likesNumber, 'profile'=>$profile,'notificationsCount'=>$notificationsCount,
				'messages' => $messages, 'profiles' => $profiles]);
		}
	}

	public function register(){
		if(isset($_POST['action'])){//verify that the user clicked the submit button
			if (trim($_POST['username']) == '' || trim($_POST['password']) == '') {
				$this->view('Profile/register', "The username and the password cannot be empty");
				return;
			}
			$user = new \app\models\User();
			if ($user->get($_POST['username'])) {
				$this->view('Profile/register', "This username already exists");
				return;
			}
			if ($_POST['password'] != $_POST['password_confirm']) {
				$this->view('Profile/register', "The passwords do not match");
				return;
			}
			$user->username = $_POST['username'];
			$user->password = $_POST['password'];
			$user->insert(); //password hashing done here
			//redirect the user back to the index

			$user = new \app\models\User();
			$user = $user->get($_POST['username']);
			$_SESSION['user_id'] = $user->user_id;
			$_SESSION['username'] = $user->username;
			// header('location:/Profile/login');
			header("location:/Profile/create");


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

				$profile = new \app\models\Profile();
				$profile = $profile->get($_SESSION['user_id']);
				if ($profile == false) {
					header("location:/Profile/create");
				} else {
					$_SESSION['profile_id'] = $profile->profile_id;
					if ($user->two_factor_authentication == '') {
						$_SESSION['isAuthenticated'] = 'true';
					} else {
						$_SESSION['isAuthenticated'] = 'false';
					}
					header("Location:/Profile/index");
				}

			}else{
				$this->view('Profile/login','Wrong username and password combination!');
			}

		}else //1 present a form to the user
			$this->view('Profile/login');
	}

	public function authenticate() {
		$user = new \app\models\User();
		$user = $user->get($_SESSION['username']);
		if (isset($_POST['action'])) {
			$currentcode = $_POST['currentCode'];
			if (\app\core\TokenAuth6238::verify($user->two_factor_authentication, $currentcode)) {
				$_SESSION['isAuthenticated'] = 'true';
				header('location:/Profile/index');
			} else {
				$this->view('Profile/authenticate', "Incorrect!");
			}
		} else {
			$this->view('Profile/authenticate');
		}
	}


	public function logout(){
		//destroy session variables
		session_destroy();
		header('location:/Profile/login');
	}

	#[\app\filters\Login]
    public function create() {	
		if(isset($_POST['action'])) {
			if (trim($_POST['first_name']) == '' || trim($_POST['last_name']) == '') {   
				$this->view("/Profile/create", ["error"=>"First name and last name must not be empty"]);
			}
			else {
				$profile = new \app\models\Profile();
				$profile->user_id = $_SESSION['user_id'];
				$profile->first_name = $_POST['first_name'];
				$profile->middle_name = $_POST['middle_name'];
				$profile->last_name = $_POST['last_name'];
				$profile->insert();
				$profile = new \app\models\Profile();
				$profile = $profile->get($_SESSION['user_id']);
				$_SESSION['profile_id'] = $profile->profile_id;
				header("Location:/Profile/index");
			}
		}
		else {
			$this->view("/Profile/create");
		}
    }

	#[\app\filters\Login]
	public function editProfile() {
		$profile = new \app\models\Profile();
		$profile = $profile->get($_SESSION['user_id']);
		if (isset($_POST['action'])) {
			if (!$_POST['first_name'] || !$_POST['last_name']) {
				$this->view("/Profile/edit", ['first_name' => $profile->first_name, 'middle_name' => $profile->middle_name, 'last_name' => $profile->last_name,
					"error"=>"First name and last name must not be empty"]);
			} else {
				$profile->user_id = $_SESSION['user_id'];
				$profile->first_name = $_POST['first_name'];
				$profile->middle_name = $_POST['middle_name'];
				$profile->last_name = $_POST['last_name'];
				$profile->update();
				$profile = new \app\models\Profile();
				header("Location:/Profile/index");
			}
		} else {
			$this->view("/Profile/edit", ['first_name' => $profile->first_name,'middle_name' => $profile->middle_name,'last_name' => $profile->last_name]);
		}
	}

	#[\app\filters\Login]
	public function settings() {
		$profile = new \app\models\Profile();
		$profile = $profile->get($_SESSION['user_id']);
		$user = new \app\models\User();
		$user = $user->get($_SESSION['username']);
		$this->view("/Profile/settings", ['profile'=>$profile, 'two_factor_authentication'=>$user->two_factor_authentication]);
	}

	#[\app\filters\Login]
	public function search($string){
		$profile = new \app\models\Profile();
		$profile = $profile->search($string);
		$this->view("/Profile/searchResults",$profile);
	}

	#[\app\filters\Login]
	public function wall($profile_id){
		$picture = new \app\models\Picture();
		$picture->profile_id = $profile_id;
		$pictures = $picture->getPicturesFromProfile();
		$pictureLike = new \app\models\PictureLike();

		// profile id of the user that is viewing the wall
		$profile = new \app\models\Profile();
		$profile = $profile->getWithProfile($profile_id);

		$likesNumber = [];
		$likeOrUnlikes = [];
		foreach ($pictures as $picture) {
			array_push($likesNumber, $pictureLike->getNumberOfLikes($picture->picture_id));
			$likeOrUnlike = $pictureLike->isLiked($picture->picture_id, $_SESSION['profile_id']);
			if ($likeOrUnlike == false) {
				array_push($likeOrUnlikes, 'unliked');
			} else {
				array_push($likeOrUnlikes, 'liked');
			}
		}

		$messages = new \app\models\Message();
		$messages->sender = $profile_id;
		$messages = $messages->getPublicMessages();

		$profiles = [];
		$profileObject = new \app\models\Profile();
		foreach ($messages as $message) {
			array_push($profiles, $profileObject->getWithProfile($message->receiver));
		}
		$this->view('Profile/wall', ['pictures' => $pictures, 'likesNumber' => $likesNumber, 'profile'=>$profile, 'messages' => $messages, 'profiles'=>$profiles, 'likes'=>$likeOrUnlikes,
			'viewer'=>$_SESSION['profile_id']]);
	}

	#[\app\filters\Login]
	public function inbox(){
		$profile = new \app\models\Profile();
		$profile = $profile->get($_SESSION['profile_id']);

		$messages = new \app\models\Message();
		$messages->receiver = $_SESSION['profile_id'];
		$messages = $messages->getMessagesByReceiver();
		
		$this->view('Profile/inbox', $messages);
	}

	#[\app\filters\Login]
	public function outbox(){
		$profile = new \app\models\Profile();
		$profile = $profile->get($_SESSION['profile_id']);

		$messages = new \app\models\Message();
		$messages->sender = $_SESSION['profile_id'];
		$messages = $messages->getMessagesBySender();

		$profiles = [];
		$profileObject = new \app\models\Profile();
		foreach ($messages as $message) {
			array_push($profiles, $profileObject->getWithProfile($message->receiver));
		}

		$this->view('Profile/outbox',['messages'=>$messages,'profiles'=>$profiles,'profile_id'=>$_SESSION['profile_id']]);
	}

	#[\app\filters\Login]
	public function notifications(){
		$pictureLike = new \app\models\PictureLike();

		$pictures = new \app\models\Picture();
		$pictures->profile_id = $_SESSION['profile_id'];

		$pictures = $pictures->getPicturesFromProfile();
		$unseenLikes = [];
		foreach ($pictures as $picture) {
			array_push($unseenLikes, $pictureLike->getUnseenLikes($picture->picture_id));
		}

		$this->view('Profile/notifications',$unseenLikes);
	}

	#[\app\filters\Login]
	public function viewNotification($picture_id, $profile_id) {
		$pictureLike = new \app\models\PictureLike();
		$profile = new \app\models\Profile();
		$profile = $profile->get($_SESSION["user_id"]);
		$pictureLike->updateNotificationSeen($picture_id, $profile_id);

		header("Location:/Profile/notifications");
	}


	public function makeQRCode()
	{
		$data = $_GET['data'];
		\QRcode::png($data);
	}

	// // #[\app\filters\Login]
	// // public function setup2fa(){
	// // 	$secretkey = \App\core\TokenAuth6238::generateRandomClue();
	// // 	$_SESSION['secretkey'] = $secretkey;
	// // 	$url = \app\core\TokenAuth6238::getLocalCodeUrl(
	// // 	$_SESSION['username'],
	// // 	'Awesome.com',
	// // 	$secretkey,
	// // 	'Awesome App');
	// // 	$this->view('Main/twofasetup', $url);
	// // }

	// #[\app\filters\Login]
	// public function setuptwofa()
	// {
	// 	if (isset($_POST['action'])) {
	// 		$currentcode = $_POST['currentCode'];
	// 		if (\app\core\TokenAuth6238::verify($_SESSION['secretkey'], $currentcode)) {
	// 			//the user has verified their proper 2-factor authentication  setup
	// 			$user = new \App\models\User();
	// 			$user->user_id = $_SESSION['user_id'];
	// 			$user->secret_key = $_SESSION['secretkey'];
	// 			// $user->update2fa();
	// 			header('location:/index');
	// 		} else {
	// 			header('location:/Profile/setuptwofa/error=token not verified!'); //reload
	// 		}
	// 	} else {
	// 		$secretkey = \app\core\TokenAuth6238::generateRandomClue();
	// 		$_SESSION['secretkey'] = $secretkey;
	// 		echo $secretkey;
	// 		$url = \App\core\TokenAuth6238::getLocalCodeUrl(
	// 			$_SESSION['username'],
	// 			'Awesome.com',
	// 			$secretkey,
	// 			'Awesome App'
	// 		);
	// 		$this->view('Profile/twofasetup', $url);
	// 	}
	// }
}