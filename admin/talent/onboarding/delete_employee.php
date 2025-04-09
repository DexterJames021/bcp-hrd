<?php
// Include the database connection
require "../../../config/db_talent.php";
session_start(); // Start the session

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check user type
    $usertype = $_SESSION['usertype']; // Assuming user type is stored in session

    // SUPERADMIN OVERRIDE: Disable foreign key checks temporarily for complete deletion
    if ($usertype == 'superadmin') {
        $conn->query("SET FOREIGN_KEY_CHECKS = 0");

        // Delete employee even if there are foreign key constraints
        $deleteEmployeeSql = "DELETE FROM employees WHERE EmployeeID = ?";
        $deleteStmt = $conn->prepare($deleteEmployeeSql);
        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            $_SESSION['message'] = "Employee and all related records have been permanently deleted.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error deleting employee: " . $conn->error;
            $_SESSION['message_type'] = "danger";
        }

        // Re-enable foreign key checks
        $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    }

    // ADMIN: Soft delete by marking status as 'Inactive'
    if ($usertype == 'admin') {
        // Mark the employee status as 'Inactive'
        $updateStatusSql = "UPDATE employees SET Status = 'Inactive' WHERE EmployeeID = ?";
        $updateStmt = $conn->prepare($updateStatusSql);
        $updateStmt->bind_param("i", $id);

        if ($updateStmt->execute()) {
            $_SESSION['message'] = "Employee marked as inactive successfully.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error marking employee as inactive: " . $conn->error;
            $_SESSION['message_type'] = "danger";
        }
    }

    // Redirect back to the employee list page after handling
    header("Location: ../employees.php");
    exit;
} else {
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../employees.php");
    exit;
}

$conn->close();
?>
