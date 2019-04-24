<?php


require("PHPMailer/class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host = "ssl://smtp.gmail.com"; // SMTP server
$mail->From = "shannusha186@gmail.com";
$mail->AddAddress('venkatsaran59@gmail.com');
$mail->Subject = "first mail";
$mail->Body = "hi ! \n\n this is my first PHPMailer email !";
$mail->WordWrap = 50;
 
if(!$mail->Send())
{
   echo "Message was not sent";
   echo "Mailer Error: " . $mail->ErrorInfo;
} else {
   echo "Message has been sent";
}
 
?>