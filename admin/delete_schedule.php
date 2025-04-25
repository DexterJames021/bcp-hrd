<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Delete the schedule from the database
    $conn->query("DELETE FROM training_courses WHERE id = $id");

    // Redirect to the training schedule page
    header('Location: view_schedules.php');
}
?>
