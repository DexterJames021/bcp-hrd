<?php
require "../../../config/db_talent.php";

// Check if job_id is provided in the URL
if (isset($_GET['job_id'])) {
    $job_id = intval($_GET['job_id']); // Sanitize the job_id

    // Fetch job details
    $query = "SELECT * FROM job_postings WHERE id = $job_id AND STATUS = 'Open'";
    $result = mysqli_query($conn, $query);

    // Check if the job exists
    if (mysqli_num_rows($result) > 0) {
        $job = mysqli_fetch_assoc($result);
    } else {
        echo "<p>Job not found or not available.</p>";
        exit;
    }
} else {
    echo "<p>No job specified.</p>";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize it
    $applicant_name = mysqli_real_escape_string($conn, $_POST['applicant_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $resume_path = "uploads/resume/"; // Path for the uploaded resume

    // Handle file upload for resume
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $upload_dir = 'uploads/resume/'; // Directory to save resumes
        $resume_path = $upload_dir . basename($_FILES['resume']['name']);
        
        // Move the uploaded file to the specified directory
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Create upload directory if it doesn't exist
        }

        move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path);
    }

    // Insert application into the database
    $query = "INSERT INTO applicants (job_id, applicant_name, email, resume_path, status, applied_at) 
              VALUES ($job_id, '$applicant_name', '$email', '$resume_path', 'Pending', NOW())";

    if (mysqli_query($conn, $query)) {
        echo "<p>Application submitted successfully!</p>";
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for <?php echo htmlspecialchars($job['job_title']); ?></title>
    <link rel="stylesheet" href="style_apply1.css"> <!-- Link to the CSS file -->
</head>
<body>
    <h1>Apply for <?php echo htmlspecialchars($job['job_title']); ?></h1>

    <div class="job-details">
        <h2>Job Details</h2>
        <p><strong>Job Title:</strong> <?php echo htmlspecialchars($job['job_title']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($job['job_description']); ?></p>
        <p><strong>Requirements:</strong> <?php echo htmlspecialchars($job['requirements']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
        <p><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary_range']); ?></p>

        <!-- Move the Back to Job Listings Button inside the job details -->
        <a href="job_listings.php" class="btn-back">← Back to Job Listings</a>
    </div>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="applicant_name">Your Name:</label>
        <input type="text" id="applicant_name" name="applicant_name" required><br>

        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="resume">Upload Resume:</label>
        <input type="file" id="resume" name="resume" required><br>

        <button type="submit">Submit Application</button>
    </form>
</body>
</html>



