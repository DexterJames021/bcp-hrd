<?php
<<<<<<< HEAD
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
=======
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
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
?>
