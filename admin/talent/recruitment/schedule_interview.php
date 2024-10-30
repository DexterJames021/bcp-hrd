<?php
// Include database connection
require "../../../config/db_talent.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the applicant ID and interview details from the form
    $applicant_id = $_POST['applicant_id'];
    $interview_date = $_POST['interview_date'];
    $interview_time = $_POST['interview_time'];
    $job_id = $_POST['job_id']; // Get job_id from POST data

    // Update the applicant's status to 'Interviewed' and set interview details
    $update_query = "UPDATE applicants SET status = 'Interviewed', interview_date = ?, interview_time = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssi", $interview_date, $interview_time, $applicant_id);
    $stmt->execute();

    // Redirect back to the manage applications page with job_id
    header("Location: manage_application.php?job_id=" . $job_id);
    exit();
} else {
    // If not a POST request, redirect to the manage applications page
    if (isset($_GET['job_id'])) {
        header("Location: manage_application.php?job_id=" . $_GET['job_id']);
    } else {
        // Handle the case where job_id is not set in the URL
        die("Error: job_id parameter missing.");
    }
    exit();
}
