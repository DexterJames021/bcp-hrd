<?php
session_start();
require "../../../../config/db_talent.php"; // Adjust the path as needed

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Error: User not logged in.";
    exit;
}

$user_id = $_SESSION['user_id'];
$new_password = $_POST['new_password']; // Get new password from form

// ✅ Hash the password (Security Best Practice)
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// ✅ Update password in database
$update_query = "UPDATE users SET password = ?, onboarding_step = 3 WHERE id = ?";
$update_stmt = $conn->prepare($update_query);
$update_stmt->bind_param("si", $hashed_password, $user_id);

if ($update_stmt->execute()) {
    echo "success"; // ✅ AJAX will detect this response
} else {
    echo "Error: " . $conn->error;
}

$update_stmt->close();
$conn->close();
?>
