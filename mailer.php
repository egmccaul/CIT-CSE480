<?php
// ----------------------------------------- 
//  The Web Help .com
// ----------------------------------------- 
// remember to replace your@email.com with your own email address lower in this code.

// load the variables form address bar
$name = $_REQUEST["name"];
$subject = $_REQUEST["subject"];
$message = $_REQUEST["message"];
$from = $_REQUEST["from"];
$verif_box = $_REQUEST["verif_box"];

// remove the backslashes that normally appears when entering " or '
$name = stripslashes($name); 
$message = stripslashes($message); 
$subject = stripslashes($subject); 
$from = stripslashes($from); 

// check to see if verificaton code was correct
if(md5($verif_box).'a4xn' == $_COOKIE['tntcon']){
	// if verification code was correct send the message and show this page
	$message = "Name: ".$name."\n".$message;
	$message = "From: ".$from."\n".$message;
	$cust_message = $message."\n\n"."We have recieved your request, and will respond momentarily.";
	mail("egmccaul@oakland.edu", 'Online Form: '.$subject, "\n\n".$message, "From: $from \n");
	mail("$from", 'Online Form: '.$subject, "\n\n".$cust_message, "From: $from \n");
	// delete the cookie so it cannot sent again by refreshing this page
	header("Location:".$_SERVER['HTTP_REFERER']);
	setcookie('tntcon','');
} else {
	// if verification code was incorrect then return to contact page and show error
	header("Location:".$_SERVER['HTTP_REFERER']."?subject=$subject&from=$from&message=$message&wrong_code=true");
	exit;
}
?>
