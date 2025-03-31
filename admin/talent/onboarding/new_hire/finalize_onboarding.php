<?php
session_start();
require "../../../../config/db_talent.php"; // Adjust the path as needed

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: step1.php"); // Redirect if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agree'])) {
    // Update the PolicyAgreed flag to 1
    $update_query = "UPDATE employees SET PolicyAgreed = 1 WHERE UserID = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("i", $user_id);

    if ($update_stmt->execute()) {
        // Update usertype to 'employee' in the users table
        $update_user_query = "UPDATE users SET usertype = 'employee' WHERE id = ?";
        $update_user_stmt = $conn->prepare($update_user_query);
        $update_user_stmt->bind_param("i", $user_id);

        if ($update_user_stmt->execute()) {
            echo "success"; // Successfully updated both fields
        } else {
            echo "Error updating user type.";
        }
    } else {
        echo "Error updating policy agreement.";
    }
}
?>
