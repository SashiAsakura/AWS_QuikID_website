<?php
	$contact = 'class="on"';
	$title = "Contact";
	$content = file_get_contents('pages/contact.tpl');
	$script = '<script type="text/javascript">llfrmid=26473</script> 
			<script type="text/javascript" src="https://formalyzer.com/formalyze_init.js"></script> 
			<script type="text/javascript" src="https://formalyzer.com/formalyze_call_secure.js"></script>';
	
	$content = str_replace('@CAPTCHA@', '', $content);
	
	$interests = unserialize(CONTACT_INTERESTS);
	$interestOptions = "";
	$interestValue = 1;
	foreach ($interests as $interest){
		$interestOptions .= "<option value=\"" . $interestValue . "\">" . $interest . "</option>";
		$interestValue += 1;
	}
	$content = str_replace('@INTERESTS@', $interestOptions, $content);
?>