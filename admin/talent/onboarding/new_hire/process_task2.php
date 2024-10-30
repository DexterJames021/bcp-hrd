<?php
session_start(); // Start the session
require "../../../../config/db_talent.php"; // Adjust the path as needed

// Assuming the logged-in user's ID is stored in $_SESSION['user_id']
$user_id = $_SESSION['user_id'];

// Process the submitted data from Task 2
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve form data
    $work_experience = $_POST['work_experience'];
    $skills = $_POST['skills'];
    $job_posting_id = $_POST['job_posting_id'];
    $department_id = $_POST['department_id'];

    // Here, you would typically insert the data into your database.
    // For example:
    // $insert_query = "INSERT INTO task2 (user_id, work_experience, skills, job_posting_id, department_id) VALUES (?, ?, ?, ?, ?)";
    // $stmt = $conn->prepare($insert_query);
    // $stmt->bind_param("issss", $user_id, $work_experience, $skills, $job_posting_id, $department_id);
    // $stmt->execute();
    // $stmt->close();

    // Increment task progress
    $_SESSION['task_progress']++; // Increment the completed tasks count

    // Redirect to the next task or show a success message
    header("Location: task3.php"); // Redirect to Task 3 (you would create task3.php similar to the above)
    exit;
}

// Close database connection
$conn->close();
?>
