<?php
// update_candidate.php
session_start();
require "../../../config/db_talent.php"; // adjust mo path if needed

// Only handle POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: ../succession.php");
    exit;
}

// Validate admin session
if (empty($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in first.";
    header("Location: login.php");
    exit;
}

// Sanitize inputs
$candidate_id    = isset($_POST['candidate_id'])    ? (int) $_POST['candidate_id']    : 0;
$target_position = isset($_POST['target_position']) ? trim($_POST['target_position']) : '';
$status          = isset($_POST['status'])          ? trim($_POST['status'])          : '';

// Basic validation
if ($candidate_id <= 0
    || $target_position === ''
    || !in_array($status, ['In Development','Ready for Promotion','Not Ready'], true)
) {
    $_SESSION['error_message'] = "Please complete all required fields correctly.";
    header("Location: ../succession.php");
    exit;
}

// Update candidate
$updateSql = "UPDATE succession_candidates 
              SET target_position = ?, status = ?
              WHERE candidate_id = ?";
if ($upd = $conn->prepare($updateSql)) {
    $upd->bind_param("ssi", $target_position, $status, $candidate_id);
    
    if ($upd->execute()) {
        $_SESSION['success_message'] = "Succession candidate updated!";
    } else {
        $_SESSION['error_message'] = "Error updating candidate: " . $conn->error;
    }
    $upd->close();
} else {
    $_SESSION['error_message'] = "Error preparing update: " . $conn->error;
}

// Redirect back
header("Location: ../succession.php");
exit;
?>
