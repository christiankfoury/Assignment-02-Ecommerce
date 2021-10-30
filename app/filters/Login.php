<?php

namespace app\filters;
//definition of an attribute
//it needs to be applied to be functional
#[\Attribute]
class Login	{
	function execute(){
		if (!isset($_SESSION['profile_id'])) {
			header('location:/Profile/login');
			return true;
		}
		if (isset($_SESSION['isAuthenticated'])) {
			if ($_SESSION['isAuthenticated'] == 'false') {
				header('location:/Profile/authenticate');
				return true;
			}
		}
		return false;
	}
}
