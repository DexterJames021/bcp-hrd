<?php
// submit_evaluation.php

require('C:/xampp/htdocs/bcp-hrd/config/db_talent.php');

// Assuming the form data has been POSTed and validated
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employeeID = $_POST['employeeName'];
    $evaluationType = $_POST['evaluationType'];

    // Insert the evaluation scores and comments
    for ($i = 1; $i <= 10; $i++) {
        $score = $_POST["question$i"];
        $comment = $_POST["comment$i"]; // You should have a corresponding input for comments
        $stmt = $conn->prepare("INSERT INTO performanceevaluations (EmployeeID, EvaluationType, Score, Comments) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $employeeID, $evaluationType, $score, $comment);
        $stmt->execute();
    }

    // Redirect back to eval.php after submission
    header("Location: eval.php?type=Teaching"); // or use the selected type
    exit;
}

$conn->close();
?>
