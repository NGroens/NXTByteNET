<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMail($user_email, $user_name, $mailContent, $mailSubject, $emailAltBody, $emailExtra, $emailExtra2){

    include 'app/mail/PHPMailer/mail_style.php';

    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'plesk.nxtbyte.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@nxtbyte.net';
        $mail->Password = 'pw';
        $mail->SMTPSecure = 'tls';
        //$mail->SMTPAutoTLS = false;
        $mail->Port = 25;

        $mail->setFrom('noreply@nxtbyte.net', 'NXTByte Kundensupport');
        $mail->addAddress($user_email, $user_name);

        $mail->isHTML(true);
        $mail->Subject = $mailSubject;
        $mail->Body = $emailBody;
        $mail->AltBody = $emailAltBody;

        $mail->send();
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

}