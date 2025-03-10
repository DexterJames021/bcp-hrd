<?php
// Include database connection
require "../../../config/db_talent.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO job_postings (job_title, job_description, requirements, location, salary_range, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $job_title, $job_description, $requirements, $location, $salary_range, $status);

    // Set parameters and execute
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $requirements = $_POST['requirements'];
    $location = $_POST['location'];
    $salary_range = $_POST['salary_range'];
    $status = $_POST['status'];

    if ($stmt->execute()) {
        echo "New job posting added successfully!";
        header("Location: ../recruitment.php"); // Redirect to view_jobs page after successful insertion// Redirect or perform another action after successful insertion
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();


// Include database connection
/*include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $requirements = $_POST['requirements'];
    $location = $_POST['location'];
    $salary_range = $_POST['salary_range'];
    $status = $_POST['status']; // Get the status from the form

    // Insert job posting into the database
    $sql = "INSERT INTO job_postings (job_title, job_description, requirements, location, salary_range, STATUS) 
            VALUES ('$job_title', '$job_description', '$requirements', '$location', '$salary_range', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Job posting created successfully.";
        header("Location: index.php"); // Redirect to view_jobs page after successful insertion
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Job Posting</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
<h1>Add Job Posting</h1>
<form action="" method="POST">
    <label for="job_title">Job Title:</label>
    <input type="text" id="job_title" name="job_title" required><br>

    <label for="job_description">Job Description:</label>
    <textarea id="job_description" name="job_description" required></textarea><br>

    <label for="requirements">Job Requirements:</label>
    <textarea id="requirements" name="requirements" required></textarea><br>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" required><br>

    <label for="salary_range">Salary Range:</label>
    <input type="text" id="salary_range" name="salary_range" placeholder="e.g. ₱30,000 - ₱50,000" required><br>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="Open">Open</option>
        <option value="Closed">Closed</option>
    </select><br>

    <button type="submit">Create Job Posting</button>
</form>
</div>
</body>
</html>
