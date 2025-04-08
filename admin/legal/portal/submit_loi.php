<?php
include 'db_connection.php'; // update path as needed
session_start();

$user_id = $_SESSION['user_id']; // dapat naka-store na ito after login
$subject = $_POST['subject'];
$message = $_POST['message'];

$query = "INSERT INTO letter_of_intent (user_id, subject, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iss", $user_id, $subject, $message);

if ($stmt->execute()) {
    echo "Letter of Intent submitted successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>