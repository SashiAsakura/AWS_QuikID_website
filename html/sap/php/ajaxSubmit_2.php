<?php

$firstname = $_POST['firstname']; // contain name of person
$lastname = $_POST['lastname']; // Your message 
$email = $_POST['email']; // Email address of sender 
$company = $_POST['company']; // Your message 
$title = $_POST['title']; // Email address of sender 

$receiver = "rachid.coutney@fusionpipe.com" ; // hardcorde your email address here - This is the email address that all your feedbacks will be sent to 
if (!empty($firstname) & !empty($lastname) && !empty($email) && !empty($company) && !empty($title)) {
    $body = "First:{$firstname}\n\nLast:{$lastname}\n\nEmail:{$email}\n\nCompany:{$company}\n\nTitle:{$title}";
	$send = mail($receiver, 'Request for Afaria free trial', $body, "From: {$email}");
    if ($send) {
        echo 'true'; //if everything is ok,always return true , else ajax submission won't work
    }

}

?>