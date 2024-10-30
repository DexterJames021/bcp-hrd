<?php
// Include database connection
require "../../../config/db_talent.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the applicant ID and new status from the form
    $applicant_id = $_POST['applicant_id'];
    $status = $_POST['status'];

    // Update the applicant's status in the database
    $update_query = "UPDATE applicants SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $status, $applicant_id);
    $stmt->execute();

    // Redirect back to the manage applications page
    header("Location: manage_application.php?job_id=" . $_GET['job_id']);
    exit();
} else {
    // If not a POST request, redirect to the manage applications page
    header("Location: manage_application.php?job_id=" . $_GET['job_id']);
    exit();
}
?>
