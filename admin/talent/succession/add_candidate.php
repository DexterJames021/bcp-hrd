<?php
// add_candidate.php
session_start();
require "../../../config/db_talent.php"; // adjust your path

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
$employee_id     = isset($_POST['employee_id'])     ? (int)   $_POST['employee_id']     : 0;
$target_position = isset($_POST['target_position']) ? trim($_POST['target_position']) : '';
$status          = isset($_POST['status'])          ? trim($_POST['status'])          : '';
$assigned_by     = (int) $_SESSION['user_id'];

// Basic validation
if ($employee_id <= 0
    || $target_position === ''
    || !in_array($status, ['In Development','Ready for Promotion'], true)
) {
    $_SESSION['error_message'] = "Please complete all required fields.";
    header("Location: ../succession.php");
    exit;
}

// Prevent duplicates
$checkSql = "SELECT COUNT(*) AS cnt
             FROM succession_candidates
             WHERE employee_id = ? 
               AND target_position = ?";
if ($chk = $conn->prepare($checkSql)) {
    $chk->bind_param("is", $employee_id, $target_position);
    $chk->execute();
    $cnt = $chk->get_result()->fetch_assoc()['cnt'];
    $chk->close();

    if ($cnt > 0) {
        $_SESSION['error_message'] = "This employee is already a candidate for '{$target_position}'.";
        header("Location: ../succession.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Error checking duplicate: " . $conn->error;
    header("Location: ../succession.php");
    exit;
}

// Insert new candidate
$insertSql = "INSERT INTO succession_candidates
                  (employee_id, target_position, status, assigned_by)
              VALUES (?,?,?,?)";
if ($ins = $conn->prepare($insertSql)) {
    $ins->bind_param("issi", $employee_id, $target_position, $status, $assigned_by);
    if ($ins->execute()) {
        $_SESSION['success_message'] = "Succession candidate added!";
    } else {
        $_SESSION['error_message'] = "Error adding candidate: " . $conn->error;
    }
    $ins->close();
} else {
    $_SESSION['error_message'] = "Error preparing insert: " . $conn->error;
}

// Redirect back
header("Location: ../succession.php");
exit;
