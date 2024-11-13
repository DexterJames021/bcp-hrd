<?php
session_start();
require "../../../../config/db_talent.php"; // Adjust the path as needed

// Check if the user is already onboarded
if (!isset($_SESSION['user_id'])) {
    header("Location: step1.php"); // Redirect to step 1 if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the employee record exists
$check_employee_query = "SELECT * FROM employees WHERE UserID = ?";
$check_employee_stmt = $conn->prepare($check_employee_query);
$check_employee_stmt->bind_param("i", $user_id);
$check_employee_stmt->execute();
$check_employee_result = $check_employee_stmt->get_result();

if ($check_employee_result->num_rows === 0) {
    header("Location: step1.php"); // Redirect to step 1 if no employee record exists
    exit();
}

// Check the current agreement status in the database
$check_agreement_query = "SELECT PolicyAgreed FROM employees WHERE UserID = ?";
$check_agreement_stmt = $conn->prepare($check_agreement_query);
$check_agreement_stmt->bind_param("i", $user_id);
$check_agreement_stmt->execute();
$check_agreement_result = $check_agreement_stmt->get_result();
$agreement_submitted = $check_agreement_result->fetch_assoc()['PolicyAgreed']; // Get the status

// Handle agreement submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agree'])) {
    // Update a flag in the database indicating that the policy was agreed to
    $update_query = "UPDATE employees SET PolicyAgreed = 1 WHERE UserID = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("i", $user_id);
    
    if ($update_stmt->execute()) {
        $_SESSION['agreement_submitted'] = true; // Set session variable on successful submission
        $agreement_submitted = true; // Update local variable as well
    } else {
        echo "Error: " . $conn->error;
    }
    $update_stmt->close();
}

// Handle finish action
if (isset($_GET['finish'])) {
    // Update the user type to 'employee'
    $update_user_query = "UPDATE users SET usertype = 'employee' WHERE id = ?";
    $update_user_stmt = $conn->prepare($update_user_query);
    $update_user_stmt->bind_param("i", $user_id);

    if ($update_user_stmt->execute()) {
        // Redirect to the employee portal
        header("Location: ../../../../portal/index.php"); // Adjust the path as needed
        exit();
    } else {
        echo "Error updating user type: " . $conn->error;
    }
    $update_user_stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 3: Policy Agreement</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">

    <!-- Progress Navigation -->
    <nav aria-label="Progress">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="step1.php">Step 1: Personal Information</a></li>
            <li class="breadcrumb-item"><a href="step2.php">Step 2: Upload Documents</a></li>
            <li class="breadcrumb-item active" aria-current="page">Step 3: Policy Agreement</li>
        </ol>
        <div class="progress mb-4">
            <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Step 3 of 3</div>
        </div>
    </nav>

    <!-- Title -->
    <h2>Policy Agreement</h2>

    <?php if (!$agreement_submitted): ?>
        <form method="POST" action="">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="agree" id="agree" required>
                <label class="form-check-label" for="agree">
                    I agree to the <a href="policy_document.pdf" target="_blank">terms and conditions</a>.
                </label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit Agreement</button>
        </form>
    <?php else: ?>
        <div class="alert alert-success mt-3">
            Policy agreement completed successfully!
        </div>
    <?php endif; ?>
    
    <form action="step2.php" method="GET" style="display:inline;">
        <button type="submit" class="btn btn-secondary mt-3">Back</button>
    </form>
    
    <!-- Finish Button Always Visible -->
    <form action="" method="GET" style="display:inline;">
        <button type="submit" name="finish" class="btn btn-success mt-3" <?php echo !$agreement_submitted ? 'disabled' : ''; ?>>Finish</button>
    </form>
</div>
</body>
</html>
