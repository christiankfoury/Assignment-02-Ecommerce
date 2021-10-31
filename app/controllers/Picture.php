<?php
namespace app\controllers;

class Picture extends \app\core\Controller{
	private $folder='uploads/';

	#[\app\filters\Login]
	public function newPost(){
		//implement file uploads

		if(isset($_POST['action'])){
			//get the form data and process it
			if(isset($_FILES['newPicture'])){
				$check = getimagesize($_FILES['newPicture']['tmp_name']);

				$mime_type_to_extension = ['image/jpeg'=>'.jpg',
											'image/gif'=>'.gif',
											'image/bmp'=>'.bmp',
											'image/png'=>'.png'
											];

				if($check !== false && isset($mime_type_to_extension[$check['mime']])){
					$extension = $mime_type_to_extension[$check['mime']];
				}else{
					$this->view('Picture/newPost', ['error'=>"Bad file type",'pictures'=>[]]);
					return;
				}

				$filename = uniqid().$extension;
				$filepath = $this->folder.$filename;

				if($_FILES['newPicture']['size'] > 4000000){
					$this->view('Picture/newPost', ['error'=>"File too large",'pictures'=>[]]);
					return;
				}
				if(move_uploaded_file($_FILES['newPicture']['tmp_name'], $filepath)){
					$picture = new \app\models\Picture();
					$picture->filename = $filename;
					$picture->profile_id = $_SESSION['profile_id'];
					$picture->caption = $_POST['caption'];
					$picture->insert();
					header("location:/Profile/index");
				}
				else
					echo "There was an error";
			}
		}else{
			//present the form
			$picture = new \app\models\Picture();
			$pictures = $picture->getAll();
			$this->view('Picture/newPost',['error'=>null,'pictures'=>$pictures]);
		}
	}

	#[\app\filters\Login]
	public function editPost($picture_id){
		if(isset($_POST['action'])){
			$picture = new \app\models\Picture();
			$picture = $picture->get($picture_id);
			$picture->caption = $_POST['caption'];
			$picture->update();
			header("location:/Profile/index");
		}
		else{
			$picture = new \app\models\Picture();
			$picture = $picture->get($picture_id);
			$this->view('Picture/editPost',$picture);
		}
	}

	#[\app\filters\Login]
	public function deletePost($picture_id){
		$picture = new \app\models\Picture();
		$picture = $picture->get($picture_id);

		$pictureLike = new \app\models\PictureLike();
		$pictureLike->picture_id = $picture_id;
		
		$pictureLike->delete();
		$picture->delete();
		// add unlink method https://stackoverflow.com/questions/35422740/how-to-delete-a-file-after-using-move-uploaded-file
		header("location:/Profile/index");
	}

	#[\app\filters\Login]
	public function likePost($picture_id){
		$picture = new \app\models\Picture();
		$picture = $picture->get($picture_id);
		
		// $profile = new \app\models\Profile();
		// $profile = $profile->get($profile_id);

		$pictureLike = new \app\models\PictureLike();
		$pictureLike->picture_id = $picture_id;
		$pictureLike->profile_id = $_SESSION['profile_id'];
		$pictureLike->insert();
		header("Location:/Profile/wall/$pictureLike->profile_id");
	}

	#[\app\filters\Login]
	public function unlikePost($picture_id){
		$pictureLike = new \app\models\PictureLike();
		$pictureLike->picture_id = $picture_id;
		$pictureLike->profile_id = $_SESSION['profile_id'];
		$pictureLike->delete();

		$picture = new \app\models\Picture();
		$picture = $picture->get($picture_id);
		header("Location:/Profile/wall/$pictureLike->profile_id");
	}
}