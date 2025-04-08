<?php
session_start();
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != 'admin') {
    header("Location: ../admin/forms/index.php");
    exit();
}

// Include your DB connection
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $manual_id = $_POST['manual_id'];
    $new_title = $_POST['title'];
    // Add any other form data to update the manual if necessary

    // SQL to update manual
    $sql = "UPDATE employee_manual SET title = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_title, $manual_id);
    if ($stmt->execute()) {
        header("Location: emanual.php"); // Redirect back to the page with manuals
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>