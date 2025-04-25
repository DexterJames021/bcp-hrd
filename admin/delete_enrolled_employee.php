<?php
include 'config.php';

if (isset($_GET['course_id']) && isset($_GET['employee_id'])) {
    $course_id = $_GET['course_id'];
    $employee_id = $_GET['employee_id'];

    $stmt = $conn->prepare("DELETE FROM course_enrollments WHERE course_id = ? AND employee_id = ?");
    $stmt->bind_param("ii", $course_id, $employee_id);

    if ($stmt->execute()) {
        header("Location: enrolled_employees.php?course_id=$course_id");
        exit();
    } else {
        echo "Error removing enrollment: " . $conn->error;
    }
} else {
    echo "Missing parameters.";
}
?>