<?php

namespace app\filters;
//definition of an attribute
//it needs to be applied to be functional
#[\Attribute]
class ProfileLogin	{
	function execute(){
		if(!isset($_SESSION['profile_id'])){
			header('location:/Profile/login');
			return true;
		}
		return false;
	}
}
