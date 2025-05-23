<?php
session_start();
require "../../../../config/db_talent.php"; // Adjust the path as needed

// Assuming the logged-in user's ID is stored in $_SESSION['user_id']
$user_id = $_SESSION['user_id'];

// Retrieve applicant_id based on the logged-in user's user_id
$applicant_query = "SELECT applicant_id FROM users WHERE id = ?";
$applicant_stmt = $conn->prepare($applicant_query);
$applicant_stmt->bind_param("i", $user_id);
$applicant_stmt->execute();
$applicant_result = $applicant_stmt->get_result();
$applicant_data = $applicant_result->fetch_assoc();
$applicant_id = $applicant_data['applicant_id'] ?? null;
$applicant_stmt->close();

if (!$applicant_id) {
    echo "Error: No applicant information found for this user.";
    exit;
}

// Retrieve job title and department details using applicant_id
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

$job_title = htmlspecialchars($applicant_info['job_title']);
$department_name = htmlspecialchars($applicant_info['DepartmentName']);
$stmt->close();

// Check if the employee record already exists
$check_employee_query = "SELECT * FROM employees WHERE UserID = ?";
$check_employee_stmt = $conn->prepare($check_employee_query);
$check_employee_stmt->bind_param("i", $user_id);
$check_employee_stmt->execute();
$check_employee_result = $check_employee_stmt->get_result();
$form_submitted = $check_employee_result->num_rows > 0; // Set to true if employee exists

// Prepare to insert employee data if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $hire_date = date('Y-m-d'); // Set hire date to today
    $salary = null; // Set salary to NULL
    $status = 'active'; // Default status

    $insert_query = "INSERT INTO employees (FirstName, LastName, Email, Phone, Address, DOB, HireDate, Salary, Status, UserID) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("sssssssdsi", $first_name, $last_name, $email, $phone, $address, $dob, $hire_date, $salary, $status, $user_id);
    
    if ($insert_stmt->execute()) {
        $form_submitted = true; // Set to true if form is submitted successfully
        echo "Onboarding completed successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
    $insert_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onboarding Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .progress {
            height: 30px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>New Hire Onboarding Form</h2>

    <!-- Progress Bar -->
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: <?php echo $form_submitted ? '100%' : '50%'; ?>;" aria-valuenow="<?php echo $form_submitted ? '100' : '50'; ?>" aria-valuemin="0" aria-valuemax="100">
            <?php echo $form_submitted ? 'Completed' : 'Step 1 of 2'; ?>
        </div>
    </div>

    <!-- Display Job Title and Department Name -->
    <p><strong>Job Title:</strong> <?php echo $job_title; ?></p>
    <p><strong>Department:</strong> <?php echo $department_name; ?></p>

    <!-- Only display the form if there is no existing employee data -->
    <?php if (!$form_submitted): ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" name="dob" required>
            </div>
            <!-- Removed salary input field as it's set to NULL -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    <?php else: ?>
        <p>You have already completed your onboarding.</p>
    <?php endif; ?>

    <!-- Display the Back and Next buttons -->
    <div class="mt-3">
        <form action="previous_step.php" method="GET" style="display:inline;">
            <button type="submit" class="btn btn-secondary">Back</button>
        </form>
        <form action="next_step.php" method="GET" style="display:inline;">
            <button type="submit" class="btn btn-success" <?php echo $form_submitted ? '' : 'disabled'; ?>>Next</button>
        </form>
    </div>
</div>
</body>
</html>
