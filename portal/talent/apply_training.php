<?php
require "../../config/db_talent.php";
require '../../auth/mysqli_accesscontrol.php';

// Check if user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the training ID from the URL and sanitize input
$training_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'];

// Check if the training ID is valid
if ($training_id <= 0) {
    echo "Invalid training session.";
    exit();
}

// Prepare and execute the query using a prepared statement to prevent SQL injection
$query = "INSERT INTO training_applications (user_id, training_id, applied_at) VALUES (?, ?, NOW())";

$stmt = mysqli_prepare($conn, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $training_id); // Bind the user_id and training_id as integers
    $execute = mysqli_stmt_execute($stmt);

    if ($execute) {
        echo "You have successfully applied for the training. Please wait for a response regarding your application status.";

    } else {
        echo "Error applying for the training: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Failed to prepare the query.";
}

mysqli_close($conn); // Close the database connection
?>
