<?php
session_start();
require "../../../config/db_talent.php"; // Adjust the path as needed

// Fetch departments for the dropdown
$department_query = "SELECT DepartmentID, DepartmentName FROM departments";
$department_result = $conn->query($department_query);

if (!$department_result) {
    die("Database query failed: " . $conn->error); // Error handling if query fails
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check and sanitize input
    $job_title = $_POST['job_title'] ?? '';
    $job_description = $_POST['job_description'] ?? '';
    $requirements = $_POST['requirements'] ?? '';
    $location = $_POST['location'] ?? '';
    $salary_range = $_POST['salary_range'] ?? '';
    $status = $_POST['status'] ?? '';
    $DepartmentID = $_POST['DepartmentID'] ?? null; // Correctly use 'DepartmentID'

    // Debugging: Log the value of DepartmentID
    error_log("DepartmentID: " . var_export($DepartmentID, true)); // This will log to your PHP error log

    // Validate DepartmentID
    if (empty($DepartmentID)) {
        $_SESSION['message'] = "Please select a department.";
        $_SESSION['message_type'] = "warning";
        header("Location: ../recruitment.php");
        exit();
    }

    // Prepare and bind the statement to insert the job posting
    $stmt = $conn->prepare("INSERT INTO job_postings (job_title, job_description, requirements, location, salary_range, status, DepartmentID) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $job_title, $job_description, $requirements, $location, $salary_range, $status, $DepartmentID);

    if ($stmt->execute()) {
        $_SESSION['message'] = "New job posting added successfully!";
        $_SESSION['message_type'] = "success";
        header("Location: ../recruitment.php"); // Redirect after successful insertion
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['message_type'] = "danger";
    }

    $stmt->close();
}
$conn->close();
?>
