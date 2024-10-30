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
$progress = ($_SESSION['task_progress'] / 2) * 100; // Update total tasks to 2

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 2 - Additional Information</title>
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
    <h2>Task 2 - Additional Information</h2>

    <!-- Progress Bar -->
    <div class="progress mb-4">
        <div class="progress-bar" role="progressbar" style="width: <?php echo $progress; ?>%;" 
             aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
             <?php echo $_SESSION['task_progress']; ?> Tasks Completed
        </div>
    </div>

    <!-- Display Job Title and Department Name -->
    <p><strong>Job Title:</strong> <?php echo htmlspecialchars($job_title); ?></p>
    <p><strong>Department:</strong> <?php echo htmlspecialchars($department_name); ?></p>

    <form action="process_task2.php" method="POST">
        <!-- Task 2 Fields -->
        <div class="form-group">
            <label for="work_experience">Work Experience:</label>
            <textarea class="form-control" id="work_experience" name="work_experience" required></textarea>
        </div>
        <div class="form-group">
            <label for="skills">Skills:</label>
            <input type="text" class="form-control" id="skills" name="skills" required>
        </div>

        <!-- Hidden fields for JobID, DepartmentID, and UserID -->
        <input type="hidden" name="job_posting_id" value="<?php echo htmlspecialchars($job_title); ?>">
        <input type="hidden" name="department_id" value="<?php echo htmlspecialchars($department_name); ?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

        <button type="submit" class="btn btn-primary">Submit Task 2</button>
    </form>
</div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
