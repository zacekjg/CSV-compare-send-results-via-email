<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Client\Provider\Google;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/compare.php';
require_once __DIR__ . '/Mailer.php';

$mail = new Mailer();

$header_diff = 'Changes in the registry:';
$table_headers_diff = [
                        "ID",
                        "Name",
                        "Previous status",
                        "Current status",
];

$mail->addDiffToMailBody($header_diff, $table_headers_diff, $compare);

$header_new = 'Newly added active entities:';
$table_headers_new = [
                           "ID",
                           "Name",
                           "Current status" 
];

$mail->addNewToMailBody($header_new, $table_headers_new, $compare);

$mail->finishHTMLMail();

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
include 'addresses.php';
$mail->Subject = 'TEST Report from' . date("d.m.Y");
$mail->msgHTML(file_get_contents(__DIR__ . '/html/my_mail.html'));
$mail->addAttachment(__DIR__ . '/csv' . '/' . $compare->getCSVNewName() . '.csv');
$mail->addAttachment(__DIR__ . '/csv' . '/' . $compare->getCSVDelName() . '.csv');
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}