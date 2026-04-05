<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_POST['check-email']))
{
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication


    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->Username   = 'deshmukhtejas6529@gmail.com';                     //SMTP username
    $mail->Password   = 'sgljoxuwzfktftcjw';                               //SMTP password

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

    //Recipients
    $mail->setFrom('deshmukhtejas6529@gmail.com', 'placement portal');
    $mail->addAddress('deshmukhtejas6529@gmail.com', 'placement portal');     //Add a recipient
   


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Login Verification code';
    $mail->Body    = 'otp:-';


    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}
else{
header('Location:login-user.php')
}
?>