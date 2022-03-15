<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Client\Provider\Google;

class Mailer extends PHPMailer 
{
    function __construct()
    {
        parent::__construct();
        $this->createHTMLMail();
    }
    
    protected function createHTMLMail ()
    {
        $my_mail = '<html lang="pl-PL">
			   <head>
			   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			   <title>Report from ' . date("d.m.Y") . '</title>';
        $file = __DIR__ . '/html/my_mail.html';
        file_put_contents($file, $my_mail);
    }

    public function addDiffToMailBody($header, array $table_headers, csvComparer $csvComparer)
    {
        $my_mail = '<p>' . $header . '</p>';
        $my_mail .= "<table style='border: 1px solid black; border-collapse: collapse'>
                    <tr>";
        foreach ($table_headers as $table_header) {
                    $my_mail .= "<th style='border: 1px solid black'>" . $table_header . "</th>";
                }
        $my_mail .= '</tr>';
        foreach ($csvComparer->getComparisonResults() as $printout) {
            $my_mail .= "<tr><td style='border: 1px solid black'>" . 
                        $printout[$csvComparer->getTags()[1]] . "</td><td style='border: 1px solid black'>" . 
                        $printout[$csvComparer->getTags()[2]] . "</td><td style='border: 1px solid black'>" . 
                        $printout["old_status"]  . "</td><td style='border: 1px solid black'>"  . 
                        $printout[$csvComparer->getTags()[0]] . 
                        "</td></tr>";
        }
        $my_mail .= '</table>';
        $file = __DIR__ . '/html/my_mail.html';
        file_put_contents($file, $my_mail, FILE_APPEND);
    }

    public function addNewToMailBody($header, array $table_headers, csvComparer $csvComparer)
    {
        $my_mail = '<p>' . $header . '</p>';
        $my_mail .= "<table style='border: 1px solid black; border-collapse: collapse'>
                    <tr>";
        foreach ($table_headers as $table_header) {
                    $my_mail .= "<th style='border: 1px solid black'>" . $table_header . "</th>";
                }
        $my_mail .= '</tr>';
        foreach ($csvComparer->getActiveNew() as $printout) {
            $my_mail .= "<tr><td style='border: 1px solid black'>" . 
                        $printout[$csvComparer->getTags()[1]] . "</td><td style='border: 1px solid black'>" . 
                        $printout[$csvComparer->getTags()[2]] . "</td><td style='border: 1px solid black'>" .  
                        $printout[$csvComparer->getTags()[0]] . 
                        "</td></tr>";
        }
        $my_mail .= '</table>';
        $file = __DIR__ . '/html/my_mail.html';
        file_put_contents($file, $my_mail, FILE_APPEND);
    }
    
    public function finishHTMLMail()
    {
        $my_mail = '</head>
                    </html>';
        $file = __DIR__ . '/html/my_mail.html';
        file_put_contents($file, $my_mail, FILE_APPEND);
    }
    
}