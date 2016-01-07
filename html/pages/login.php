<?php
$user = _POST('user','');
$pass = _POST('pass','');
$action=_GET('action','');
$error= '';

$loginfrm = file_get_contents('pages/login.tpl');

switch($action){
	
	case 'dologin':
		if (($user!='')&&($pass!='')){
			if (Login($user,$pass)){
				$error = 'Login success!';
			}else $error = 'Login fail!';
		}
	break;

	case 'dologout':
		Logout();
	break;
}



$loginfrm = str_replace('@USER@', $user, $loginfrm);
$loginfrm = str_replace('@ERROR@',$error,$loginfrm);

	
if (!IsLoggedIn()) $content = $loginfrm;else $content = '<a href="?page=login&action=dologout">Logout</a>';


?>