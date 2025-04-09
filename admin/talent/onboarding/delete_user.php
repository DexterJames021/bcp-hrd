<?php
session_start();
require "../../../config/db_talent.php"; // Include the database connection

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userId = $_GET['id'];

    // Check if the user is linked to an employee record
    $checkEmployeeSQL = "SELECT EmployeeID, FirstName, LastName FROM employees WHERE UserID = ?";
    if ($stmt = $conn->prepare($checkEmployeeSQL)) {
        $stmt->bind_param("i", $userId);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // User is associated with an employee
                $employee = $result->fetch_assoc();
                $fullName = $employee['FirstName'] . ' ' . $employee['LastName'];
                $_SESSION['error_message'] = "Unable to delete user because it is associated with employee: {$fullName} (Employee ID: {$employee['EmployeeID']}). Please remove the related employee record first.";
                header("Location: ../onboarding.php");
                exit;
            }
        } else {
            $_SESSION['error_message'] = "Error checking user associations: " . $conn->error;
            header("Location: ../onboarding.php");
            exit;
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Database error (employee check): " . $conn->error;
        header("Location: ../onboarding.php");
        exit;
    }

    // If no association found, proceed with deletion
    $deleteUserSQL = "DELETE FROM users WHERE id = ?";
    if ($stmt = $conn->prepare($deleteUserSQL)) {
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "User deleted successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to delete user. Please try again later.";
        }

        $stmt->close();
        header("Location: ../onboarding.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Database error (user deletion): " . $conn->error;
        header("Location: ../onboarding.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "No user ID specified.";
    header("Location: ../onboarding.php");
    exit;
}
?>
