<?php
// Include the database connection
require "../../../config/db_talent.php";
session_start(); // Start the session

// Check if 'id' is passed via GET
if (isset($_GET['DepartmentID'])) {
    $id = $_GET['DepartmentID'];

    try {
        // Prepare the DELETE statement to remove the department
        $deleteDepartmentSql = "DELETE FROM departments WHERE DepartmentID = ?";
        $stmt = $conn->prepare($deleteDepartmentSql);
        $stmt->bind_param("i", $id); // Bind the ID parameter

        // Execute the query
        if ($stmt->execute()) {
            // Success
            $_SESSION['message'] = "Department deleted successfully.";
            $_SESSION['message_type'] = "success"; // Set the success message type
        } else {
            // Generic error message for deletion failure
            $_SESSION['message'] = "Error deleting department: " . $stmt->error;
            $_SESSION['message_type'] = "danger"; // Set the error message type
        }
    } catch (mysqli_sql_exception $e) {
        // Handle foreign key constraint error
        $_SESSION['message'] = "Error: Cannot delete department. It is associated with job postings or other records.";
        $_SESSION['message_type'] = "danger"; // Set the error message type
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to the departments page after the action
    header("Location: ../recruitment.php"); // Adjust this to your actual departments page if different
    exit;

} else {
    // Handle invalid request
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['message_type'] = "danger"; // Set the error message type
    header("Location: ../recruitment.php"); // Redirect on invalid request
    exit;
}
?>
