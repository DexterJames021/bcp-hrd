<?php
session_start();
require "../../../config/db_talent.php"; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['EmployeeID'])) {
    // Ensure that EmployeeID is not empty
    if (empty($_POST['EmployeeID'])) {
        $_SESSION['error_message'] = "Employee ID is missing.";
        header("Location: ../onboarding.php"); // Redirect to the employee list page
        exit;
    }

    // Sanitize and fetch the input data
    $employeeID = $_POST['EmployeeID'];
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone'];
    $status = $_POST['Status'];

    // Prepare the update SQL statement
    $sql = "UPDATE employees 
            SET FirstName = ?, LastName = ?, Email = ?, Phone = ?, Status = ? 
            WHERE EmployeeID = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("sssssi", $firstName, $lastName, $email, $phone, $status, $employeeID);

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Employee updated successfully.";
            header("Location: ../onboarding.php"); // Redirect to the employee list page
            exit;
        } else {
            $_SESSION['error_message'] = "Error updating employee: " . $conn->error;
            header("Location: ../onboarding.php");
            exit;
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Error preparing update statement: " . $conn->error;
        header("Location: ../onboarding.php");
        exit;
    }
}
?>
