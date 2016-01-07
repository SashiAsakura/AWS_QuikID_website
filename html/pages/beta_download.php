<?php

//error_reporting(E_ALL);
//ini_set('display_errors',1);
include('../db.php'); 

if(isset($_POST['email'])) {
	function died($error) {
		echo "Sorry, but there were error(s) found in the form you submitted.\n";
		echo "Please check your entry and try again.";
		//echo $error;
		echo '<script type="text/javascript">if (typeof $ != \'undefined\') {$("#download-beta").show(); $("html, body").animate({ scrollTop: 0 }, "slow");}</script>';
		die();
	}

	if (isset($_POST['fname']))$fname = $_POST['fname'];
		else $fname = '';
	if (isset($_POST['company'])) $company  = $_POST['company'];
		else $company = '';
	if (isset($_POST['phone'])) $phone = $_POST['phone'];
		else $phone = '';
	if (isset($_POST['email']))$email_from = $_POST['email'];
		else $email_from = ''; // required
	if (isset($_POST['app']))$app = (int) $_POST['app'];
		else $app = 0;
	if (isset($_POST['adverts']))$adv = (int) $_POST['adverts'];
		else $adv = 0;

	$error_message = "";
	/* Name */
	if (strlen($fname) < 1){
		$error_message .= "Please enter your name.\n";
	}

	if (strlen($company) < 1){
		$error_message .= "Please enter your company.\n";
	}

	if (strlen($phone)>0){
		//$phone_exp = '/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/';
		$phone = preg_replace('/\D/', '', $phone);
		//if (preg_match($phone_exp, $phone)==0){
		if (strlen($phone) != 10) {
			$error_message .= 'Please enter a valid (10-digit) phone number.';
		}
	}

	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
	if (preg_match($email_exp, $email_from)==0){
		$error_message .= 'Please enter a valid email address.';
	}

	if (strlen($error_message) > 0) {
		died($error_message);
	}

	/* FIRST MESSAGE */
	//$email_to = "kzapior@fusionpipe.com"; //for testing
	//$email_to = "julian.pradinuk@fusionpipe.com"; //for testing
	$email_to = "tricha.oh@fusionpipe.com"; //for testing
	//$email_to = "pat.hennessy@fusionpipe.com , giulietta@fusionpipe.com"; // your email address
	$email_subject = "Request received to become a beta tester of QuikID";
	
	function clean_string($string) {
	  $bad = array("content-type","bcc:","to:","cc:","href");
	  return str_replace($bad,"",$string);
	}

	$email_message = "Form details below.\r\n";
	$email_message .= "Name: ".clean_string($fname)."\r\n";
	$email_message .= "Company: ".clean_string($company)."\r\n";
	$email_message .= "Phone: ".clean_string($phone)."\r\n";
	$email_message .= "Email: ".clean_string($email_from)."\r\n";

	$headers = 	'From: '.$email_from."\r\n".
				'Reply-To: '.$email_from."\r\n" .
				'X-Mailer: PHP/' . phpversion();
	@mail($email_to, $email_subject, $email_message, $headers);
	//AddMarketingUser($fname,$lname,$company,$email_from,2,$app,$adv);
	//AddMarketingUser($fname,'',$company,$email_from,2,$app,$adv);
	AddMarketingUser($fname,'',$company,$email_from,$phone,2,$app,$adv);

	/* SECOND MESSAGE */
	$email_to = $email_from;
	$email_from = 'info@fusionpipe.com';
	$email_subject = 'Thank you for singing up to become a beta tester for QuikID';
	// Always set content-type when sending HTML email
	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";

	$headers .= 'From: '.$email_from."\r\n". //is there a FusionPipe noreply email? No reply?
				'Reply-To: '.$email_from."\r\n" .
				'X-Mailer: PHP/' . phpversion();

	$email_message = file_get_contents('../downloads/howto_email/beta_confirmation.html');
	//$email_message = str_replace('%user%', $fname, $email_message);
	@mail($email_to, $email_subject, $email_message, $headers);
}
?>
Your request has been sent successfully.</br> We will contact you shortly.
<script type="text/javascript">if (typeof $ != 'undefined') $("html, body").animate({ scrollTop: 0 }, "slow");</script>
<!--<script  type="text/javascript">top.location.href = 'http://www.fusionpipe.com/downloads/QuikID-installer.exe';</script>-->