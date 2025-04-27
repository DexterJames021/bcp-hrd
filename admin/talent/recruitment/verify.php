<?php
session_start();
require "../../../config/db_talent.php"; // or your db config

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Find the record
    $sql = "SELECT * FROM email_verifications WHERE verification_token = ? AND is_verified = 0 LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Insert into applicants table
        $insert = "INSERT INTO applicants (job_id, applicant_name, email, resume_path, status, applied_at, DepartmentID) 
                   VALUES (?, ?, ?, ?, 'Pending', NOW(), ?)";
        $stmt2 = $conn->prepare($insert);
        $stmt2->bind_param("isssi", $row['job_id'], $row['applicant_name'], $row['email'], $row['resume_path'], $row['department_id']);
        
        if ($stmt2->execute()) {
            // Update email_verifications as verified
            $update = "UPDATE email_verifications SET is_verified = 1 WHERE id = ?";
            $stmt3 = $conn->prepare($update);
            $stmt3->bind_param("i", $row['id']);
            $stmt3->execute();

            // HTML response
            echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - Success</title>
    <link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="ty12.css"> <!-- Optional custom styles -->
</head>
<body>
    <div class="container text-center mt-5">
        <h2>Email Verified Successfully!</h2>
        <p>Your application has been submitted. We will review your application and get back to you shortly.</p>
        <a href="../../../index.php" class="btn btn-primary">Back to Homepage</a>
    </div>
</body>
</html>';
        } else {
            echo "Failed to insert application.";
        }
    } else {
        echo "Invalid or expired verification link.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No token provided.";
}
?>
