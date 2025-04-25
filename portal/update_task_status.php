<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];

    $sql = "UPDATE tasks SET status='$status' WHERE id=$task_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: employee_tasks.php");
        exit();
    } else {
        echo "Error updating task: " . $conn->error;
    }
}
?>