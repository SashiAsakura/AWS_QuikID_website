<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

function convertFromDateToUnixTimestamp($date){
	//global $months;
	$timestamp = time();
	$array = date_parse_from_format('F j, Y',$date);
	if (is_array($array))$timestamp = mktime(0, 0, 0, $array['month'], $array['day'], $array['year']);
	
	return $timestamp;
}

$products = array('-1' => 'Any', '1' => 'QuickSafe Solutions', '2' => 'Becoming Partner','3'=>'Other');

$all     = 0;
$rowsperpage = 10;

$adminpage = 'on';

$action = _GET('action','');
$entryid= _GET('entryid',-1);
$pg   = _GET('pg',1);
$product = _GET('fil_product',-1);
$company = _GET('fil_company','');
$email   = _GET('fil_email','');
$stdate  = _GET('fil_stdate','');
$enddate = _GET('fil_enddate','');
$fall    = _GET('fil_all','');
if ($fall!=''){
	$all = 1;
}


$frm = file_get_contents('pages/_contact_track.frm');
$opts = '';
foreach($products as $key => $val){
	if ($key==$product)$chk = 'selected';else $chk='';
	$opts.='<option value="'.$key.'" '.$chk.'>'.$val.'</option>';
}
$fall = ($all!=0)?'checked':'';
$frm = str_replace('@products@', $opts, $frm);
$frm = str_replace('@company@', $company, $frm);
$frm = str_replace('@email@', $email, $frm);
$frm = str_replace('@stdate@', $stdate, $frm);
$frm = str_replace('@enddate@', $enddate, $frm);
$frm = str_replace('@all@', $fall, $frm);

switch($action){
	case 'remove': RemoveMarketingUser($entryid);
}
if ($stdate!='')$stdate  = convertFromDateToUnixTimestamp($stdate);
	else $stdate=-1;
if ($enddate!='')$enddate = convertFromDateToUnixTimestamp($enddate);
	else $enddate=-1;


 $rowsperpage = GetMarketingListCountFor(3,$company,$email,$stdate,$enddate,$product);

if ($pg < 1)$pg = 1;



$first = ($pg-1)*$rowsperpage;
$no = $first+1;
$articles = GetMarketingListForSource($first,$rowsperpage,3,$company,$email,$stdate,$enddate,$product);

$content = '<section id="adm_container">
	<div class="container"><p class="pressEdit-list">';
$content.=$frm;

if ($all==1)$rowsperpage = -1;
//print_r($articles);
$content.= 'Total contacts: '.GetMarketingListCountFor(3,$company,$email,$stdate,$enddate,$product);

$table = "<!--- start list of download -->";
$table.='<table style="border:1 solid black;background-color:white;">';
$table.='<tr style="background-color:#999999;color:white;"><td style="width:40px">No</td><td style="width:200px;">Company</td><td style="width:200px"> First name/full name </td><td style="width:200px"> Surname </td><td style="width:200px"> email </td><td style="width:40px"> ADV </td><td style="width:230px"> date </td><td style="width:60px"> type </td><td>&nbsp;</td></tr>';
foreach($articles as $key => $row){
	$rowtpl = '<tr class="downloadEdit-list"><td>@NO@</td><td>@COMPANY@</td><td>@NAME@</td><td>@SURNAME@</td><td>@EMAIL@</td><td>@ADVERTISMENT@</td><td>@TIME@</td><td>@TYPE@</td><td><a href="@DELLINK@">X</a></td></tr>';
	$nostr = $no;
	//if ($row['flags']==1)$nostr='*'.$no;else $nostr = $no;
	//if ($row['flags']&2)$nostr='(T)'.$nostr;
	$rowhtml =str_replace("@NO@", $nostr, $rowtpl);
	$rowhtml =str_replace('@NAME@', $row['fname'], $rowhtml);
	$rowhtml =str_replace('@SURNAME@', $row['lname'], $rowhtml);
	$rowhtml =str_replace('@EMAIL@', $row['email'], $rowhtml);
	$rowhtml =str_replace('@TYPE@', $row['type'], $rowhtml);
	$rowhtml =str_replace('@ADVERTISMENT@', ($row['agreed_marketing']!='0')?'Yes':'No', $rowhtml);
	$rowhtml =str_replace('@COMPANY@',$row['company'],$rowhtml);
	$rowhtml =str_replace('@TIME@', date('Y-M-d h:i:sa',$row['timestamp']), $rowhtml);
	$rowhtml =str_replace('@DELLINK@', '?page=_contact_track&entryid='.$row['id'].'&action=remove', $rowhtml);
	$table.=$rowhtml;
	$no++;
}
$table.='</table></p>';
$table.= "<!--- end list of download -->";

//there are links to pages ;)

$totalpages = (int)((GetMarketingListCountFor(3,$company,$email,$stdate,$enddate,$product)+$rowsperpage-1)/$rowsperpage);

$pglinks = '<p class="downloadEdit-pages">';
for ($i = 0; $i < $totalpages; $i++){
	$pglinks.='|<a href="?page=_contact_track&pg='.($i+1).'">'.($i+1).'</a>';
}
if ($totalpages>0)$pglinks.= '|</p>';
$content.= $table.$pglinks.'</div></div>';
?>