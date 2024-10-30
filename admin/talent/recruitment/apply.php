<?php
session_start();
require "../../../config/db_talent.php";

// Check if job_id is provided in the URL
if (isset($_GET['job_id'])) {
    $job_id = intval($_GET['job_id']); // Sanitize the job_id

    // Fetch job details including DepartmentID
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
    // Get form data
    $applicant_name = mysqli_real_escape_string($conn, $_POST['applicant_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $department_id = intval($_POST['department_id']); // Get DepartmentID
    $resume_path = "uploads/resume/";

    // Handle file upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $upload_dir = 'uploads/resume/';
        $resume_path = $upload_dir . basename($_FILES['resume']['name']);
        
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path);
    }

    // Insert application into the database
    $query = "INSERT INTO applicants (job_id, applicant_name, email, resume_path, status, applied_at, DepartmentID) 
              VALUES ($job_id, '$applicant_name', '$email', '$resume_path', 'Pending', NOW(), $department_id)";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Application submitted successfully!";
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($conn);
    }
}
?>

<?php
// Display success message if set
if (isset($_SESSION['message'])) {
    echo "<div class='success-message'>
            <span class='close'>&times;</span>
            " . $_SESSION['message'] . "
          </div>";
    unset($_SESSION['message']); // Clear message after displaying
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for <?php echo htmlspecialchars($job['job_title']); ?></title>
    <link rel="stylesheet" href="style_apply1.css"> <!-- Link to the CSS file -->
    <style>
        /* Style for success message */
        .success-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .close {
            cursor: pointer;
            margin-left: 10px;
            font-weight: bold;
        }
    </style>
    <script>
        // Function to hide the message after a few seconds
        function autoHideMessage() {
            const messageBox = document.querySelector('.success-message');
            if (messageBox) {
                setTimeout(() => {
                    messageBox.style.display = 'none';
                }, 5000); // Hide after 5 seconds
            }

            // Close button functionality
            const closeButton = messageBox.querySelector('.close');
            if (closeButton) {
                closeButton.onclick = function() {
                    messageBox.style.display = 'none';
                };
            }
        }

        // Call the autoHideMessage function on load
        window.onload = autoHideMessage;
    </script>
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

        <!-- Hidden field for DepartmentID -->
        <input type="hidden" name="department_id" value="<?php echo htmlspecialchars($job['DepartmentID']); ?>">

        <button type="submit">Submit Application</button>
    </form>
</body>
</html>
