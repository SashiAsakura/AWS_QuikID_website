<?php
  $major = 2;
  $minor = 0;
  if (isset($_GET['rq_major'])){
  	$major = (int)$_GET['rq_major'];
  };
  
  if (isset($_GET['rq_minor'])){
  	$minor = (int)$_GET['rq_minor'];
  };
  $appID 		= -1;
  $lastUpdated  = -1;
  $lastVer		= -1;
  if (isset($_GET['appid']))$appID 		= $_GET['appid'];
  if (isset($_GET['lu']))$lastUpdated 	= $_GET['lu'];
  if (isset($_GET['ver']))$lastVer    	= $_GET['ver'];
  
//PC version of QuikID
if (($appID=='1') && ($lastVer>=201)){
	header('Content-Type: application/json');
	//types: 1-info,2-new version,3-imporant update
	if ($lastVer==201){
		/*if ($lastUpdated==0){
			echo '{"events":[{"type":"2","message":"You made it!","title":"Julian it works!"}],"lu":"1"}';
		}
		if ($lastUpdated==1){
			echo '{"events":[{"type":"2","message":"Happy Valentines!","title":"Julian it works!"}],"lu":"2"}';
		}*/
	}
	exit(0);
}

  //mac version of QuikID
  if ($appID=='2'){
  	header('Content-Type: application/json');
  	//types: 1-info,2-new version,3-imporant update
  	if ($lastVer==100){
  		if ($lastUpdated<1){
  			echo '{"events":[{"type":"2","message":"A new version of QuikID is available","title":"Update your QuikID"}],"lu":"1"}';
  		}
  	}
  	exit(0);
  }
  
  echo "$major.$minor";

?>
