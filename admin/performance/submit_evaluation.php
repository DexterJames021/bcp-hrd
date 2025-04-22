<?php
// submit_evaluation.php

// DB connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bcp-hrd";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get values from POST request
$employeeID = $_POST['employeeID'] ?? $_POST['employeeName'] ?? null;
$evaluationType = $_POST['evaluationType'] ?? 'Students Evaluation';
$evaluatorID = $_POST['evaluatorID'] ?? 47; // Static for now, change if using login
$evaluationDate = date("Y-m-d");
$comments = $_POST['comments'] ?? "Evaluation submitted.";

// Automatically detect number of questions and compute score
$totalScore = 0;
$questionCount = 0;

foreach ($_POST as $key => $value) {
    if (strpos($key, 'question') === 0 && is_numeric($value)) {
        $totalScore += intval($value);
        $questionCount++;
    }
}

// Avoid division by zero
$finalScore = $questionCount > 0 ? round(($totalScore / $questionCount) * 20) : 0;

// Prepare and insert into database
$sql = "INSERT INTO performanceevaluations (EmployeeID, EvaluationDate, EvaluatorID, Score, Comments, EvaluationType)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isisss", $employeeID, $evaluationDate, $evaluatorID, $finalScore, $comments, $evaluationType);

if ($stmt->execute()) {
    echo "<script>alert('Evaluation submitted successfully!'); window.history.back();</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
