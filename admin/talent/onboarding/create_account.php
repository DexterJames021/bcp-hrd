<?php
session_start(); // Start the session
require "../../../config/db_talent.php"; // Adjust the path as needed
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../../../vendor/autoload.php";

// Initialize variables for messages
$error_message = '';
$success_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize it
    $applicant_id = mysqli_real_escape_string($conn, $_POST['applicant_id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);
    
    // Hash the password for security (optional for the email, if you want to store it securely in the database)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Check if the username already exists
    $checkQuery = "SELECT * FROM users WHERE username = '$username' OR applicant_id = '$applicant_id'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        // Applicant already has an account
        $_SESSION['error_message'] = "Error: This applicant already has an account or the username already exists.";
        header("Location: ../onboarding.php"); // Redirect back to the onboarding page
        exit();
    } else {
        // Prepare and execute the SQL query to insert the new account
        $query = "INSERT INTO users (applicant_id, username, password, usertype, createdAt) 
                  VALUES ('$applicant_id', '$username', '$hashedPassword', '$usertype', NOW())";

        if (mysqli_query($conn, $query)) {
            // Get the applicant's email (you can adjust this based on your schema)
            $applicantEmailQuery = "SELECT email FROM applicants WHERE id = '$applicant_id'";
            $emailResult = mysqli_query($conn, $applicantEmailQuery);
            $applicantEmail = mysqli_fetch_assoc($emailResult)['email'];
            
            // Send an email to the applicant
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'hrofbcp@gmail.com'; // Replace with your Gmail address
                $mail->Password = 'zpdb xwfp ohxt efkj'; // Replace with your Gmail password or app-specific password if using 2FA
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('hrofbcp@gmail.com', 'HR Department');
                $mail->addAddress($applicantEmail);  // Add the applicant's email as the recipient

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Account Created Successfully';

                // Include the actual username and password in the email body
                $mail->Body    = "
                    Dear Applicant,<br><br>
                    Your account has been created successfully! Below are your account details:<br><br>
                    <strong>Account Details:</strong><br>
                    <strong>Username:</strong> $username<br>
                    <strong>Password:</strong> $password<br><br>
                    You can now log in to your dashboard using these credentials.<br><br>
                    This is the link: <a href='http://localhost/bcp-hrd/auth/index.php'>Login</a><br><br>
                    Best regards,<br>
                    HR Team
                ";

                // Send the email
                $mail->send();
                $_SESSION['success_message'] = "Account created successfully and an email has been sent to the applicant!";
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Error sending email: " . $mail->ErrorInfo;
            }

            // Redirect back to the onboarding page
            header("Location: ../onboarding.php");
            exit();
        } else {
            // Error message for other issues
            $_SESSION['error_message'] = "Error: " . mysqli_error($conn);
            header("Location: ../onboarding.php"); // Redirect back to the onboarding page
            exit();
        }
    }
}
?>
