<?php

include('config.php');


mysql_connect($db_host, $db_user,$db_pass) or die(mysql_error());

//Production site
//$db_name = "fpblog";
//mysql_connect("localhost", "fpadmin", "fusion@!2014/") or die(mysql_error());


function getUserDetails($user){
	global $db_name;
	$user = mysql_real_escape_string($user);
	$query = "select * from users where user='$user'";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	return $row;
}


function UpdateNewsImg($pressid,$image,$name){
	global $db_name;
	$image = bin2hex($image);
	
	$query = "update pressRelease set image='$image',imgname='$name' where id=$pressid";
	//echo $query;
	//exit();
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return false;
	}
	if (mysql_affected_rows()==1){
		return true;
	}
	return false;
}


function AddNews($title,$subtitle,$author,$lead,$body,$date,$flags,$metatags,$alt,$source){
	global $db_name;
	$title = addslashes($title);
	$lead  = addslashes($lead);
	$body  = addslashes($body);
	$subtitle = addslashes($subtitle);
	$metatags = addslashes($metatags);
	$author   = addslashes($author);
	
	$query = "insert into pressRelease values(NULL,\"$title\",\"$subtitle\",\"$lead\",\"$body\",$date,'','','$alt','$metatags',$source,\"$author\",$flags)";
	
	mysql_select_db("$db_name") or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return false;
	}
	if (mysql_affected_rows()==1){
		return true;
	}
	return false;
}

function GetLastInsertedNewsId(){
	return mysql_insert_id();
}

function UpdateNews($pressid,$title,$subtitle,$author,$lead,$body,$date,$flags,$alt,$meta,$source){
	global $db_name;
	$pressid = (int)$pressid;
	$title = addslashes($title);
	$subtitle = addslashes($subtitle);
	$lead  = addslashes($lead);
	$body  = addslashes($body);
	$meta  = addslashes($meta);
	$author= addslashes($author);
	
	$query = "update pressRelease set title=\"$title\",subtitle=\"$subtitle\",lead=\"$lead\",body=\"$body\",date=$date,flags=$flags,imgalt='$alt',Meta='$meta',source=$source,author=\"$author\" where id=$pressid";
	echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return false;
	}
	if (mysql_affected_rows()==1){
		return true;
	}
	return false;
}

function RemoveNews($pressID){
	global $db_name;
	$pressID = (int)$pressID;
	$query = "delete from pressRelease where id=$pressID limit 1";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	return $row;
}


function GetNewsCount($source){
	global $db_name;
	$query = "select count(*) as cnt from pressRelease where source=$source";
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	if (!$row)return 0;
	return $row['cnt'];
}

function GetNewsCountForYear($year,$source,$mask,$val){
	global $db_name;
	$query = "SELECT count(*) as cnt FROM pressRelease  where FROM_UNIXTIME(date, '%Y') = $year and source=$source and flags&$mask=$val order by date desc";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	if (!$row)return 0;
	return $row['cnt'];
}


function GetPressListForYear($year,$first,$count,$source,$mask,$val){
	global $db_name;
	$query = "SELECT * FROM pressRelease  where FROM_UNIXTIME(date, '%Y') = $year and source=$source and flags&$mask=$val order by date desc limit $first,$count";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$res = array();
	while($row = mysql_fetch_array( $result )){
		$res[] = $row;
	}
	return $res;
}


function GetPressListWithFlags($year,$first,$count,$flags){
	global $db_name;
	$query = "SELECT * FROM pressRelease  where $flags= flags order by date desc limit $first,$count";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$res = array();
	while($row = mysql_fetch_array( $result )){
		$res[] = $row;
	}
	return $res;
}


function GetPressDetails($pressID){
	global $db_name;
	$pressID = (int)$pressID;
	$query = "select * from pressRelease where id=$pressID";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	return $row;
}

function GetPressImage($pressID){
	global $db_name;
	$pressID = (int)$pressID;
	$query = "select image,imgname from pressRelease where id=$pressID";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	return $row;
}


function GetPressList($first,$count,$source){
	global $db_name;
	$query = "select * from pressRelease where source=$source limit $first,$count";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$res = array();
	while($row = mysql_fetch_array( $result )){
		$res[] = $row;
	}
	return $res;
}


function AddCareers($content,$flag,$title){
	global $db_name;
	$content = addslashes($content);
	$title   = addslashes($title);

	$query = "insert into Careers value(NULL,\"$content\",$flag,\"$title\")";
	
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return false;
	}
	if (mysql_affected_rows()==1){
		return true;
	}
	return false;
}

function GetCareersList($first,$count){
	global $db_name;
	$query = "select * from Careers limit $first,$count";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$res = array();
	while($row = mysql_fetch_array( $result )){
		$res[] = $row;
	}
	return $res;
}

function GetCareersDetails($careersID){
	global $db_name;
	$careersID = (int)$careersID;
	$query = "select * from Careers where id=$careersID";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	return $row;
}

function UpdateCareers($careersID,$content,$flag,$title){
	global $db_name;	
	$query = "update Careers set Content='$content',Flag='$flag', Title='$title' where id=$careersID";
	//echo $query;
	//exit();
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return false;
	}
	if (mysql_affected_rows()==1){
		return true;
	}
	return false;
}

function RemoveCareers($careersID){
	global $db_name;
	$careersID = (int)$careersID;
	$query = "delete from Careers where id=$careersID limit 1";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	return $row;
}


/*

 related to blog 
 
 */
function BlogUpdateNewsImg($pressid,$image,$name){
	global $db_name;
	$image = bin2hex($image);
	
	$query = "update blog set image='$image',imgname='$name' where id=$pressid";
	//echo $query;
	//exit();
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return false;
	}
	if (mysql_affected_rows()==1){
		return true;
	}
	return false;
}


function BlogAddNews($title,$subtitle,$author,$lead,$body,$date,$flags,$metatags,$alt){
	global $db_name;
	$title = addslashes($title);
	$lead  = addslashes($lead);
	$body  = addslashes($body);
	$subtitle = addslashes($subtitle);
	$author = addslashes($author);
	$metatags = addslashes($metatags);
	
	$query = "insert into blog values(NULL,\"$title\",\"$subtitle\",\"$author\",\"$lead\",\"$body\",$date,'','','$alt','$metatags',$flags)";
	
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return false;
	}
	if (mysql_affected_rows()==1){
		return true;
	}
	return false;
}

function BlogGetLastInsertedNewsId(){
	return mysql_insert_id();
}

function BlogUpdateNews($pressid,$title,$subtitle,$author,$lead,$body,$date,$flags,$alt,$meta){
	global $db_name;
	$pressid = (int)$pressid;
	$title = addslashes($title);
	$subtitle = addslashes($subtitle);
	$author = addslashes($author);
	$lead  = addslashes($lead);
	$body  = addslashes($body);
	$meta  = addslashes($meta);
	
	$query = "update blog set title=\"$title\",subtitle=\"$subtitle\",author=\"$author\",lead=\"$lead\",body=\"$body\",date=$date,flags=$flags,imgalt='$alt',Meta='$meta' where id=$pressid";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return false;
	}
	if (mysql_affected_rows()==1){
		return true;
	}
	return false;
}

function BlogRemoveNews($pressID){
	global $db_name;
	$pressID = (int)$pressID;
	$query = "delete from blog where id=$pressID limit 1";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	return $row;
}


function BlogGetNewsCount(){
	global $db_name;
	$query = "select count(*) as cnt from blog";
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	if (!$row)return 0;
	return $row['cnt'];
}

function BlogGetNewsCountForYear($year){
	global $db_name;
	$query = "SELECT count(*) as cnt FROM blog  where FROM_UNIXTIME(date, '%Y') = $year order by date desc";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	if (!$row)return 0;
	return $row['cnt'];
}


function BlogGetPressListForYear($year,$first,$count){
	global $db_name;
	$query = "SELECT * FROM blog  where FROM_UNIXTIME(date, '%Y') = $year order by date desc limit $first,$count";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$res = array();
	while($row = mysql_fetch_array( $result )){
		$res[] = $row;
	}
	return $res;
}


function BlogGetPressListWithFlags($year,$first,$count,$flags){
	global $db_name;
	$query = "SELECT * FROM blog  where $flags= flags order by date desc limit $first,$count";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$res = array();
	while($row = mysql_fetch_array( $result )){
		$res[] = $row;
	}
	return $res;
}


function BlogGetPressDetails($pressID){
	global $db_name;
	$pressID = (int)$pressID;
	$query = "select * from blog where id=$pressID";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	return $row;
}

function BlogGetPressImage($pressID){
	global $db_name;
	$pressID = (int)$pressID;
	$query = "select image,imgname from blog where id=$pressID";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	return $row;
}


function BlogGetPressList($first,$count){
	global $db_name;
	$query = "select * from blog limit $first,$count";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$res = array();
	while($row = mysql_fetch_array( $result )){
		$res[] = $row;
	}
	return $res;
}

function AddMarketingUser($fname,$lname,$company,$email,$source,$type,$market){
	global $db_name;
	$fname = addslashes($fname);
	$lname  = addslashes($lname);
	$company= addslashes($company);
	$email  = addslashes($email);
	$source = (int)$source;
	$type   = (int)$type;
	$market = (int)$market;
	$count = 1;
	$ts      = time();
	$flags = 1;
	
	$query = "insert into marketing_users values(NULL,\"$fname\",\"$lname\",\"$company\",\"$email\",$source,$type,$market,$count,$ts,$flags)";
	
	mysql_select_db("$db_name");// or die(mysql_error());
	$result = mysql_query($query);// or die(mysql_error());  
	if (!$result){
		return false;
	}
	if (mysql_affected_rows()==1){
		return true;
	}
	return false;
}

function GetMarketingListForSource($first,$count,$src,$company,$email,$stdate,$enddate,$type){
	global $db_name;
	$company = addslashes($company);
	$email   = addslashes($email);
	$stdate  = (int)($stdate);
	$enddate = (int)($enddate);
	$type = (int)($type);
	$arr = array();
	if ($src!=-1){
		$arr[]="(source=$src)";
	};
	if ($email!=''){
		$arr[]="(email='$email')";
	}
	if ($stdate!=-1){
		$arr[]="(timestamp>=$stdate)";
	}
	if ($enddate!=-1){
		$arr[]="(timestamp<=$enddate)";
	}
	if ($company!=''){
		$arr[]="(company='$company')";
	}
	if ($type!=-1){
		$arr[]="(type='$type')";
	}
	$first = 1;
	$where = '';
	foreach ($arr as $key => $value) {
		if (!$first){
			$where.=' and';
		}else $first = 0;
		$where.= $value;
	}
	
	$query = "select * from marketing_users where (source = $src) and $where limit $first,$count";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$res = array();
	while($row = mysql_fetch_array( $result )){
		$res[] = $row;
	}
	return $res;
}

function GetMarketingListCountForSource($src){
	global $db_name;
	$query = "select count(*) as cnt from marketing_users where source=$src";
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	if (!$row)return 0;
	return $row['cnt'];
}


function GetMarketingUserListForSource($first,$count,$src,$company,$email,$stdate,$enddate,$adv){
	global $db_name;
	$company = addslashes($company);
	$email   = addslashes($email);
	$stdate  = (int)($stdate);
	$enddate = (int)($enddate);
	$adv = (int)($adv);
	$arr = array();
	if ($src!=-1){
		$arr[]="(source=$src)";
	};
	if ($email!=''){
		$arr[]="(email='$email')";
	}
	if ($stdate!=-1){
		$arr[]="(timestamp>=$stdate)";
	}
	if ($enddate!=-1){
		$arr[]="(timestamp<=$enddate)";
	}
	if ($company!=''){
		$arr[]="(company='$company')";
	}
	if ($adv!=-1){
		$arr[]="(agreed_marketing='$type')";
	}
	$first = 1;
	$where = '';
	foreach ($arr as $key => $value) {
		if (!$first){
			$where.=' and';
		}else {
			$where = 'where ';
			$first = 0;
		}
		$where.= $value;
	}
	$query = "select distinct email,id,agreed_marketing,company,timestamp,fname,lname from marketing_users $where limit $first,$count";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$res = array();
	while($row = mysql_fetch_array( $result )){
		$res[] = $row;
	}
	return $res;
}

function GetMarketingUserListCountFor($src,$company,$email,$stdate,$enddate,$adv){
	global $db_name;
	$company = addslashes($company);
	$email   = addslashes($email);
	$stdate  = (int)($stdate);
	$enddate = (int)($enddate);
	$adv = (int)($adv);
	$arr = array();
	if ($src!=-1){
		$arr[]="(source=$src)";
	};
	if ($email!=''){
		$arr[]="(email='$email')";
	}
	if ($stdate!=-1){
		$arr[]="(timestamp>=$stdate)";
	}
	if ($enddate!=-1){
		$arr[]="(timestamp<=$enddate)";
	}
	if ($company!=''){
		$arr[]="(company='$company')";
	}
	if ($adv!=-1){
		$arr[]="(agreed_marketing='$adv')";
	}
	$first = 1;
	$where = '';
	foreach ($arr as $key => $value) {
		if (!$first){
			$where.=' and';
		}else {
			$where = 'where ';
			$first = 0;
		}
		$where.= $value;
	}
	$query = "select count(distinct email) as cnt from marketing_users $where";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	if (!$row)return 0;
	return $row['cnt'];
}


function GetMarketingUserListCountForSource($src){
	global $db_name;
	$where = "";
	if ($src!=-1)$where = "where source = $src";
	$query = "select count(distinct email) as cnt from marketing_users $where";
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	if (!$row)return 0;
	return $row['cnt'];
}


function GetMarketingListCountFor($src,$company,$email,$stdate,$enddate,$type){
	global $db_name;
	$src     = (int)$src;
	$company = addslashes($company);
	$email   = addslashes($email);
	$stdate  = (int)($stdate);
	$enddate = (int)($enddate);
	$type = (int)($type);
	$arr = array();
	if ($src!=-1){
		$arr[]="(source=$src)";
	};
	if ($email!=''){
		$arr[]="(email='$email')";
	}
	if ($stdate!=-1){
		$arr[]="(timestamp>=$stdate)";
	}
	if ($enddate!=-1){
		$arr[]="(timestamp<=$enddate)";
	}
	if ($company!=''){
		$arr[]="(company='$company')";
	}
	if ($type!=-1){
		$arr[]="(type='$type')";
	}
	$first = 1;
	$where = '';
	foreach ($arr as $key => $value) {
		if (!$first){
			$where.=' and';
		}else $first = 0;
		$where.= $value;
	}
	
	$query = "select count(*) as cnt from marketing_users where $where";
	//echo $query;
	mysql_select_db($db_name) or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return null;
	}
	$row = mysql_fetch_array( $result );
	if (!$row)return 0;
	return $row['cnt'];
}




/*function UpdateUser($fname,$lname,$company,$email,$source){
	global $db_name;
	$fname = addslashes($fname);
	$lname  = addslashes($lname);
	$company= addslashes($company);
	$email  = addslashes($email);
	$history = addslashes($history);
	$source = (int)$source;
	$count = 1;
	$flags = 1;
	
	$query = "insert into marketing_users values(NULL,\"$fname\",\"$lname\",\"$company\",\"$email\",$source,$count,$flags)";
	
	mysql_select_db("$db_name") or die(mysql_error());
	$result = mysql_query($query) or die(mysql_error());  
	if (!$result){
		return false;
	}
	if (mysql_affected_rows()==1){
		return true;
	}
	return false;
}
*/


?>