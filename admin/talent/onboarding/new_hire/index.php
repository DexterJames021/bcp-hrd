<?php
session_start(); // Start the session
require "../../../../config/db_talent.php"; // Adjust the path as needed

// Initialize task progress if not set
if (!isset($_SESSION['task_progress'])) {
    $_SESSION['task_progress'] = 0; // Start with 0 completed tasks
}

// Assuming the logged-in user's ID is stored in $_SESSION['user_id']
$user_id = $_SESSION['user_id'];

// Step 1: Retrieve applicant_id based on the logged-in user's user_id
$applicant_query = "SELECT applicant_id FROM users WHERE id = ?";
$applicant_stmt = $conn->prepare($applicant_query);
$applicant_stmt->bind_param("i", $user_id);
$applicant_stmt->execute();
$applicant_result = $applicant_stmt->get_result();
$applicant_data = $applicant_result->fetch_assoc();
$applicant_id = $applicant_data['applicant_id'];
$applicant_stmt->close();

// Check if we have a valid applicant_id
if ($applicant_id) {
    // Step 2: Retrieve job and department details using applicant_id
    $query = "
        SELECT 
            jp.job_title, 
            d.DepartmentName 
        FROM 
            applicants a
        INNER JOIN 
            job_postings jp ON a.job_id = jp.id
        INNER JOIN 
            departments d ON a.DepartmentID = d.DepartmentID
        WHERE 
            a.id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $applicant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $applicant_info = $result->fetch_assoc();

    // Fetch job title and department name
    $job_title = $applicant_info['job_title'];
    $department_name = $applicant_info['DepartmentName'];

    $stmt->close();
} else {
    echo "Error: No applicant information found for this user.";
    exit;
}

// Calculate progress percentage
$progress = ($_SESSION['task_progress'] / 3) * 100; // Assuming 3 tasks

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Hire Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles for the progress bar */
        .progress {
            height: 30px;
        }
        .progress-bar {
            font-size: 14px;
            line-height: 30px; /* Center text vertically */
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>New Hire Information Form</h2>

    <!-- Progress Bar -->
    <div class="progress mb-4">
        <div class="progress-bar" role="progressbar" style="width: <?php echo $progress; ?>%;" 
             aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
             Task <?php echo $_SESSION['task_progress']; ?> Completed
        </div>
    </div>

    <!-- Display Job Title and Department Name -->
    <p><strong>Job Title:</strong> <?php echo htmlspecialchars($job_title); ?></p>
    <p><strong>Department:</strong> <?php echo htmlspecialchars($department_name); ?></p>

    <form action="process_new_hire.php" method="POST">
        <!-- New Hire Information Fields -->
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" class="form-control" id="dob" name="dob" required>
        </div>

        <!-- Hidden fields for JobID, DepartmentID, and UserID -->
        <input type="hidden" name="job_posting_id" value="<?php echo htmlspecialchars($job_title); ?>">
        <input type="hidden" name="department_id" value="<?php echo htmlspecialchars($department_name); ?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

        <div class="form-group">
            <label for="hire_date">Hire Date:</label>
            <input type="date" class="form-control" id="hire_date" name="hire_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
