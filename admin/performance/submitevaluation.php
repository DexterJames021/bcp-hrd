<?php
// Get the submitted values
$employeeID = $_POST['employeeName'];  // The selected employee ID
$question1 = $_POST['question1'];       // Rating for question 1
$question2 = $_POST['question2'];       // Rating for question 2
// ... process other questions

// Store the evaluation results in the database
$sql = "INSERT INTO performanceevaluations (EmployeeID, EvaluatorID, Question1, Question2, Comments)
        VALUES (?, ?, ?, ?, ?)";

// Assume evaluator ID is fetched dynamically from the session or passed from another form
$evaluatorID = 1;  // Example evaluator ID

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiii", $employeeID, $evaluatorID, $question1, $question2, $comments);
$stmt->execute();
?>
