<?php

include_once('config.php');

$domain = "www.denstistryonpurpose.com";
$source = "verify";
$name = "Nate";
$user_IP = "19.36.48.2";
$email = "salehusman91@gmail.com";
$phone = "+982147856";
$_group = "Archstone";
$msg = "just a test message !";

$result = mysqli_query($conn,"INSERT INTO `requests`(`domain`, `source`, `name`, `user_IP`, `email`, `phone`, `_group`, `msg`)
							VALUES ('$domain', '$source', '$name', '$user_IP', '$email', '$phone', '$_group', '$msg')");
if($result)
{
	echo "insert successful";
}
else
{
	echo "Unsucessfull";
}

?>