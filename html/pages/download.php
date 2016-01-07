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

if (isset($_POST['user'])) $user = (int) $_POST['user'];
else $user = 0;
if (isset($_POST['fname'])) $fname = $_POST['fname'];
else $fname = ''; //required
if (isset($_POST['lname'])) $lname = $_POST['lname'];
else $lname = '';
if(isset($_POST['email']))$email = $_POST['email'];
else $email = ''; //required
if (isset($_POST['company'])) $company  = $_POST['company'];
else $company = '';
if (isset($_POST['phone'])) $phone = $_POST['phone'];
else $phone = '';
if (isset($_POST['app']))$app = (int) $_POST['app'];
else $app = 0; //Windows = 1, Android = 2
if (isset($_POST['version'])) $version = $_POST['version'];
else $version = '';
if (isset($_POST['adverts']))$adv = (int) $_POST['adverts'];
else $adv = 0;

if ($user < 1){
	/* VALIDATE FORM */
	$error_message = "<div class=\"error-box\">Please fill out all required fields";
	$error_script = '<script type="text/javascript">if (typeof $ != \'undefined\') {$("#download-form").show(); $("html, body").animate({ scrollTop: 0 }, "slow");';
	$error_count = 0;
	
	/* Name */
	if (strlen($fname) < 1){
		$error_count += 1;
		//$error_message .= "<li>your name</li>";
		$error_script .= '$("#dfname").addClass("has-error"); ';
	}
	
	/* Email*/
	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
	if (preg_match($email_exp, $email)==0){
		$error_count += 1;
		//$error_message .= '<li>a valid email address</li>';
		$error_script .= '$("#demail").addClass("has-error"); ';
	}
	
	/* Phone */
	if (strlen($phone) > 0){
		$phone = preg_replace('/\D/', '', $phone);
		//TODO: validate phone number
// 		if (strlen($phone) != 10) {
// 			$error_count += 1;
// 			//$error_message .= '<li>a valid (10-digit) phone number</li>';
// 			$error_script .= '$("#dphone").addClass("has-error"); ';
// 		}
	}
	
	$error_message .= "</div>";
	$error_script .= "}</script>";
	if ($error_count > 0) {
		died($error_message, $error_script);
	}
	
	/* UPDATE DATABASE */
	$user = MarketingUserIdWithEmail($email); //check if this user already exists in our database
	if ($user > 0){
		if (UpdateMarketingUser($user, $fname, '', $company, $phone, 0)){
// 			echo 'Updated user '.$user."...\n";
		} else {
// 			echo 'Failed to add new marketing user '.$user."...\n";
		}
	}
}
if ($user > 0){
	$fname = MarketingUserNameWithId($user);
	$email = MarketingUserEmailWithId($user);
	$company = MarketingUserCompanyWithId($user);
	$phone = MarketingUserPhoneWithId($user);
} else {
	if (AddMarketingUser($fname, '', $company, $email, $phone, 0, $app, 0)){
		$user = MarketingUserIdWithEmail($email);
// 		echo 'Added new marketing user '.$user."...\n";
	} else {
// 		echo 'Failed to add new marketing user '.$user."...\n";
	}
}

if ($user > 0) {
	if (AddDownload($user, $app, $version)){
// 		echo 'Added download for user '.$user.', app '.$app.'v.'.$version."...\n";
	}
}
/* HANDLE DOWNLOAD */
?>
<div class="thanksDown">Thank you for downloading!</div>
<script type='text/javascript'>
	var now = new Date();
	now.setFullYear(now.getFullYear() + 10); //expire in 10 years
	document.cookie = 'fp_usr=<?php echo $user ?>;expires=' + now.toUTCString() + ';path=/';
	if (typeof $ != 'undefined'){
		 $('#download-form').hide();
		 $('#dusr').val('<?php echo $user ?>');
		 $('html, body').animate({ scrollTop: 0 }, 'slow');
	}
</script>
<?php
if ($app == 1){ //Windows
?>
<script type='text/javascript'>
	top.location.href ='/downloads/QuikID-installer5_2_0.exe';
</script>
<?php
}
else if ($app == 2){ //Android
?>
<script type='text/javascript'>
	top.location.href ='/downloads/quikID-pro-release4_5_7.apk';
</script>
<?php
}

/* FIRST MESSAGE */
$email_from = $email;

$email_to = "pat.hennessy@fusionpipe.com, giulietta@fusionpipe.com"; // your email address
//$email_to = "kzapior@fusionpipe.com"; //for testing
// $email_to = "julian.pradinuk@fusionpipe.com"; //for testing
//$email_to = "tricha.oh@fusionpipe.com"; //for testing
$email_subject = "QuikID Download";

function clean_string($string) {
	$bad = array("content-type","bcc:","to:","cc:","href");
	return str_replace($bad,"",$string);
}

$email_message = "Download information below.\r\n\r\n";
$email_message .= "Name: ".clean_string($fname)."\r\n";
$email_message .= "Company: ".clean_string($company)."\r\n";
$email_message .= "Phone: ".clean_string($phone)."\r\n";
$email_message .= "Email: ".clean_string($email_from)."\r\n";
switch ($app){
	case 1:
		$email_message .= "App: QuikID-Windows, v.$version\r\n";
		break;
	case 2:
		$email_message .= "App: QuikID-Android, v.$version\r\n";
		break;
	default:
		break;
}

$headers = 	'From: '.$email_from."\r\n".
			'Reply-To: '.$email_from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);
?>
