<?php
// Database connection
$servername = "localhost"; // Your database host
$username = "your_username"; // Your database username
$password = "your_password"; // Your database password
$dbname = "bcp-hrd"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO leave_requests (employee_id, leave_type, start_date, end_date, reason) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $employee_id, $leave_type, $start_date, $end_date, $reason);

// Get data from the form
$employee_id = $_POST['employee_id'];
$leave_type = $_POST['leave_type'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$reason = $_POST['reason'];

// Execute the statement
if ($stmt->execute()) {
    echo "Leave request submitted successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>