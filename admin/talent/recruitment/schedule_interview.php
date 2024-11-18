<?php
// Include database connection
require "../../../config/db_talent.php";
// Include PHPMailer (assuming you have it set up already)
require "../../../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the applicant ID and interview details from the form
    $applicant_id = $_POST['applicant_id'];
    $interview_date = $_POST['interview_date'];
    $interview_time = $_POST['interview_time'];
    $job_id = $_POST['job_id']; // Get job_id from POST data

    // Update the applicant's status to 'Interviewed' and set interview details
    $update_query = "UPDATE applicants SET status = 'Interviewed', interview_date = ?, interview_time = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssi", $interview_date, $interview_time, $applicant_id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Retrieve applicant's email
        $email_query = "SELECT email FROM applicants WHERE id = ?";
        $stmt_email = $conn->prepare($email_query);
        $stmt_email->bind_param("i", $applicant_id);
        $stmt_email->execute();
        $result = $stmt_email->get_result();
        $applicant = $result->fetch_assoc();
        
        if ($applicant && isset($applicant['email'])) {
            $applicant_email = $applicant['email'];

            // Format the interview date and time
            $formatted_date = date("F j, Y", strtotime($interview_date));
            $formatted_time = date("g:i A", strtotime($interview_time));

            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'hrofbcp@gmail.com'; // Replace with your Gmail address
                $mail->Password = 'zpdb xwfp ohxt efkj'; // Replace with your Gmail password or app-specific password if using 2FA
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('hrofbcp@gmail.com', 'HR Department'); // Replace with sender details
                $mail->addAddress($applicant_email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Interview Scheduled';
    
                $mail->Body = "Dear Applicant, <br><br>Your interview has been scheduled on <strong>$formatted_date</strong> at <strong>$formatted_time</strong> in Bestlink College of the Philippines. <br><br>Best Regards,<br>HR Department";

                $mail->send();
            } catch (Exception $e) {
                // Handle errors (optional)
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }

    // Redirect back to the manage applications page with job_id
    header("Location: ../recruitment.php?job_id=" . $_GET['job_id'] . "#applicant");

    exit();
} else {
    // If not a POST request, redirect to the manage applications page
    if (isset($_GET['job_id'])) {
        header("Location: ../recruitment.php?job_id=" . $_GET['job_id'] . "#applicant");

    } else {
        // Handle the case where job_id is not set in the URL
        die("Error: job_id parameter missing.");
    }
    exit();
}
