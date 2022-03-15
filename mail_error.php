<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Mailer.php';

$mail = new Mailer();
$mail->CharSet = PHPMailer::CHARSET_UTF8;
$mail->isSMTP();
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->SMTPOptions = array(
'ssl' => array(
'verify_peer' => false,
'verify_peer_name' => false,
'allow_self_signed' => true
)
);
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPAuth = true;
$mail->Username = 'test';
$mail->Password = 'test';
$mail->setFrom('test@test.pl', 'TEST');
$mail->addReplyTo('test@test.pl', 'TEST');
include 'mail_error_addresses.php';
$mail->Subject = 'An error occurred on ' . date("d.m.Y");
$mail->msgHTML(file_get_contents('mail_error.html'), __DIR__);
$mail->AltBody = 'This is a plain-text message body';
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}