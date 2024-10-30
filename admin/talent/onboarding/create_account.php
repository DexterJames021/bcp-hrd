<?php
session_start(); // Start the session
require "../../../config/db_talent.php"; // Adjust the path as needed

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
    
    // Hash the password for security
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
            // Success message and redirection
            $_SESSION['success_message'] = "Account created successfully!";
            header("Location: ../onboarding.php"); // Redirect back to the onboarding page
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
