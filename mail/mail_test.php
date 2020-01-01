<?php

$post = [
    'email' => 'nate@dentistryonpurpose.com',
    'subject' => 'another Test Email',
    'message'   => "I am going to send another this email as test",
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