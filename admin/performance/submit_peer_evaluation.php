<?php
// submit_peer_evaluation.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bcp-hrd";

// Create DB connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get evaluated peer ID from form
$evaluatedEmployeeID = $_POST['employeeID'];

// For simplicity, hardcoding evaluator ID (you can fetch from session if login is used)
$evaluatorID = 1;

// Set questions manually (should match those in the form)
$questions = [
    "Contributes actively to team discussions." => "rating",
    "Respects and values others’ opinions." => "rating",
    "Supports teammates and helps when needed." => "rating",
    "Works effectively with others to solve problems." => "rating",
    "Communicates clearly and professionally." => "rating",
    "Keeps the team informed of progress." => "rating",
    "Listens actively to feedback." => "rating",
    "Completes assigned tasks on time." => "rating",
    "Is reliable in meeting deadlines." => "rating",
    "Takes responsibility for their contributions." => "rating",
    "Demonstrates leadership and initiative." => "rating",
    "Motivates and encourages team members." => "rating",
    "Accepts constructive criticism positively." => "rating",
    "Shows noticeable improvement over time." => "rating",
    "What are this peer's greatest strengths?" => "text",
    "What areas could this peer improve?" => "text"
];

// Loop through form responses and insert into DB
$index = 1;
foreach ($questions as $questionText => $responseType) {
    $responseField = 'question' . $index;
    if (isset($_POST[$responseField])) {
        $response = $conn->real_escape_string($_POST[$responseField]);

        $stmt = $conn->prepare("INSERT INTO peer_evaluations (evaluator_id, evaluated_employee_id, question_number, question_text, response, response_type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisss", $evaluatorID, $evaluatedEmployeeID, $index, $questionText, $response, $responseType);
        $stmt->execute();
        $stmt->close();
    }
    $index++;
}

// Close connection
$conn->close();

// Redirect or show confirmation
echo "<script>alert('Evaluation submitted successfully!'); window.location.href='peer_eval.php';</script>";
?>
