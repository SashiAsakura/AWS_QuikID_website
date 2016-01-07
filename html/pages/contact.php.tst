<?php
	$areas_of_int = array("QuickSafe Solutions","Partner","Other");
	require_once('sweetcaptcha.php');
	$contact = 'class="on"';
	$title = "Contact";
	$contacttpl = file_get_contents('pages/contact.tpl');
	$action = _GET('action','');
	
	
	$name = secureText(_POST('inputName',''));
	$email = secureText(_POST('inputEmail',''));
	$company = secureText(_POST('inputCompany',''));
	$phone = secureText(_POST('inputPhone',''));
	$interest = (int)_POST('inputSelect','');
	$message = secureText(_POST('inputMessage',''));
	
	if (isset($areas_of_int[$interest]))$interest_s = $areas_of_int[$interest];else $interest_s = "it was try of attack, so don't need to reply... just skip him ;)";
	
	$contactfrm = file_get_contents('pages/contact.frm.tst');
	
	
	$what  = array("@@NAME@@","@@EMAIL@@","@@COMPANY@@","@@PHONENUM@@","@@MESSAGE@@");
	$towhat= array($name,$email,$company,$phone,$message);
	
	
	/*
	$contactfrm = str_replace("@@NAME@@", $name, $contactfrm);
	$contactfrm = str_replace("@@EMAIL@@", $email, $contactfrm);
	$contactfrm = str_replace("@@COMPANY@@", $company, $contactfrm);
	$contactfrm = str_replace("@@PHONENUM@@", $phone, $contactfrm);
	$contactfrm = str_replace("@MESSAGE@", $message, $contactfrm);
	
	*/
	$contactfrm = str_replace($what, $towhat, $contactfrm);
	$captchaCorrect = 0;
	$captcha = $sweetcaptcha->get_html();
	if (!empty($_POST)){
		if (isset($_POST['sckey']) and isset($_POST['scvalue']) and $sweetcaptcha->check(array('sckey' => $_POST['sckey'], 'scvalue' => $_POST['scvalue'])) == "true") {
			$captchaCorrect = 1;
		}else $captchaCorrect = -1;
	}
	if (($captchaCorrect==1)&&($action == 'dosend')){

		$myemail = 'tricha.oh@fusionpipe.com';
		//$myemail = 'kzapior@fusionpipe.com';
		$errorstr = '';
		if (!$name)$errorstr .= " Name";
		if (!$email)$errorstr.= " E-mail Address";
		if (!$company)$errorstr.= " Company";
		if (!$phone)$errorstr.= " Phone Number";
		if (!$interest)$errorstr.= " Area of Interest"; 
		if (!$message)$errorstr.= " Message";
	
		$sent_success = 0;
	
		if ($errorstr!=""){
			$errorstr = 'Error!'.$errorstr." have an invalid value";
		}else{//1
			/* If e-mail is not valid show error message */
			if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)){
			
				/* Let's prepare the message for the e-mail */
				$subject = " $name has sent you a message";
	
				$message = "$name has sent you a message using your contact form:
Name: $name
Email: $email
Company: $company
Phone: $phone
Area of Interest: $interest_s
Message:
$message";
				if (isset($_POST['cadv'])){
					$adverts = 1;
				}else $adverts = 0;
				/* Send the message using mail() function */
				if (mail($myemail, $subject, $message)){
					$sent_success = 1; 
				}else{
					$errorstr = "Unfortunately we couldn't deliver your email, please try to contact us using phone";
				}
				AddMarketingUser($name,'',$company,$email,3,$interest,$adverts);
			}else{
				$errorstr = "Invalid e-mail address";
			}
		}//1
		if ($sent_success){
			$thankinfo = file_get_contents('pages/contact.thx');
			$contacttpl = str_replace('@CONTACT@',$thankinfo,$contacttpl);		
		}else {
			$contacttpl = str_replace('@CONTACT@',$contactfrm,$contacttpl);
		}
	}//dosend
	else{
		//nobody sends :(
		$contacttpl = str_replace('@CONTACT@',$contactfrm,$contacttpl);
	}	
	if ($captchaCorrect == -1){
		$errorstr = "The images are not matched correctly. Please try again.";
	}
	$contacttpl = str_replace("@CAPTCHA@",$captcha,$contacttpl);
	$contacttpl = str_replace("@ERROR@", $errorstr, $contacttpl);
	$content = $contacttpl;
	
?>