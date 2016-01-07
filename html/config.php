<?php
//for Go Daddy live
//$db_user = "FPPressRelease";
//$db_pass = "fp2014!article@R";
//$db_name = "FPPressRelease";
//$db_host = "FPPressRelease.db.6058457.hostedresource.com";

/**/
//for Amazon live
if ($_SERVER['HTTP_HOST']!='localhost'){
	date_default_timezone_set('America/Los_Angeles');
	$db_user = "tricha";
	$db_pass = "fp14db!To?";
	$db_name = "FPDB";
	$db_host = "fpdb.cnxknkx8yknx.us-west-2.rds.amazonaws.com";
}else{
	$db_name = "fpblog";
	$db_host = "localhost";
	$db_user = "fpadmin";
	$db_pass = "fusion@!2014/";
}
/**/


define("NEWS",1);
define("BLOG",2);
define("BLOG_TST",3);
define("NEWS_TST",4);


?>