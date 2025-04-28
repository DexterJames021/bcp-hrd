<?php
/*// Include database connection
require "../../../config/db_talent.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the applicant ID and new status from the form
    $applicant_id = $_POST['applicant_id'];
    $status = $_POST['status'];

    // Update the applicant's status in the database
    $update_query = "UPDATE applicants SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $status, $applicant_id);
    $stmt->execute();

    // Redirect back to the manage applications page
    header("Location: manage_application.php?job_id=" . $_GET['job_id']);
    exit();
} else {
    // If not a POST request, redirect to the manage applications page
    header("Location: manage_application.php?job_id=" . $_GET['job_id']);
    exit();
}*/

// Include database connection and PHPMailer
// Include database connection and PHPMailer
require "../../../config/db_talent.php";
require "../../../vendor/autoload.php"; // Adjust path if needed

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the applicant ID and new status from the form
    $applicant_id = $_POST['applicant_id'];
    $status = $_POST['status'];

    // Update the applicant's status in the database
    $update_query = "UPDATE applicants SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $status, $applicant_id);
    $stmt->execute();

    // Retrieve the applicant's email
    $email_query = "SELECT email FROM applicants WHERE id = ?";
    $stmt = $conn->prepare($email_query);
    $stmt->bind_param("i", $applicant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $applicant = $result->fetch_assoc();
    $applicant_email = $applicant['email'];

    // Send email notification based on the status
    $email_status = sendNotificationEmail($applicant_email, $status);
    // Display the email sending status message
    echo $email_status;

    // Redirect back to the manage applications page
    $job_id = isset($_GET['job_id']) ? $_GET['job_id'] : ''; // Siguraduhing may value
header("Location: ../recruitment.php?job_id=" . $job_id . "#applicant");
exit();

} else {
    // If not a POST request, redirect to the manage applications page
    $job_id = isset($_GET['job_id']) ? $_GET['job_id'] : ''; // Siguraduhing may value
header("Location: ../recruitment.php?job_id=" . $job_id . "#applicant");
exit();

}

// Function to send email notification based on the applicant's status
function sendNotificationEmail($to_email, $status) {
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

        $applicant_id = $_POST['applicant_id'];

        // Set sender and recipient to the same email address (your own)
        $mail->setFrom('hrofbcp@gmail.com', 'HR Department');
        $mail->addAddress($to_email); // Send to the applicant's email

        // Email content based on the status
        $mail->isHTML(true);
        $mail->Subject = "Application Status Update: $status";
        
        if ($status == 'Shortlisted') {
            $mail->Body = "Dear Applicant, <br><br>Congratulations! Your interview was successful, and you have been shortlisted for the next step. <br><br>Thank you,<br>HR Department";
        } elseif ($status == 'Interview Failed') {
            $mail->Body = "Dear Applicant, <br><br>Thank you for attending the interview. Unfortunately, we have decided not to move forward with your application at this time. <br><br>Thank you,<br>HR Department";
        } elseif ($status == 'Document Submission') {
            // Generate a link for the applicant's portal, assuming it's based on their ID
                // Retrieve the applicant ID and new status from the form
            
                $portal_link = "http://localhost/bcp-hrd/admin/talent/applicant_portal.php?id=" . $applicant_id;
        
            $mail->Body = "Dear Applicant, <br><br>
            We are pleased to inform you that you have reached the Document Submission stage of the recruitment process.<br><br>
            Please submit the following documents to proceed to the next step in the hiring process:<br>
            <ul>
                <li>Valid Government-issued ID (e.g., Passport, Driver's License, or National ID)</li>
                <li>Updated Resume or Curriculum Vitae (CV)</li>
                <li>Proof of Address (e.g., Utility Bill, Bank Statement, Lease Agreement)</li>
                <li>Recent Passport-sized Photo</li>
                <li>Any Certifications or Licenses relevant to the position</li>
                <li>Academic Transcripts or Diplomas (if applicable)</li>
                <li>NBI Clearance (National Bureau of Investigation Clearance)</li>
            </ul>
            Please ensure that all documents are clear and legible. You can upload the documents via the link provided below or send them directly to our HR department:<br><br>
            <a href='".$portal_link."'>Applicant Portal</a><br><br>
            Thank you for your prompt submission, and we look forward to moving forward with your application.<br><br>
            Should you have any questions or concerns, please do not hesitate to contact us.<br><br>
            Thank you,<br>
            HR Department";
        }elseif ($status == 'Background Check') {
            $mail->Body = "Dear Applicant,<br><br>
            We are pleased to inform you that you have successfully completed the initial phases of our hiring process, including your interview and document submissions.<br><br>
            As the final step, we are now conducting a background check to complete your onboarding requirements.<br><br>
            Kindly wait for further updates. Our HR team will contact you once the background verification process is completed.<br><br>
            Thank you for your continued cooperation!<br><br>
            Best regards,<br>
            HR Department";
        } elseif ($status == 'Hired') {
            $mail->Body = "Dear Applicant, <br><br>
            Congratulations! We are pleased to inform you that you have officially been hired for the position! <br><br>
            Please visit our office **as soon as possible** to physically sign your employment contract. Once signed, we will proceed with setting up your company account and providing you with your login credentials. Our HR team will assist you with the next steps when you arrive.<br><br>
            We are excited to welcome you to the team and look forward to seeing you soon!<br><br>
            Thank you,<br>
            HR Department";
        }
        
         elseif ($status == 'Selected for Interview') {
            $mail->Body = "Dear Applicant, <br><br>Your application status has been updated to: <strong>$status</strong>.<br><br>Wait for the scheduled. Thank you,<br>HR Department";
        }
        
        // Send the email
        $mail->send();
        return "Notification email sent successfully to $to_email.";
    } catch (Exception $e) {
        return "Failed to send notification email: {$mail->ErrorInfo}";
    }
}


?>
