<?php
include 'config.php';

$id = $_GET['id'];

// First, delete the dependent records in training_evaluations
$conn->query("DELETE FROM training_evaluations WHERE course_id = $id");

// Then, delete the course from training_courses
$conn->query("DELETE FROM training_courses WHERE id = $id");

header("Location: courses.php");
exit();
?>