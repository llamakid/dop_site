<?php

include_once('config.php');


//set timezone and get date
date_default_timezone_set('America/Chicago');
$date = date('m/d/Y h:i:s a', time());

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http"; 
  
// Here append the common URL characters. 
$link .= "://"; 
  
// Append the host(domain name, ip) to the URL. 
$link .= $_SERVER['HTTP_HOST']; 
  
// Append the requested resource location to the URL 
$link .= $_SERVER['REQUEST_URI']; 

$linkShort = $_SERVER['HTTP_HOST'];

switch ($link) {
   case 'http://dentistryonpurpose.com/mail/contact_me.php':
      $linkPageName = 'Home Page';
   break;
   case 'http://dentistryonpurpose.com/mail/contact_verify.php':
      $linkPageName = 'Verify Page';
   break;
   case 'http://dentistryonpurpose.com/mail/contact_rosters.php':
      $linkPageName = 'Rosters Page';
   break;
   case 'http://dentistryonpurpose.com/mail/contact_reports.php':
      $linkPageName = 'Reports Page';
   break;
   case 'http://dentistryonpurpose.com/mail/contact_contact.php':
      $linkPageName = 'Contact Page';
   break;
   default:
   $linkPageName = 'Home Page';
}

// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['phone']) 		||
   empty($_POST['group']) 		||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	   echo "No arguments Provided!";
	   return false;
   }
	
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$group = strip_tags(htmlspecialchars($_POST['group']));
$message = strip_tags(htmlspecialchars($_POST['message']));
$domain = $linkShort;
$source = $linkPageName;
$user_IP = $_SERVER['REMOTE_ADDR'];
$_group = $group;
$msg = $message;
$email = $email_address;
	
// Create the email and send the message
$to = 'website@dentistryonpurpose.com'; 
// $to = 'nate@dentistryonpurpose.com'; 
$email_subject = "Contact Form: $date - $name - $phone - from: $linkPageName";
$email_body = "<html><body>";
$email_body .= "<h3>You have received a new message from your website contact form, on the $linkPageName.</h3>";
$email_body .= "<h4>Here are the details:</h4>";
$email_body .= "<p>Name: $name</p>";
$email_body .= "<p>Email: $email_address</p>";
$email_body .= "<p>Phone: $phone</p>";
$email_body .= "<p>Group: $group</p>";
$email_body .= "<p>Site: $linkShort</p>";
$email_body .= "<p>Page: $linkPageName</p>";
$email_body .= "<p>Message: $message</p>";

$headers = "From: noreply@dentistryonpurpose.com\n";

$headers .= "Reply-To: $email_address";	
//mail($to,$email_subject,$email_body,$headers);
//return true;	

$result = mysqli_query($conn,"INSERT INTO `requests`(`domain`, `source`, `name`, `user_IP`, `email`, `phone`, `_group`, `msg`)
							VALUES ('$domain', '$source', '$name', '$user_IP', '$email', '$phone', '$_group', '$msg')");

$post = [
   'email' => $to,
   'subject' => $email_subject,
   'message'   => $email_body,
];

$ch = curl_init('https://beyondverify.com/send_mail/mail.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

// execute!
$response = curl_exec($ch);

// close the connection, release resources used
curl_close($ch);

// do anything you want with your response
//var_dump($response);

echo $response;
			
?>
