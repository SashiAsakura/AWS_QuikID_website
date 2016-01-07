<?php
 $pressID = _GET('prid',-1);
 
 $dtls = GetPressDetails($pressID);
 
 
 $what = '';
 $towhat='';
 
 $presstmpl = file_get_contents('pages/pressdtls.tpl');
 if (is_array($dtls)){
		$date = date('F j, Y',$dtls['date']);
		$title= $dtls['title'];
		$body = $dtls['body'];
		$meta_tags = $dtls['Meta'];
		$subtitle=$dtls['subtitle'];
		if ($subtitle!=''){
			$subtitle = "<h2 class=\"article-subtitle\">".$subtitle."</h2>";
		}
		$what  = array("@TITLE@","@SUBTITLE@","@DATE@","@BODY@");
		$towhat= array($title,$subtitle,$date,$body);
 }else{
		$presstmpl = '';
 }
	
	

	$content = str_replace($what, $towhat, $presstmpl);
?>