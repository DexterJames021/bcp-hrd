<?php
require "../../../../config/db_talent.php"; // Adjust path as needed
session_start();

$user_id = $_SESSION['user_id']; // Get logged-in user ID

// Update onboarding step to Step 4
$query = "UPDATE users SET onboarding_step = 4 WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>
