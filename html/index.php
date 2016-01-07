<?php
/*
if ($_SERVER['SERVER_NAME']=='quikid.ca'){
	Header('Location: http://fusionpipe.com/?page=quikid');
	exit(0);
}*/
/*
if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}
/**/
/*/
error_reporting(E_ALL);
ini_set('display_errors',1);
/**/
error_reporting(0);
include('session.php');
include('utils.php');
if (isDevMode()){
	include('db.tst.php');
}else {
	include('db.php');
}

$meta_tags = '<meta name="description" content="FusionPipe is a technology company specialized in affordable, secure multi factor authentication and advanced data security solutions for Enterprises.
Our patented technology addresses the growing global need for convenient yet secure authentication and identity access management.
Our solutions provide Enterprises, Healthcare professionals, Field workers, Emergency services  with disruptive technology, that is easy to use and implement, increases productivity, improves end-user experience and lowers costs.">
    <meta name="keywords" content="Fusion Pipe,www.fusionpipe.com,FusionPipe Software Solutions,Thorium,Thoriumcloud,smartphone,smart phone,smart watch, smartwatch, wearables, Android Wear, Apple Watch, iOS, Android, Windows,app development, authentication, 2FA, 2-factor authentication, Bluetooth Smart technology, Bluetooth, mobile device,software development,iPhone,iPad,blackberry,container,enterprise software,data security, network security, device security, PKI, smart card, healthcare authentication solutions, Mobile Network Operators, Telco, Government, innovative IT solutions, enterprise authentication solutions, passwordless authentication, two-factor authentication, multi factor authentication, multifactor authentication, multi-factor authentication, smartwatch apps, IoT solutions, patented software solutions, Android phone authentication, dongles, tokens, IAM, identity access management, BYOD,MDM,mobile management,bring your own device,document management, NextBC,BCTIA,CIX,UBC Capstone,Myo,QuikID,QuikSafe,KeyVault">

   <!--facebook meta tags-->
    <meta property="og:type" content="website"/> 
    <meta property="og:title" content="FusionPipe Software Solutions | Simply Secure"/>
    <meta property="og:description" content="FusionPipe is a technology company specialized in affordable, secure multi factor authentication and advanced data security solutions for Enterprises. Our patented technology addresses the growing global need for convenient yet secure authentication and identity access management. Our solutions provide Enterprises, Healthcare professionals, Field workers, Emergency services  with disruptive technology, that is easy to use and implement, increases productivity, improves end-user experience and lowers costs."/>
    <meta property="og:image" content="https://fusionpipe.com/media/favicon/ms-icon-310x310.png"/>
    <meta property="og:url" content="http://www.fusionpipe.com"/>
    <meta property="og:site_name" content="FusionPipe"/>
    <meta property="og:see_also" content="http://www.fusionpipe.com"/>
    <meta property="fb:admins" content="116659281726395"/>
    
    <!--twitter meta tags-->
	<meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="@fusionpipe"/>
    <meta name="twitter:title" content="FusionPipe Software Solutions | Simply Secure">
    <meta name="twitter:description" content="FusionPipe is a technology company specialized in affordable, secure multi factor authentication and advanced data security solutions for Enterprises. Our patented technology addresses the growing global need for convenient yet secure authentication and identity access management. Our solutions provide Enterprises, Healthcare professionals, Field workers, Emergency services  with disruptive technology, that is easy to use and implement, increases productivity, improves end-user experience and lowers costs."/>
    <meta name="twitter:creator" content="FusionPipe"/>
    <meta name="twitter:image:src" content="https://fusionpipe.com/media/favicon/ms-icon-310x310.png"/>
    <meta name="twitter:domain" content="http://www.fusionpipe.com"/>
    
	 <!--google plus meta tags-->
    <meta itemprop="name" content="FusionPipe Software Solutions"/>
    <meta itemprop="description" content="FusionPipe Software Solutions | Simply Secure">
    <meta name="twitter:description" content="FusionPipe is a technology company specialized in affordable, secure multi factor authentication and advanced data security solutions for Enterprises. Our patented technology addresses the growing global need for convenient yet secure authentication and identity access management. Our solutions provide Enterprises, Healthcare professionals, Field workers, Emergency services  with disruptive technology, that is easy to use and implement, increases productivity, improves end-user experience and lowers costs."/>
    <meta itemprop="image" content="https://fusionpipe.com/media/favicon/ms-icon-310x310.png"/>';
//I am loading a content
$_template_ = file_get_contents('template.php');
$navigation = file_get_contents('navigation.php');

//if user passed a parameter I am taking this parameter
if (isset($_GET['page'])){
	$page = $_GET['page'];
}else {
	//if they don't passed a page parameter I am taking a default
	$page = 'default';
}

//to protect the input, if user give somet 'path' in the request, I am taking only the base of this to avoid an attack
$page = basename($page);

if (($page!='')&&(substr($page, 0, 1)==='_')){
	if (!IsLoggedIn())$page = 'login';
}

//here I am creating a path as the $page is secured -> they cannot get outside the current directory
$file_path = 'pages/'.$page.'.php';
if (isDevMode()){
	echo 'you are in dev mode';
	if (file_exists('pages/'.$page.'.php.tst')){
		$file_path = 'pages/'.$page.'.php.tst';
	}
	if (file_exists('template.php.tst')){
		$_template_ = file_get_contents('template.php.tst');
	}
}
$overview = '';
$press = '';
$quikid = '';
$keyvault = '';
$container = '';
$smartid = '';
$blog = '';
$company = '';
$resources = '';
$contact = '';
$solutions= '';
$adminpage= '';

$adminlinks ='';


$header_scripts = "";
$footer_scripts = "";
$title = '';
$content = '';

if (file_exists($file_path)){
	include($file_path);
}else{
	include('pages/default.php');
}
if ($_SERVER['HTTP_HOST']!='localhost'){
	$_SERVER['HTTP_HOST'] = 'www.fusionpipe.com';
}
//HTTP_HOST
/*if (IsLoggedIn()){
	//echo in_array('mod_rewrite', apache_get_modules());
	print_r($_SERVER);
	exit(0);
}*/
if (IsLoggedIn()){
	$adminlinks = '<li class="dropdown"><a href="solutions" class="dropdown-toggle '.$adminpage.'" data-toggle="dropdown">Admin</a>
                        <ul class="dropdown-menu">
                          <li class="smartid"><a href="http://@@http_host@@/_pressaddedt">Releases: Add</a></li>
                          <li class="smartid"><a href="http://@@http_host@@/_presslist">Releases: List</a></li>
                          <li class="smartid"><a href="http://@@http_host@@/_blogaddedt">Blog: Add</a></li>
                          <li class="smartid"><a href="http://@@http_host@@/_bloglist">Blog: List</a></li>
                          <li class="smartid"><a href="http://@@http_host@@/_download_track">Download info</a></li>
                          <li class="smartid"><a href="http://@@http_host@@/_subscribe_track">Subscribe info</a></li>
                          <li class="smartid"><a href="http://@@http_host@@/_contact_track">Contact info</a></li>
                          <li class="smartid"><a href="http://@@http_host@@/login&action=dologout" >Logout</a></li>
						</ul>
                    </li>';
                    
}
$navigation = str_replace('@@overview@@',$overview,$navigation);
$navigation = str_replace('@@quikid@@',$quikid,$navigation);
$navigation = str_replace('@@adminlinks@@',$adminlinks,$navigation);
$navigation = str_replace('@@keyvault@@',$keyvault,$navigation);
$navigation = str_replace('@@container@@',$container,$navigation);
$navigation = str_replace('@@press@@'   ,$press,$navigation);
$navigation = str_replace('@@smartid@@',$smartid,$navigation);
$navigation = str_replace('@@blog@@',$blog,$navigation);
$navigation = str_replace('@@company@@',$company,$navigation);
$navigation = str_replace('@@resources@@',$resources,$navigation);
$navigation = str_replace('@@contact@@',$contact,$navigation);
$navigation = str_replace('@@solutions@@',$solutions,$navigation);


$page = str_replace('@DATE@',date('Y'),$_template_);
$page = str_replace('@NAVIGATION@', $navigation, $page);
$page = str_replace('@HEADER_SCRIPTS@', $header_scripts, $page);
$page = str_replace('@FOOTER_SCRIPTS@', $footer_scripts, $page);
$page = str_replace('@TITLE@',$title,$page);
$page = str_replace('@CONTENT@',$content,$page);
$page = str_replace('@META_TAGS@',$meta_tags,$page);
$page = str_replace('@SCRIPT@',$script,$page);
$page = str_replace('@@http_host@@',$_SERVER['HTTP_HOST'],$page);

echo $page;
?>