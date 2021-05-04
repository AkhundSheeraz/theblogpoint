<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './includes/PHPMailer-master/src/Exception.php';
require './includes/PHPMailer-master/src/PHPMailer.php';
require './includes/PHPMailer-master/src/SMTP.php';

class mailer
{
    public $getmail;
    public $vlink;

    function __construct($getmail, $vlink)
    {
        $this->mail = $getmail;
        $this->link = $vlink;
    }
    function send_mail()
    {

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                            //Enable verbose debug output
            $mail->isSMTP();                                                  //Send using SMTP
            $mail->SMTPOptions = array('ssl'=>array('verify_peer_name'=>false));
            $mail->Host       = gethostbyname("smtp.gmail.com");                             //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                         //Enable SMTP authentication
            $mail->Username   = 'akhund.imdad';                               //SMTP username
            $mail->Password   = '640509-04014700747';                           //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;               //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                          //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('tech@blogpoint.com', 'tech@blogpoint');
            $mail->addAddress($this->mail);                                   // add a recipient

            $vmailcontent = "<p><strong>Dear user</strong> please click this link ". $this->link ." to verify your e-mail for the registration at blogpoint</p>";

            //Content
            $mail->isHTML(true);                                              //Set email format to HTML
            $mail->Subject = 'The Blog Point';
            $mail->Body    = $vmailcontent;
            $mail->AltBody = strip_tags($vmailcontent);

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}


