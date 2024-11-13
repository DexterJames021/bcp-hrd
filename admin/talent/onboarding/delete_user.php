<?php
session_start();
require "../../../config/db_talent.php"; // Include the database connection

// Check if the user ID is provided via GET request
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userId = $_GET['id'];

    // Step 1: Check if the user is linked to any employee
    $checkEmployeeSQL = "SELECT COUNT(*) AS employeeCount FROM employees WHERE UserID = ?";
    if ($stmt = $conn->prepare($checkEmployeeSQL)) {
        $stmt->bind_param("i", $userId);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row['employeeCount'] > 0) {
                // If the user is associated with an employee, show error message
                $_SESSION['error_message'] = "Cannot delete this user because they are associated with an employee.";
                header("Location: ../onboarding.php"); // Redirect back to the onboarding page
                exit;
            } else {
                // If the user is not associated with any employee, proceed to delete the user
                $deleteUserSQL = "DELETE FROM users WHERE id = ?";
                if ($stmt = $conn->prepare($deleteUserSQL)) {
                    $stmt->bind_param("i", $userId);

                    // Execute the deletion of the user record
                    if ($stmt->execute()) {
                        $_SESSION['success_message'] = "User deleted successfully!";
                        header("Location: ../onboarding.php"); // Redirect back to the onboarding page
                        exit;
                    } else {
                        $_SESSION['error_message'] = "Error deleting user: " . $conn->error;
                        header("Location: ../onboarding.php");
                        exit;
                    }
                } else {
                    $_SESSION['error_message'] = "Error preparing statement to delete user: " . $conn->error;
                    header("Location: ../onboarding.php");
                    exit;
                }
            }
        } else {
            $_SESSION['error_message'] = "Error checking employee association: " . $conn->error;
            header("Location: ../onboarding.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Error preparing statement to check employee association: " . $conn->error;
        header("Location: ../onboarding.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "No user ID specified.";
    header("Location: ../onboarding.php");
    exit;
}
?>
