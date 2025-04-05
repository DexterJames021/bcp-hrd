<?php
session_start();
require "../../config/db_talent.php";
require '../../auth/mysqli_accesscontrol.php';

// Get the logged-in user data
$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

// Get the UserID of the logged-in user
$user_id = $_SESSION['user_id'];  // Assuming the user ID is stored in the session

// Step 1: Query to get the EmployeeID based on UserID
$query_employee_id = "
    SELECT e.EmployeeID 
    FROM employees e 
    JOIN users u ON e.UserID = u.id
    WHERE u.id = ?
";
$stmt_employee = $conn->prepare($query_employee_id);
$stmt_employee->bind_param("i", $user_id);  // Bind the logged-in UserID
$stmt_employee->execute();
$result_employee = $stmt_employee->get_result();
$employee_id = null;
if ($result_employee->num_rows > 0) {
    $row = $result_employee->fetch_assoc();
    $employee_id = $row['EmployeeID'];
    $_SESSION['employee_id'] = $employee_id;  // Set session for employee_id
} else {
    // Handle the case when EmployeeID is not found
    $_SESSION['error_message'] = "Employee record not found!";
    header("Location: available.php"); // Redirect to available training page
    exit;
}

// Get the training_id from the URL
$training_id = $_GET['id'];

// Check if the employee has already applied for the training
$check = "SELECT * FROM training_applications WHERE employee_id = ? AND training_id = ?";
$stmt = $conn->prepare($check);
$stmt->bind_param("ii", $employee_id, $training_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Not yet applied, insert a new application
    $insert = "INSERT INTO training_applications (employee_id, training_id) VALUES (?, ?)";
    $stmt = $conn->prepare($insert);
    $stmt->bind_param("ii", $employee_id, $training_id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Applied successfully for the training.";
    } else {
        $_SESSION['error_message'] = "Error applying for training.";
    }
} else {
    // Already applied for this training
    $_SESSION['error_message'] = "You have already applied for this training.";
}

// Redirect back to the available training page
header("Location: available.php");
exit;
?>
