<?php
require 'vendor/autoload.php';  // Path to vendor/autoload.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);  // Create a new PHPMailer instance

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp-mail.outlook.com';  // Use your mail server (e.g., Outlook)
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@outlook.com';  // Your email
    $mail->Password = 'your-email-password';     // Your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('your-email@outlook.com', 'Mailer');
    $mail->addAddress('recipient-email@example.com', 'Recipient');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = 'This is a <b>test email</b> sent using PHPMailer.';

    // Send the email
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
