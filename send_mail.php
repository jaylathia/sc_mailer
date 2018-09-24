<?php

/*
error_reporting(E_ALL);
ini_set('display_errors', 1);
*/

define('GUSER', ''); // GMail username
define('GPWD', ''); // GMail password
define('SMTP_HOST', 'smtp.gmail.com');
define('DEBUG', 1);
define('FROM_EMAIL', 'sc@shrimadrajchandramission.org');
define('FROM_NAME', 'Sadguru Connects');
define('MAIL_SUBJECT', 'Updates from Sadguru Connects');


/*
$userInfo = [
	"Jay"	=>	"jay_04lathia@yahoo.co.in"
];

$_GET['userInfo'] = json_encode($userInfo);

Sample URL: localhost/send_mail.php?userInfo={"Jay":"jay_04lathia@yahoo.co.in"}

*/


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

$template = file_get_contents('template.html');

$requestData = json_decode($_GET['userInfo']);

$mail = new PHPMailer;

$mail->SMTPDebug = DEBUG;  // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true;  // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
$mail->Host = SMTP_HOST;
$mail->Port = 465;
$mail->Username = GUSER;
$mail->Password = GPWD;


//From email address and name
$mail->From = FROM_EMAIL;
$mail->FromName = FROM_NAME;

// $mail->addReplyTo("reply@yourdomain.com", "Reply");

foreach ($requestData as $name => $email) {
	$mail->addAddress($email, $name);
	$mail->isHTML(true);

	$mail->Subject = MAIL_SUBJECT;
	$mail->Body = str_replace('$first name$', $name, $template);
	$mail->AltBody = "This is the plain text version of the email content";

	if(!$mail->send()) 
	{
	    echo "Mailer Error: " . $mail->ErrorInfo;
	} 
	else 
	{
	    echo "Message has been sent successfully";
	}
}

