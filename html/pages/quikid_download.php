<?php
	$solutions=  'on';
	$quikid = 'class="on"';
	$title = "Download QuikID™ Beta";
	$quikid_windows_version = '4.5.1';
	$quikid_android_version = '4.5.0';
	/*
	$content = file_get_contents('pages/quikid_beta.tpl');
	/*/
	ob_start(); // start output buffer
	include 'pages/quikid_download.tpl';
	$content = ob_get_contents();
	ob_end_clean();
	//*/
	$script = '<script type="text/javascript">llfrmid=26473</script> 
<script type="text/javascript" src="https://formalyzer.com/formalyze_init.js"></script> 
<script type="text/javascript" src="https://formalyzer.com/formalyze_call_secure.js"></script>';
?>