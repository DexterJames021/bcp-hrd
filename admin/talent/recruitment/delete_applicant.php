<?php
// Include the database connection
require "../../../config/db_talent.php";
session_start(); // Start the session

// Check if 'applicant_id' is passed via GET
if (isset($_GET['applicant_id'])) {
    $applicant_id = $_GET['applicant_id']; // Get the applicant_id from GET data

    try {
        // Prepare the DELETE statement to remove the applicant
        $deleteApplicantSql = "DELETE FROM applicants WHERE id = ?";
        $stmt = $conn->prepare($deleteApplicantSql);
        $stmt->bind_param("i", $applicant_id); // Bind the applicant ID parameter

        // Execute the query
        if ($stmt->execute()) {
            // Success message for deletion
            $_SESSION['message'] = "Applicant deleted successfully.";
            $_SESSION['message_type'] = "success"; // Set the success message type
        } else {
            // Error message if deletion fails
            $_SESSION['message'] = "Error deleting applicant: " . $stmt->error;
            $_SESSION['message_type'] = "danger"; // Set the error message type
        }
    } catch (mysqli_sql_exception $e) {
        // Handle any errors that occur during the deletion process
        $_SESSION['message'] = "Error: Could not delete applicant.";
        $_SESSION['message_type'] = "danger"; // Set the error message type
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();

    // Redirect back to the applicants page after the action
    header("Location: ../recruitment.php"); // Adjust this to your actual applicants page
    exit;
} else {
    // Handle invalid request (e.g., no applicant_id passed)
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['message_type'] = "danger"; // Set the error message type
    header("Location: ../recruitment.php"); // Redirect to applicants page
    exit;
}
?>
