<?php
session_start();
include 'db_connection.php';

// Check if the user is admin
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != 'admin') {
    header("Location: ../employee/dashboard.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $complaint_id = $_POST['complaint_id'];
    $status = $_POST['status'];
    $admin_response = mysqli_real_escape_string($conn, $_POST['admin_response']);

    // Update the complaint with the response and status
    $query = "UPDATE complaints SET status = ?, admin_response = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $status, $admin_response, $complaint_id);

    if ($stmt->execute()) {
        header("Location: complaints.php?status=success");
    } else {
        echo "Error updating complaint: " . $conn->error;
    }
}
?>