<?php
// Include database connection
require "../../../config/db_talent.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $jobId = $_POST['job_id'];
    $jobTitle = $_POST['job_title'];
    $jobDescription = $_POST['job_description'];
    $requirements = $_POST['requirements'];
    $location = $_POST['location'];
    $salaryRange = $_POST['salary_range'];
    $status = $_POST['status'];

    // Prepare the update statement
    $sql = "UPDATE job_postings SET job_title = ?, job_description = ?, requirements = ?, location = ?, salary_range = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $jobTitle, $jobDescription, $requirements, $location, $salaryRange, $status, $jobId);

    if ($stmt->execute()) {
        // Redirect to the dashboard or display a success message
        header("Location: ../recruitment.php?success=1");
        exit;
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job Posting</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
<h1>Edit Job Posting</h1>
<form action="" method="POST"> <!-- Change action to an empty string to post to the same page -->
    <label for="job_title">Job Title:</label>
    <input type="text" id="job_title" name="job_title" value="<?php echo htmlspecialchars($row['job_title']); ?>" required><br>

    <label for="job_description">Job Description:</label>
    <textarea id="job_description" name="job_description" required><?php echo htmlspecialchars($row['job_description']); ?></textarea><br>

    <label for="requirements">Job Requirements:</label>
    <textarea id="requirements" name="requirements" required><?php echo htmlspecialchars($row['requirements']); ?></textarea><br>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" required><br>

    <label for="salary_range">Salary Range:</label>
    <input type="text" id="salary_range" name="salary_range" value="<?php echo htmlspecialchars($row['salary_range']); ?>" required><br>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="Open" <?php echo $row['status'] == 'Open' ? 'selected' : ''; ?>>Open</option>
        <option value="Closed" <?php echo $row['status'] == 'Closed' ? 'selected' : ''; ?>>Closed</option>
    </select><br>

    <button type="submit">Update Job Posting</button>
</form>
</div>
</body>
</html>
