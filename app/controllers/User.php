<?php
namespace app\controllers;

class User extends \app\core\Controller{

	#[\app\filters\Login]
	public function changePassword() {
		$profile = new \app\models\Profile();
		$profile = $profile->get($_SESSION['user_id']);
		$user = new \app\models\User();
		$user = $user->get($_SESSION['username']);


		if (isset($_POST['action'])) {
			if (password_verify($_POST['current_password'], $user->password_hash) && $_POST['new_password'] == $_POST['password_confirm']) { 
				$user->password = $_POST['new_password'];
				// echo $user->password_hash;
				$user->update();
				header("Location:/Profile/index");
			}
			else {
				$this->view('User/changePassword', ['profile' => $profile, 'error' => 'The password(s) do not correspond']);
			}
		}
		else {
			$this->view('User/changePassword', ['profile' => $profile]);
		}
	}
}