<?php
session_start();
require "../../../config/db_talent.php"; // your database config
require "../../../vendor/autoload.php"; // Adjust path if needed

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$base_url = "http://localhost/bcp-hrd";
$verify_resume_path = "uploads/verify/"; // Directory where resumes will be uploaded

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_id = $_POST['job_id'];
    $applicant_name = $_POST['applicant_name'];
    $email = $_POST['email'];
    $department_id = $_POST['department_id'];

    // Handle file upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        // Sanitize the file name and move it to the target directory
        $resume_name = basename($_FILES['resume']['name']);
        $resume_path = $verify_resume_path . $resume_name;

        // Make sure the upload directory exists
        if (!file_exists($verify_resume_path)) {
            mkdir($verify_resume_path, 0755, true);
        }

        // Move the file to the target directory
        if (!move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path)) {
            $_SESSION['error_message'] = "Error uploading the resume file. Please try again.";
            header("Location: apply.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "No file uploaded or error occurred with the resume file.";
        header("Location: apply.php");
        exit;
    }

    // Check if the email already exists for the same job_id in the email_verifications table
    $sql_check_email = "SELECT * FROM email_verifications WHERE email = ? AND job_id = ?";
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->bind_param("si", $email, $job_id); // Notice job_id is part of the check now
    $stmt_check_email->execute();
    $result = $stmt_check_email->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "This email has already been used for this job application. Please check your inbox or apply for a different job.";
        header("Location: apply.php");
        exit;
    }

    // Generate verification token
    $verification_token = bin2hex(random_bytes(32)); // 64-character token

    // Insert into email_verifications table
    $sql = "INSERT INTO email_verifications (email, applicant_name, resume_path, department_id, job_id, verification_token) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiss", $email, $applicant_name, $resume_path, $department_id, $job_id, $verification_token);

    if ($stmt->execute()) {
        // Send verification email using PHPMailer
        $verification_link = $base_url . "/admin/talent/recruitment/verify.php?token=" . $verification_token;

        // Setup PHPMailer
        $mail = new PHPMailer(true);
        try {
            // SMTP server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'hrofbcp@gmail.com'; // Your Gmail address
            $mail->Password = 'zpdb xwfp ohxt efkj'; // Your Gmail password or App Password if using 2-Step Verification
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('hrofbcp@gmail.com', 'HR Department');
            $mail->addAddress($email, $applicant_name); // Recipient's email

            // Content
            $mail->isHTML(false); // Set to false for plain text email
            $mail->Subject = 'Verify your email address';
            $mail->Body    = "Hello $applicant_name,\n\nPlease click the link to verify your email address:\n$verification_link\n\nThank you!";

            // Send email
            $mail->send();

            // Redirect after success
            $_SESSION['message1'] = "Please check your email to verify your application.";
            header("Location: apply.php"); // Redirect to thank you page
            exit;
        } catch (Exception $e) {
            $_SESSION['error_message1'] = "Error sending verification email. Please try again later. " . $mail->ErrorInfo;
            header("Location: apply.php");
            exit;
        }
    } else {
        $_SESSION['error_message1'] = "Error inserting application data. Please try again later.";
        header("Location: apply.php");
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
