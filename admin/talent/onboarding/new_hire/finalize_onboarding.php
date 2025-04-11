<?php
session_start();
require "../../../../config/db_talent.php"; // Adjust the path as needed

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: step1.php"); // Redirect if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the user's current usertype
$get_user_query = "SELECT usertype FROM users WHERE id = ?";
$get_user_stmt = $conn->prepare($get_user_query);
$get_user_stmt->bind_param("i", $user_id);
$get_user_stmt->execute();
$get_user_stmt->bind_result($current_usertype);
$get_user_stmt->fetch();
$get_user_stmt->close();

// Check if the form was submitted and if the usertype is 'New Hire'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agree'])) {
    // If usertype is 'New Hire', proceed with updating to 'employee'
    if ($current_usertype === 'New Hire') {
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
                echo "employee"; // Return 'employee' for successful onboarding
            } else {
                echo "Error updating user type.";
            }
        } else {
            echo "Error updating policy agreement.";
        }
    } else {
        // If the user is not a 'New Hire', skip the usertype update
        echo $current_usertype; // Return current usertype
    }
}
?>
