<?php
session_start();
require "../../../../config/db_talent.php"; // Adjust the path as needed

// Assuming the logged-in user's ID is stored in $_SESSION['user_id']
$user_id = $_SESSION['user_id'];

// Check if the employee record already exists
$check_employee_query = "SELECT * FROM employees WHERE UserID = ?";
$check_employee_stmt = $conn->prepare($check_employee_query);
$check_employee_stmt->bind_param("i", $user_id);
$check_employee_stmt->execute();
$check_employee_result = $check_employee_stmt->get_result();
$check_employee_stmt->close();

// If the employee record exists, show an appropriate message
if ($check_employee_result->num_rows > 0) {
    // Optionally, you can display a message or log some information
    // about the employee record or other actions.
}

// Redirect back to the onboarding form
header("Location: onboarding_form.php");
exit();

$conn->close();
?>
