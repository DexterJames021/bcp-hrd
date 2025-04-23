<?php
// update_program.php
session_start();
require "../../../config/db_talent.php"; // adjust your path

// Check if award_id and status are set
if (isset($_GET['award_id']) && isset($_GET['status'])) {
    $award_id = mysqli_real_escape_string($conn, $_GET['award_id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    // Update the status in the database
    $sql = "UPDATE employee_awards SET status = '$status' WHERE id = '$award_id'";

    if (mysqli_query($conn, $sql)) {
        // Redirect back with a success message
        $_SESSION['success_message'] = 'Award status updated successfully!';
        header('Location: ../talent_retention.php');  // Adjust to your page for awards
        exit;
    } else {
        // Redirect back with an error message
        $_SESSION['error_message'] = 'Failed to update award status. Please try again.';
        header('Location: ../talent_retention.php');  // Adjust to your page for awards
        exit;
    }
} else {
    // If the required data is not set, redirect with an error message
    $_SESSION['error_message'] = 'Invalid request. Please try again.';
    header('Location: ../talent_retention.php');  // Adjust to your page for awards
    exit;
}
?>
