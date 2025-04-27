<?php
session_start();
include 'includes/db_connection.php';
require 'vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if email exists in the database
    $query = "SELECT * FROM users WHERE emailaddress = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Set OTP expiry to 10 minutes from now
        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Save OTP and expiry to the database
        $update_query = "UPDATE users SET otp = '$otp', otp_expiry = '$expiry' WHERE emailaddress = '$email'";
        mysqli_query($conn, $update_query);

        // Send OTP via email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bsis4c@teacherleavemanagement.com'; // Replace with your email
            $mail->Password = 'Bsis4c_group2'; // Replace with your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('bsis4c@teacherleavemanagement.com', 'Teacher Leave Management System');
            $mail->addAddress($email); // User's email
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "Your OTP for password reset is: <b>$otp</b>. It is valid for 10 minutes.";

            $mail->send();
            $_SESSION['success_message'] = "An OTP has been sent to your email.";
            header("Location: verify_otp.php");
            exit;
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Failed to send OTP. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['error_message'] = "Email address not found.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Forgot Password</h2>
        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        }
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="email">Enter your registered email address:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Send OTP</button>
        </form>
    </div>
</body>
</html>

