<?php
// error_reporting(E_ALL);
// ini_set('display_errors',1);
include('../db.php');

function died($message, $script) {
// 	echo "Sorry, but there were error(s) found in the form you submitted.\n";
// 	echo "Please check your entry and try again.";
	echo $message;
	echo $script;
	die();
}

if (isset($_POST['fname'])) $fname = $_POST['fname'];
else $fname = ''; //required
if (isset($_POST['company'])) $company = $_POST['company'];
else $company = ''; //required
if (isset($_POST['phone'])) $phone = $_POST['phone'];
else $phone = ''; //optional
if(isset($_POST['email']))$email = $_POST['email'];
else $email = ''; //required

/* VALIDATE FORM */
$error_message = "<div class=\"error-box\">Please fill out all required fields";
$error_script = '<script type="text/javascript">if (typeof $ != \'undefined\') {$("#discovery-form").show(); $("html, body").animate({ scrollTop: 0 }, "slow");';
$error_count = 0;
	
/* Name */
if (strlen($fname) < 1){
	$error_count += 1;
	// $error_message .= "<li>your name</li>";
	$error_script .= '$("#dfname").addClass("has-error"); ';
}

/* Company */
if (strlen($company) < 1){
	$error_count += 1;
	// $error_message .= "<li>your company</li>";
	$error_script .= '$("#dcompany").addClass("has-error"); ';
}
		
/* Phone */
if (strlen($phone) > 0){
	$phone = preg_replace('/\D/', '', $phone);
	//TODO: validate phone number
	
// 	if (strlen($phone) != 10) {
// 		$error_count += 1;
// 		$error_message .= '<li>a valid (10-digit) phone number</li>';
// 		$error_script .= '$("#dphone").addClass(".has-error"); ';
// 	}
}

/* Email*/
$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
if (preg_match($email_exp, $email)==0){
	$error_count += 1;
	// $error_message .= '<li>a valid email address</li>';
	$error_script .= '$("#demail").addClass("has-error"); ';
}
	
$error_message .= "</div>";
$error_script .= "}</script>";
if ($error_count > 0) {
	died($error_message, $error_script);
}
	
/* UPDATE DATABASE */
$user = MarketingUserIdWithEmail($email); //check if this user already exists in our database
$user = MarketingUserIdWithEmail($email); //check if this user already exists in our database
if ($user > 0){
	if (UpdateMarketingUser($user, $fname, '', $company, $phone, 1)){
//		echo 'Updated marketing user '.$user."...\n";
	} else {
//		echo 'Failed to update marketing user '.$user."...\n";
	}
}  else {
	if (AddMarketingUser("$fname $lname", '', $company, $email, $phone, 0, $app, 1)){
		$user = MarketingUserIdWithEmail($email);
//		echo 'Added marketing user '.$user."...\n";
	} else {
//		echo 'Failed to add marketing user '.$user."...\n";
	};
}


?>
<div class="tksDiscovery"><a href="http://www.quikid.ca/"><img alt="QuikID Logo" src="http://www.quikid.ca/downloads/howto_email/quikid_logo.png"></a><p>Thank you for your interest in QuikID<sup>TM</sup> Authentication Solutions for Enterprises. We will contact you shortly to set up a discovery session.</p></div>
<script type='text/javascript'>
	var now = new Date();
	now.setFullYear(now.getFullYear() + 10); //expire in 10 years
	document.cookie = 'fp_usr=<?php echo $user ?>;expires=' + now.toUTCString() + ';path=/';
	if (typeof $ != 'undefined'){
		 $('#discovery-form').hide();
		 $('#dusr').val('<?php echo $user ?>');
		 $('html, body').animate({ scrollTop: 0 }, 'slow');
	}
</script>
<?php
/* FIRST MESSAGE: TO PAT AND GIULIETTA FROM DISCOVERY REQUESTER */
$email_from = $email;

$email_to = "pat.hennessy@fusionpipe.com , giulietta@fusionpipe.com"; // your email address
//$email_to = "kzapior@fusionpipe.com"; //for testing
//$email_to = "julian.pradinuk@fusionpipe.com"; //for testing
//$email_to = "tricha.oh@fusionpipe.com"; //for testing
$email_subject = "QuikID Discovery Session Request from Fusionpipe.com";

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

/* SECOND MESSAGE: TO DISCOVERY REQUESTER */
$email_to = $email_from;
$email_from = 'info@fusionpipe.com';
$email_subject = 'Thank you for requesting a discovery session with FusionPipe';
// Always set content-type when sending HTML email
$headers = 'MIME-Version: 1.0' ."\r\n";
$headers .= 'Content-type:text/html;charset=UTF-8'."\r\n";

$headers .= 'From: '.$email_from."\r\n".
			'Reply-To: '.$email_from."\r\n".
			'X-Mailer: PHP/' . phpversion();

$email_message = file_get_contents('../downloads/howto_email/quikid_confirmation.html');
//$email_message = str_replace('%user%', $fname, $email_message);
@mail($email_to, $email_subject, $email_message, $headers);
?>


