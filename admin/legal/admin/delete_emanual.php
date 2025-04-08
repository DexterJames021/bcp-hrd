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

    // SQL to delete the manual
    $sql = "DELETE FROM employee_manual WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $manual_id);
    if ($stmt->execute()) {
        header("Location: emanual.php"); // Redirect back to the page with manuals
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>