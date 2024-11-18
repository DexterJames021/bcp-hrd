<?php
session_start();
require "../../../config/db_talent.php"; // Include the database connection

// Check if the employee ID is provided via GET request
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $employeeId = $_GET['id'];

    // Step 1: Delete the related records in the training_assignments table
    $deleteTrainingAssignmentsSQL = "DELETE FROM training_assignments WHERE employee_id = ?";
    if ($stmtDeleteTrainingAssignments = $conn->prepare($deleteTrainingAssignmentsSQL)) {
        $stmtDeleteTrainingAssignments->bind_param("i", $employeeId);

        // Execute deletion of the related records
        if ($stmtDeleteTrainingAssignments->execute()) {
            $stmtDeleteTrainingAssignments->close(); // Close the statement after execution
        } else {
            $_SESSION['error_message'] = "Error deleting training assignments: " . $conn->error;
            header("Location: ../onboarding.php");
            exit;
        }
    }

    // Step 2: Now delete the employee record
    $deleteEmployeeSQL = "DELETE FROM employees WHERE EmployeeID = ?";
    if ($stmtDeleteEmployee = $conn->prepare($deleteEmployeeSQL)) {
        $stmtDeleteEmployee->bind_param("i", $employeeId);

        // Execute the deletion of the employee record
        if ($stmtDeleteEmployee->execute()) {
            $_SESSION['success_message'] = "Employee and related records deleted successfully!";
            $stmtDeleteEmployee->close(); // Close the statement after execution
            header("Location: ../onboarding.php"); // Redirect back to the onboarding page or employee list page
            exit;
        } else {
            $_SESSION['error_message'] = "Error deleting employee: " . $conn->error;
            $stmtDeleteEmployee->close(); // Close the statement even on error
            header("Location: ../onboarding.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Error preparing statement to delete employee: " . $conn->error;
        header("Location: ../onboarding.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "No employee ID specified.";
    header("Location: ../onboarding.php");
    exit;
}
?>
