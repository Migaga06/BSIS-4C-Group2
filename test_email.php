<?php
require 'vendor/autoload.php'; // Include PHPMailer via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
$mail->SMTPAuth = true;
$mail->Username = 'bsis4c@teacherleavemanagement.com'; // This must match
$mail->Password = 'Bsis4c_group2'; // The password for the sender email
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port = 465;

$mail->setFrom('bsis4c@teacherleavemanagement.com', 'Your System Name');
$mail->addAddress('tartaglia0128@gmail.com'); // Recipient's email
    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body = 'This is a test email sent using PHPMailer and Hostinger SMTP.';

    // Send the email
    $mail->send();
    echo 'Email sent successfully!';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>




