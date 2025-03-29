<?php
session_start();
require "../../../../config/db_talent.php"; // Adjust the path as needed

// Assuming the logged-in user's ID is stored in $_SESSION['user_id']
$user_id = $_SESSION['user_id'];

// Check if the employee record exists to ensure onboarding form was submitted
$check_employee_query = "SELECT * FROM employees WHERE UserID = ?";
$check_employee_stmt = $conn->prepare($check_employee_query);
$check_employee_stmt->bind_param("i", $user_id);
$check_employee_stmt->execute();
$check_employee_result = $check_employee_stmt->get_result();
$check_employee_stmt->close();

// Redirect to onboarding form if the employee record does not exist
if ($check_employee_result->num_rows === 0) {
    header("Location: onboarding_form.php");
    exit();
}

// Proceed to the document upload page
header("Location: upload_document.php");
exit();

$conn->close();
?>
