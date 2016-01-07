<?php

error_reporting(E_ALL);
ini_set('display_errors',1);
/*
$months = array(
			"January" => 1,
			"February" => 2,
			"March" => 3,
			"April" => 4,
			"May" => 5,
			"June" => 6,
			"July" => 7,
			"August" => 8,
			"September" => 9,
			"October" => 10,
			"November" => 11,
			"December" => 12
			);
*/			
function convertFromDateToUnixTimestamp($date){
	global $months;
	$timestamp = time();
	$array = date_parse_from_format('F j, Y',$date);
	if (is_array($array))$timestamp = mktime(0, 0, 0, $array['month'], $array['day'], $array['year']);
	
	return $timestamp;
}

$adminpage = 'on';


$pressid=_GET('pressid',-1);
//echo 'pressid'.$pressid;
$action= _POST('action','');
$status = '';

$title = _POST('title','');
$subtitle = _POST('subtitle','');
$lead  = _POST('lead','');
$body  = _POST('body','');
$date  = _POST('date','');
$imgalt= _POST('imgalt','');
$meta  = _POST('meta','');
$tst_mode  = _POST('testmode','');

$mainpage= (isset($_POST['mainpage']))?true:false;
$img_lnk = '';
$flags = 0;
if ($mainpage)$flags|=1;
if ($tst_mode)$flags|=2;
if ($date=='')$date = date('F j, Y',time());
$showform = true;
$source = NEWS;


switch($action){
	case 'addnews':
		$imgupd = 0;
		$ts = convertFromDateToUnixTimestamp($date);
		$author = '';
		if (AddNews($title,$subtitle,$author,$lead,$body,$ts,$flags,$meta,$imgalt,$source)){
			$pressid = GetLastInsertedNewsId();
			if (isset($_FILES['image'])){
				$imgfiledesc = $_FILES['image'];
				
				if ($imgfiledesc['error']==0){
					$imgname = $imgfiledesc['name'];
					$imgfile = file_get_contents($imgfiledesc['tmp_name']);
					//$type    = $imgfiledesc['name'];
					if (UpdateNewsImg($pressid,$imgfile,$imgname))$imgupd = 1;
				}
			}
			if ($imgupd)$status = 'Changes have been saved :)';
				else $status = 'Article has been updated!';
			//$showform = false;
		}else{
			if ($imgupd==0){ 
				$status = 'Changes have not been saved :(';
			}else{
				$status = 'Image has been updated';
			}
		}
		break;
	case 'updnews':
		$imgupd = 0;
		if ($pressid!=-1){
			if (isset($_FILES['image'])){
				$imgfiledesc = $_FILES['image'];
				
				if ($imgfiledesc['error']==0){
					$imgname = $imgfiledesc['name'];
					$imgfile = file_get_contents($imgfiledesc['tmp_name']);
					if (UpdateNewsImg($pressid,$imgfile,$imgname))$imgupd = 1;
				}
			}
			$ts = convertFromDateToUnixTimestamp($date);
			//echo $ts;
			$author = '';
			if (UpdateNews($pressid,$title,$subtitle,$author,$lead,$body,$ts,$flags,$imgalt,$meta,$source)){
				if ($imgupd)$status = 'Changes have been saved :)';
					else $status = 'Article has been updated!';
				//$showform = false;
			}else{
				if ($imgupd==0){ 
					$status = 'Changes have not been saved :(';
				}else{
					$status = 'Image has been updated';
				}
			}
		}else $status = "Unable to edit this article";
		break;
}

$form = '';
if ($showform)$form = file_get_contents("pages/_pressaddedt.frm");
	else $form = '<div class="container"><p>@STATUS@</p></div>';


if ($pressid==-1){
	$button = 'Add';
	$action = 'addnews';	
}else{
	$button = 'Save';
	$action = 'updnews';
	$details= GetPressDetails($pressid);
	//print_r($details);
	$title  = $details['title'];
	$subtitle=$details['subtitle'];
	$lead   = $details['lead'];
	$body   = $details['body'];
	$date   = $details['date'];
	$flags  = $details['flags'];
	$meta   = $details['Meta'];
	$imgalt = $details['imgalt'];
	$date = date('F j, Y',$details['date']);
	if ($details['image']!=null){
		$img_lnk = '<img src="getfile.php?id='.$details['id'].'">';
	}
}



if ($flags&1){
	$mainpage = 'checked';
}else $mainpage = '';
if ($flags&2){
	$tst_mode = 'checked';
}else $tst_mode = '';

if ($pressid!=-1){
	$previewlnk = '<a href="?page=pressdtls&prid='.$pressid.'" target="_blank">preview press release</a>';
}else $previewlnk ='';

$names = array('@TITLE@','@SUBTITLE@','@LEAD@','@BODY@','@BUTTON@','@STATUS@','@PRESSID@','@ACTION@','@DATE@','@MAINPG@','@IMAGE@','@IMGALT@','@META@','@TESTMODE@','@PREVIEWLINK@');
$title = htmlspecialchars($title);
$values= array($title,$subtitle,$lead,$body,$button,$status,$pressid,$action,$date,$mainpage,$img_lnk,htmlspecialchars($imgalt),$meta,$tst_mode,$previewlnk);

$content = str_replace($names, $values, $form);

$scripts = file_get_contents("pages/_pressaddedt.scr");

$footer_scripts.=$scripts;


?>