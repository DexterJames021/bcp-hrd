<?php
session_start();
require "../../../../config/db_talent.php"; // Adjust the path as needed

$user_id = $_SESSION['user_id']; // Kuhanin ang user ID
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$dob = $_POST['dob'];
$hire_date = $_POST['hire_date']; // Get hire date from hidden input
$salary = $_POST['salary']; // Get salary from hidden input

// Insert into employees table, including HireDate and Salary
$insert_query = "INSERT INTO employees (FirstName, LastName, Email, Phone, Address, DOB, HireDate, Salary, UserID) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$insert_stmt = $conn->prepare($insert_query);
$insert_stmt->bind_param("ssssssssi", $first_name, $last_name, $email, $phone, $address, $dob, $hire_date, $salary, $user_id);

if ($insert_stmt->execute()) {
    // ✅ UPDATE `onboarding_step` to 2 (Step 2 na next)
    $update_query = "UPDATE users SET onboarding_step = 2 WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("i", $user_id);
    $update_stmt->execute();
    
    echo "success";
} else {
    echo "Error: " . $conn->error;
}

$insert_stmt->close();
$update_stmt->close();
$conn->close();
?>
