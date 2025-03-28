<<<<<<< HEAD
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
    $department_id = intval($_POST['department_id']);
    $resume_path = "uploads/resume/";

    // ✅ Step 1: Check if applicant already applied for this job
    $check_query = "SELECT * FROM applicants WHERE job_id = ? AND email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("is", $job_id, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Applicant already applied
        $_SESSION['message'] = "You have already applied for this position!";
        header("Location: apply.php?job_id=$job_id"); // Redirect to the same page
        exit;
    }

    // ✅ Step 2: Handle file upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $upload_dir = 'uploads/resume/';
        $resume_path = $upload_dir . basename($_FILES['resume']['name']);
        
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path);
    }

    // ✅ Step 3: Insert application into the database
    $insert_query = "INSERT INTO applicants (job_id, applicant_name, email, resume_path, status, applied_at, DepartmentID) 
                     VALUES (?, ?, ?, ?, 'Pending', NOW(), ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("isssi", $job_id, $applicant_name, $email, $resume_path, $department_id);

    if ($stmt->execute()) {
        header("Location: thank_you.php");
        exit;
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<?php
// Display success or error message
if (isset($_SESSION['message'])) {
    echo "<div id='popupMessage' class='alert alert-danger text-center' role='alert' 
            style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); 
            z-index: 1050; width: 40%; padding: 20px; border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); background:linear-gradient(90deg, #007bff, #00c6ff); color: white;'>
            <strong>Oops!</strong> " . $_SESSION['message'] . "
          </div>";
    unset($_SESSION['message']);
}
?>

<script>
    function closePopup() {
        document.getElementById('popupMessage').style.display = 'none';
    }

    // Auto-hide after 5 seconds
    setTimeout(closePopup, 3000);
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for <?php echo htmlspecialchars($job['job_title']); ?></title>
    <link rel="stylesheet" href="style_apply7.css"> <!-- Link to the CSS file -->
    <link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.min.css">
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
    <!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">

<div class="container">
    <a class="navbar-brand fw-bold" href="#">Employee Management System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="../../../index.php">Apply Now</a></li>
            <li class="nav-item"><a class="btn btn-light text-primary" href="../../../auth/index.php">Login</a></li>
        </ul>
    </div>
</div>
</nav>
<header class="text-white text-center d-flex align-items-center justify-content-center position-relative" style="min-height: 100vh; overflow: hidden;">

    <!-- Move the Back to Job Listings Button inside the job details -->
    

    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Apply for <?php echo htmlspecialchars($job['job_title']); ?></h2>
        <label for="applicant_name">Your Name:</label>
        <input type="text" id="applicant_name" name="applicant_name" required>

        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="resume">Upload Resume:</label>
        <input type="file" id="resume" name="resume" required>

        <!-- Hidden field for DepartmentID -->
        <input type="hidden" name="department_id" value="<?php echo htmlspecialchars($job['DepartmentID']); ?>">

        <button type="submit">Submit Application</button>
    </form>

</header>
</body>
</html>
=======
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



>>>>>>> tech-analytics
