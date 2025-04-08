<?php
session_start();
include '../db_connection.php'; // adjust path if needed

// Make sure user is logged in and is an employee
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $submitted_by = $_SESSION['user_id']; // Make sure this session variable is properly set
    $complaint_type = $_POST['complaint_type'];
    $against_employee = $_POST['against_employee'];
    $description = $_POST['description'];

    // Prepare and execute insert statement
    $sql = "INSERT INTO complaints (complaint_type, description, against_employee, submitted_by) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $complaint_type, $description, $against_employee, $submitted_by);

    if ($stmt->execute()) {
        echo "<script>alert('Your complaint has been submitted successfully.');</script>";
    } else {
        echo "<script>alert('Failed to submit complaint.');</script>";
    }
}
    $stmt->close();

?>