<?php

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$email = $_POST["email"];

if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    echo "Invalid email format";
}else
{    
    $token = bin2hex(random_bytes(32));

    $sql = "INSERT INTO passwordreset (token, email) VALUES ('$token', '$email')";
    if ($mysqli->query($sql) === TRUE)
    {
        $reset_link = "http://localhost/main/newpassword.php?token=$token";
        
        try
        {
            /*$mail->setFrom('SmartAuc@support.com');
            $mail->addAddress($email);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = 'Please, Click The Following Link to Reset Your Password: ' . $reset_link;
            */
            $mail->isSMTP();
            $mail->Host = 'localhost';  // MailHog runs on localhost
            $mail->Port = 1025;  // MailHog default SMTP port
        
            $mail->setFrom('SmartAuc@support.com');
            $mail->addAddress($email);
            $mail->Subject = 'Password Reset Request';
            $mail->Body ='Please, Click The Following Link to Reset Your Password: ' . $reset_link;
            $mail->send();
        
            echo "Password reset link sent successfully";
        }catch (Exception $e)
        {
            echo "Error sending email: " . $mail->ErrorInfo;
        }

    } else {
        echo "Error occurred";
    }
}

$mysqli->close();

?>