<?php
session_start();
require __DIR__ . "/../config/Database.php"; // If you need database connection for fetching email

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php'; // For PHPMailer

if (!isset($_SESSION['temp_user'])) {
    header("Location: index.php");
    exit;
}

try {
    // Generate new OTP
    $new_otp = rand(100000, 999999);
    $_SESSION['temp_user']['otp'] = $new_otp;
    $_SESSION['temp_user']['otp_created'] = time();

    // Fetch email again from applicants table
    $query = "SELECT email FROM applicants WHERE id = :applicant_id LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute(['applicant_id' => $_SESSION['temp_user']['applicant_id']]);
    $applicant = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$applicant) {
        throw new Exception("Applicant email not found.");
    }

    $email = $applicant->email;
    $username = $_SESSION['temp_user']['username'];

    // Send email
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'fantastiassasin@gmail.com';  // your gmail
    $mail->Password   = 'ifst tyvw lflb bsfr';        // your app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('fantastiassasin@gmail.com', 'HR Portal');
    $mail->addAddress($email, $username);

    $mail->isHTML(true);
    $mail->Subject = 'Your New OTP Code';
    $mail->Body    = "Hello {$username},<br><br>Your new OTP is: <b>{$new_otp}</b><br><br>This code will expire in 5 minutes.";

    $mail->send();

    // Redirect back to verify page with success
    header("Location: verify_otp.php?resend=success");
    exit;

} catch (Exception $e) {
    // In case email sending fails
    header("Location: verify_otp.php?resend=fail");
    exit;
}
?>
