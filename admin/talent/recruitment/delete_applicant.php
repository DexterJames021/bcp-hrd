<?php
// Include the database connection
require "../../../config/db_talent.php";
session_start(); // Start the session

// Check if 'id' is passed via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Prepare the DELETE statement to remove the applicant
        $deleteApplicantSql = "DELETE FROM applicants WHERE id = ?";
        $stmt = $conn->prepare($deleteApplicantSql);
        $stmt->bind_param("i", $id); // Bind the ID parameter to prevent SQL injection

        // Execute the query
        if ($stmt->execute()) {
            // Success
            $_SESSION['message'] = "Applicant deleted successfully.";
            $_SESSION['message_type'] = "success"; // Set the success message type
        } else {
            // Generic error message for deletion failure
            $_SESSION['message'] = "Error deleting applicant: " . $stmt->error;
            $_SESSION['message_type'] = "danger"; // Set the error message type
        }
    } catch (mysqli_sql_exception $e) {
        // Handle foreign key constraint or other SQL-related errors
        $_SESSION['message'] = "Error: Cannot delete applicant. There might be associated records or constraints preventing deletion.";
        $_SESSION['message_type'] = "danger"; // Set the error message type
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to the applicants page after the action
    header("Location: ../recruitment.php"); // Adjust this to your actual applicants page if different
    exit;

} else {
    // Handle invalid request
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['message_type'] = "danger"; // Set the error message type
    header("Location: ../recruitment.php"); // Redirect on invalid request
    exit;
}
?>
