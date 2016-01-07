<?php

session_start();



function Login($user,$pass){
	$details = getUserDetails($user);
	if (!is_array($details)){
		return false;
	}
	if ($details['pass']==$pass){
		$_SESSION['logged'] = true;
		$_SESSION['details']= $details;
		//echo 'logged ;)';
		return true;
	}
	return false;
}


function Logout(){
	$_SESSION['logged'] = false;
	session_destroy();
	session_start();
}


function IsLoggedIn(){
	if (isset($_SESSION['logged']))return $_SESSION['logged'];
	return false;
}

?>