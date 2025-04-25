<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM tasks WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_tasks.php");
        exit();
    } else {
        echo "Error deleting task: " . $conn->error;
    }
} else {
    echo "Invalid access.";
}
?>