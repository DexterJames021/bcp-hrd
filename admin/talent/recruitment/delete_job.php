<?php 
// Include database connection
require "../../../config/db_talent.php";
session_start(); // Start the session

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if there are any applicants for this job
    $checkApplicantsSql = "SELECT COUNT(*) as total FROM applicants WHERE job_id = ?";
    $stmt = $conn->prepare($checkApplicantsSql);
    $stmt->bind_param("i", $id); // Binding the parameter to prevent SQL injection
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['total'] > 0) {
        // Applicants exist, do not delete the job posting
        $_SESSION['message'] = "Error: Cannot delete job posting. There are applicants associated with this job.";
        $_SESSION['message_type'] = "danger"; // Error message type
    } else {
        // No applicants, safe to delete the job posting
        $deleteJobSql = "DELETE FROM job_postings WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteJobSql);
        $deleteStmt->bind_param("i", $id); // Binding the parameter

        if ($deleteStmt->execute()) {
            $_SESSION['message'] = "Job posting deleted successfully.";
            $_SESSION['message_type'] = "success"; // Success message type
        } else {
            $_SESSION['message'] = "Error deleting record: " . $conn->error;
            $_SESSION['message_type'] = "danger"; // Error message type
        }
    }

    // Redirect back to the jobs page after handling
    header("Location: ../recruitment.php");
    exit;
} else {
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['message_type'] = "danger"; // Error message type
    header("Location: ../recruitment.php"); // Redirect on invalid request
    exit;
}

$conn->close();
?>
