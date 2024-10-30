<?php
session_start();
require "../../../config/db_talent.php"; // Adjust the path as needed

// Fetch departments for the dropdown
$department_query = "SELECT DepartmentID, DepartmentName FROM departments";
$department_result = $conn->query($department_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Set parameters and validate input
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $requirements = $_POST['requirements'];
    $location = $_POST['location'];
    $salary_range = $_POST['salary_range'];
    $status = $_POST['status'];
    $DepartmentID = $_POST['department_id']; // Updated to use 'department_id' from the form

    // Prepare and bind for inserting the job posting
    $stmt = $conn->prepare("INSERT INTO job_postings (job_title, job_description, requirements, location, salary_range, status, DepartmentID) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $job_title, $job_description, $requirements, $location, $salary_range, $status, $DepartmentID);

    if ($stmt->execute()) {
        $_SESSION['message'] = "New job posting added successfully!";
        $_SESSION['message_type'] = "success"; // Set message type for display
        header("Location: ../recruitment.php"); // Redirect after successful insertion
        exit(); // Ensure the script stops after redirecting
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['message_type'] = "danger"; // Set message type for error display
    }

    $stmt->close();
}
$conn->close();
?>
