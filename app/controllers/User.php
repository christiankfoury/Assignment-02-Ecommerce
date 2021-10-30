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

	public function createtwofa() {
		$secretkey = \app\core\TokenAuth6238::generateRandomClue();
		$user = new \app\models\User();
		$user->user_id = $_SESSION['user_id'];
		$user->two_factor_authentication = $secretkey;
		$user->updatetwofa();
		$url = \App\core\TokenAuth6238::getLocalCodeUrl(
			$_SESSION['username'],
			'Awesome.com',
			$secretkey,
			'Awesome App'
		);
		$this->view('User/twofasetup', $url);
	}

	public function deletetwofa() {
		$user = new \app\models\User();
		$user->user_id = $_SESSION['user_id'];
		$user->two_factor_authentication = 'NULL';
		$user->updatetwofa();
		header("Location:/Profile/settings");
	}

	public function makeQRCode()
	{
		$data = $_GET['data'];
		\QRcode::png($data);
	}
}