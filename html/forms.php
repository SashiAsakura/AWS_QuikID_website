<?php
include_once('db.php');
include_once('utils.php');

defined('CONTACT_FORM')
or define('CONTACT_FORM', 4);

defined('DISCOVERY_FORM')
or define('DISCOVERY_FORM', 3);

defined('DOWNLOAD_FORM')
or define('DOWNLOAD_FORM', 2);

defined('SUBSCRIBE_FORM')
or define('SUBSCRIBE_FORM', 1);

function died($message, $script) {
	echo $message;
	echo $script;
	die();
}

function clean_string($string) {
	$bad = array("content-type","bcc:","to:","cc:","href");
	return str_replace($bad,"",$string);
}

function validateForm(){
	global $form, $fname, $email, $company, $phone, $interest, $interest_s, $message, $app, $version, $adv;
	
	$error_count = 0;
	$error_message = "";
	$error_script = '<script type="text/javascript">if (typeof $ != \'undefined\') {';
	$script = $error_script;
	
	switch ($form){
		case CONTACT_FORM:
			$error_message = "<div class=\"error-box\">Please fill out all required fields";
			$error_script .= '$("#commentForm").show();';
			
			/* Name */
			if (strlen($fname) < 1){
				$error_count += 1;
				// $error_message .= "<li>your name</li>";
				$error_script .= '$("#inputName").addClass("has-error"); ';
			} else {
				$error_script .= '$("#inputName").removeClass("has-error"); ';
			}
			
			/* Company */
			if (strlen($company) < 1){
				$error_count += 1;
				// $error_message .= "<li>your company</li>";
				$error_script .= '$("#inputCompany").addClass("has-error"); ';
			} else {
				$error_script .= '$("#inputCompany").removeClass("has-error"); ';
			}
			
			/* Phone */
			if (strlen($phone) < 1){
				$error_count += 1;
				$error_script .= '$("#inputPhone").addClass("has-error"); ';
			} else {
				$phone = preg_replace('/\D/', '', $phone);
				if (strlen($phone) < 1){
					//TODO: validate phone number
					// 	if (strlen($phone) != 10) {
					// 		$error_count += 1;
						// 		$error_message .= '<li>a valid (10-digit) phone number</li>';
						// 		$error_script .= '$("#dphone").addClass(".has-error"); ';
					// 	}
					
					$error_count += 1;
					$error_message = "<div class=\"error-box\">Please enter a valid phone number";
					$error_script .= '$("#inputPhone").addClass("has-error"); ';
				} else {
					$error_script .= '$("#inputPhone").removeClass("has-error"); ';
				}
			}
	
			/* Interest */
// 			if (!in_array($interest, unserialize(CONTACT_INTERESTS))) {
// 				die();
// 			}
			
			/* Email */
			if (strlen($email) < 1){
				$error_count += 1;
				// $error_message .= "<li>your email address</li>";
				$error_script .= '$("#inputEmail").addClass("has-error"); ';
			}
			else if ($error_count == 0 && !filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error_count += 1;
				$error_message = "<div class=\"error-box\">Please enter a valid email address";
				$error_script .= '$("#inputEmail").addClass("has-error"); ';
			}
			else {
				$error_script .= '$("#inputEmail").removeClass("has-error"); ';
			}
				
			$error_message .= "</div>";
			break;
			
		case DISCOVERY_FORM:
			$error_message = "<div class=\"error-box\">Please fill out all required fields";
			$error_script .= '$("#discovery-form").show(); ';
			
			/* Name */
			if (strlen($fname) < 1){
				$error_count += 1;
				// $error_message .= "<li>your name</li>";
				$error_script .= '$("#dfname").addClass("has-error"); ';
			} else {
				$error_script .= '$("#dfname").removeClass("has-error"); ';
			}
			
			/* Company */
			if (strlen($company) < 1){
				$error_count += 1;
				// $error_message .= "<li>your company</li>";
				$error_script .= '$("#dcompany").addClass("has-error"); ';
			} else {
				$error_script .= '$("#dcompany").removeClass("has-error"); ';
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
			
			/* Email */
			if (strlen($email) < 1){
				$error_count += 1;
				// $error_message .= "<li>your email address</li>";
				$error_script .= '$("#demail").addClass("has-error"); ';
			}
			// 			$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
			// 			if (preg_match($email_exp, $email)==0){
			else if ($error_count == 0 && !filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error_count += 1;
				$error_message = "<div class=\"error-box\">Please enter a valid email address";
				$error_script .= '$("#demail").addClass("has-error"); ';
			}
			else {
				$error_script .= '$("#demail").removeClass("has-error"); ';
			}
			
			$error_message .= "</div>";
			break;
			
		case DOWNLOAD_FORM:
			$error_message = "<div class=\"error-box\">Please fill out all required fields";
			
			/* Name */
			if (strlen($fname) < 1){
				$error_count += 1;
				// $error_message .= "<li>your name</li>";
				$error_script .= '$("#dfname").addClass("has-error"); ';
			} else {
				$error_script .= '$("#dfname").removeClass("has-error"); ';
			}
			
			/* Email */
			if (strlen($email) < 1){
				$error_count += 1;
				// $error_message .= "<li>your email address</li>";
				$error_script .= '$("#demail").addClass("has-error"); ';
			}
			// 			$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
			// 			if (preg_match($email_exp, $email)==0){
			else if ($error_count == 0 && !filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error_count += 1;
				$error_message = "<div class=\"error-box\">Please enter a valid email address";
				$error_script .= '$("#demail").addClass("has-error"); ';
			}
			else {
				$error_script .= '$("#demail").removeClass("has-error"); ';
			}
			
			$error_message .= "</div>";
			break;
			
		case SUBSCRIBE_FORM:
			/* Name */
			if (isset($_POST['fname'])) $fname = $_POST['fname']; //required, validation done in javascript
			if (strlen($fname) < 1){
				$error_count += 1;
				$error_message .= "Name is required.\n";
				$error_script .= '$("#sfname").addClass(".has-error"); ';
			} else {
				$error_script .= '$("#sfname").removeClass(".has-error"); ';
			}
			
			/* Company */
			if (isset($_POST['company'])) $company  = $_POST['company']; //optional
			
			/* Email */
			if(isset($_POST['email'])) $email = $_POST['email']; //required, validation done here
// 			$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
// 			if (preg_match($email_exp, $email) == 0){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error_count += 1;
				$error_message .= "Invalid email.";
				$error_script .= '$("#semail").addClass(".has-error"); ';
			} else {
				$error_script .= '$("#sfname").removeClass(".has-error"); ';
			}
			
			$adv = 1;
			break;
			
		default:
			died("","");
			break;
	}
		
	$error_script .= '$(".has-error:first").focus(); }</script>';
	if ($error_count > 0){
		died($error_message, $error_script);
	}
}

function sendInternalEmail(){
	global $form, $fname, $email, $company, $phone, $interest, $interest_s, $message, $app, $version, $adv;
	
	$email_from = $email;
	$email_to = "";
	switch ($form){
		case CONTACT_FORM:
			$email_to = "pat.hennessy@fusionpipe.com, giulietta@fusionpipe.com, david.snell@fusionpipe.com";
			$email_subject = "$fname has sent you a message";
			$email_message = "Form details below:\r\n\r\n".
					"Name: $fname\r\n" .
					"Email: $email\r\n" .
					"Company: $company\r\n" .
					"Phone: $phone\r\n" .
					"Area of Interest: $interest_s\r\n" .
					"Message: $message\r\n";
			break;
		case DISCOVERY_FORM:
			$email_to = "pat.hennessy@fusionpipe.com , giulietta@fusionpipe.com";
			$email_subject = "QuikID Discovery Session Request from Fusionpipe.com";
			$email_message = "Form details below.\r\n\r\n";
			$email_message .= "Name: ".clean_string($fname)."\r\n";
			$email_message .= "Company: ".clean_string($company)."\r\n";
			$email_message .= "Phone: ".clean_string($phone)."\r\n";
			$email_message .= "Email: ".clean_string($email_from)."\r\n";
			break;
		case DOWNLOAD_FORM:
			$email_to = "pat.hennessy@fusionpipe.com, giulietta@fusionpipe.com";
			$email_subject = "QuikID Download";
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
			break;
		case SUBSCRIBE_FORM:
			$email_to = "giulietta@fusionpipe.com";
			$email_subject = "Newsletter Subscription Request from Fusionpipe.com";
			$email_message = "Form details below.\r\n\r\n";
			$email_message .= "Name: ".clean_string($fname)."\r\n";
			$email_message .= "Company: ".clean_string($company)."\r\n";
			$email_message .= "Email: ".clean_string($email_from)."\r\n";
			break;
		default:
			trigger_error("Unexpected form type");
			return;
	}
	
	if (isDevMode()) {
		$email_to = DEV_INTERNAL_EMAIL; //for testing
	}
	
	$headers = 	'From: '.$email_from."\r\n".
			'Reply-To: '.$email_from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
	@mail($email_to, $email_subject, $email_message, $headers);	
}
 
function sendEmailConfirmation(){
	global $form, $fname, $email, $company, $phone, $interest, $interest_s, $message, $app, $version, $adv;
	$email_to = $email;
	$email_from = "";
	switch ($form){
		case CONTACT_FORM:
			return;
		case DISCOVERY_FORM:
			$email_from = "info@fusionpipe.com";
			$email_subject = 'Thank you for requesting a discovery session with FusionPipe';
			$email_message = file_get_contents('downloads/howto_email/quikid_confirmation.html');
			break;
		case DOWNLOAD_FORM:
			return;
		case SUBSCRIBE_FORM:
			$email_from = "newsletter@fusionpipe.com";
			$email_subject = "Thank you for subscribing";
			$email_message = file_get_contents('downloads/howto_email/subscription_confirmation.html');
			break;
		default:
			trigger_error("Unexpected form type");
			return;
	}
	
	$headers = 'MIME-Version: 1.0' ."\r\n";
	$headers .= 'Content-type:text/html;charset=UTF-8'."\r\n";
	$headers .= 'From: '.$email_from."\r\n".
			'Reply-To: '.$email_from."\r\n".
			'X-Mailer: PHP/' . phpversion();
	@mail($email_to, $email_subject, $email_message, $headers);
}

$form = 0;
$user = 0;
$fname = "";
$email = "";
$company = "";
$phone = "";
$adv = 0;

/* DOWNLOAD */
$app = 0;
$version = "";

/* CONTACT */
$interest = '';
$message = "";


if (isset($_POST['form'])) $form = (int) $_POST['form'];
if (isset($_POST['user'])) $user = (int) $_POST['user'];

if (isset($_POST['fname'])) $fname = secureText($_POST['fname']);
if (isset($_POST['email'])) $email = secureText($_POST['email']);
if (isset($_POST['company'])) $company = secureText($_POST['company']);
if (isset($_POST['phone'])) $phone = secureText($_POST['phone']);
if (isset($_POST['adv'])) $adv = (int) $_POST['adv'];

if (isset($_POST['app'])) $app = (int) $_POST['app'];
if (isset($_POST['version'])) $version = secureText($_POST['version']);

if (isset($_POST['interest'])) $interest = secureText($_POST['interest']);
if (isset($_POST['message'])) $message = secureText($_POST['message']);

if ($form == 0){
	die();
}

if ($user > 0){
	/* QUERY DATABASE */
	$fname = MarketingUserNameWithId($user);
	$email = MarketingUserEmailWithId($user);
	$company = MarketingUserCompanyWithId($user);
	$phone = MarketingUserPhoneWithId($user);
} else {
	/* VALIDATE FORM */
	validateForm();
	
	/* UPDATE DATABASE */
	$user = MarketingUserIdWithEmail($email); //check if this user already exists in our database
	if ($user > 0){
		if (UpdateMarketingUser($user, $fname, '', $company, $phone, $adv)){
		} else trigger_error('Failed to update marketing user '.$user."...\n");
	} else {
		if (AddMarketingUser($fname, '', $company, $email, $phone, 0, $app, $adv)){
			$user = MarketingUserIdWIthEmail($email);
		} else trigger_error("Failed to add new marketing user...\n");
	}
}

/* INTERNAL EMAIL */
sendInternalEmail();

/* EMAIL CONFIRMATION */
sendEmailConfirmation();

/* SHOW RESPONSE */
switch ($form){
	case CONTACT_FORM:
		include('form_success_contact.php');
		break;
		
	case DISCOVERY_FORM:
		$discovery = file_get_contents('form_success_discovery.php');
		$discovery = str_replace('@@user@@', $user, $discovery);
		echo $discovery;
		break;
		
	case DOWNLOAD_FORM:
		if (!AddDownload($user, $app, $version)) trigger_error("Failed to add download...\n");
		$download = file_get_contents('form_success_download.php');
		$download = str_replace('@@user@@', $user, $download);
		
		$file = '';
		if ($app == 1){ //Windows
			$file = '/downloads/QuikID-installer4_5_0.exe';
		} else if ($app == 2) { //Android
			$file = '/downloads/quikID-beta-pro-4_5_0.apk';
		}
		$download = str_replace('@@file@@', $file, $download);
		echo $download;
		break;
		
	case SUBSCRIBE_FORM:
		include('form_success_subscribe.php');
		break;
		
	default:
		trigger_error('Unexpected form type');
		break;
}
