<?php

	include('presslist.php');
	$title = "Careers";
	$CareersID = (int)_GET('car',-1);
	 
	$dtls = GetCareersDetails($CareersID);
	$template = file_get_contents('pages/careersdtls.tpl');
	$meta_tags = $dtls['meta'];
	$content = str_replace('@careers-details@', $dtls['Content'], $template);
	
?>