<?php
//error_reporting(E_ALL);
//ini_set('display_errors',1);
include('../db.php'); 

function died($message, $script) {
	//echo "Sorry, but there were error(s) found with the form you submitted. ";
	//echo "Please check your entry and try again";
	echo $message;
	echo $script;
	die();
}

/* VALIDATE FORM */
if (isset($_POST['fname'])) $fname = $_POST['fname'];
else $fname = ''; //required, validation done in javascript
if (isset($_POST['lname'])) $lname = $_POST['lname'];
else $lname = ''; //required, validation done in javascript
if (isset($_POST['company'])) $company  = $_POST['company'];
else $company = ''; //optional
if(isset($_POST['email']))$email = $_POST['email'];
else $email = ''; //required, validation done here

$error_message = "";
$error_script = '<script type="text/javascript">if (typeof $ != \'undefined\') {';

/* Email*/
$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
if (preg_match($email_exp, $email)==0){
	$error_message .= 'Invalid email.';
	$error_script .= '$("#semail").addClass(".has-error"); ';
}

$error_script .= "}</script>";
if(strlen($error_message) > 0) {
	died($error_message, $error_script);
}

/* UPDATE DATABASE */
$user = MarketingUserIdWithEmail($email); //check if this user already exists in our database
if ($user > 0){
	if (UpdateMarketingUser($user, "$fname $lname", '', $company, $phone, 1)){
//		echo 'Updated marketing user '.$user."...\n";
	} else {
//		echo 'Failed to update marketing user '.$user."...\n";
	}
		;
} else {
	if (AddMarketingUser("$fname $lname", '', $company, $email, $phone, 0, $app, 1)){
		$user = MarketingUserIdWithEmail($email);
//		echo 'Added marketing user '.$user."...\n";
	} else {
//		echo 'Failed to add marketing user '.$user."...\n";
	};
}

function clean_string($string) {
	$bad = array("content-type","bcc:","to:","cc:","href");
	return str_replace($bad,"",$string);
}

/* FIRST MESSAGE: TO GIULIETTA FROM SUBSCRIBER */
$email_from = $email;

$email_to = "giulietta@fusionpipe.com";
//$email_to = "tricha.oh@fusionpipe.com"; //for testing
// $email_to = "julian.pradinuk@fusionpipe.com"; //for testing
$email_subject = "Newsletter Subscription Request from Fusionpipe.com";
$email_message = "Form details below.\r\n\r\n";
$email_message .= "Email: ".clean_string($email_from)."\r\n";
$email_message .= "First name: ".clean_string($fname)."\r\n";
$email_message .= "Last name: ".clean_string($lname)."\r\n";
$email_message .= "Company: ".clean_string($company)."\r\n";
$headers = 	'From: '.$email_from."\r\n".
			'Reply-To: '.$email_from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);

/* SECOND MESSAGE: TO SUBSCRIBER */
$email_to = $email_from;
$email_from = "newsletter@fusionpipe.com";
$email_subject = "Thanks for subscribing";
	
// Always set content-type when sending HTML email
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";
$headers .= 'From: '.$email_from."\r\n". //is there a FusionPipe noreply email? No reply?
				'Reply-To: '.$email_from."\r\n" .
				'X-Mailer: PHP/' . phpversion();
	
$email_message = file_get_contents('../downloads/howto_email/subscription_confirmation.html');
@mail($email_to, $email_subject, $email_message, $headers);
?>
Thank you. You have successfully subscribed to our newsletter.
Please check your inbox for confirmation.
<script type='text/javascript'>
	if (typeof $ != 'undefined'){
		$('#email').hide();
		$('#subscribe_btn').hide();
		$('#sfstep').html('');
	}
</script>