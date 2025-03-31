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

// Insert into employees table
$insert_query = "INSERT INTO employees (FirstName, LastName, Email, Phone, Address, DOB, UserID) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
$insert_stmt = $conn->prepare($insert_query);
$insert_stmt->bind_param("ssssssi", $first_name, $last_name, $email, $phone, $address, $dob, $user_id);

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
