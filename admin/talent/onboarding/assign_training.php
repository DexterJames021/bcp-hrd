<?php
session_start();
require "../../../config/db_talent.php"; // Adjust path to your database connection file as needed

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve input data and sanitize it
    $training_id = isset($_POST['training_id']) ? (int) $_POST['training_id'] : 0;
    $employee_id = isset($_POST['employee_id']) ? (int) $_POST['employee_id'] : 0;
    $completion_date = isset($_POST['completion_date']) && !empty($_POST['completion_date']) ? $_POST['completion_date'] : null;

    // Validate required fields
    if ($training_id === 0 || $employee_id === 0) {
        $_SESSION['error_message'] = "Please provide valid values for all required fields.";
        header("Location: ../onboarding.php"); // Adjust the redirect URL as necessary
        exit;
    }

    // Check if the training is already assigned to the employee
    $checkSql = "SELECT COUNT(*) AS count FROM training_assignments WHERE training_id = ? AND employee_id = ?";
    if ($stmt = $conn->prepare($checkSql)) {
        $stmt->bind_param("ii", $training_id, $employee_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if ($row['count'] > 0) {
                $_SESSION['error_message'] = "This training is already assigned to the selected employee.";
                header("Location: ../onboarding.php"); // Adjust the redirect URL as necessary
                exit;
            }
        } else {
            $_SESSION['error_message'] = "Error checking existing assignment: " . $conn->error;
            header("Location: ../onboarding.php");
            exit;
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Error preparing statement for assignment check: " . $conn->error;
        header("Location: ../onboarding.php");
        exit;
    }

    // Insert new assignment with a default status of 'Not Started'
    $insertSql = "INSERT INTO training_assignments (training_id, employee_id, status, completion_date) VALUES (?, ?, 'Not Started', ?)";
    if ($stmt = $conn->prepare($insertSql)) {
        $stmt->bind_param("iis", $training_id, $employee_id, $completion_date);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Training assigned successfully!";
            header("Location: ../onboarding.php"); // Adjust the redirect URL as necessary
            exit;
        } else {
            $_SESSION['error_message'] = "Error assigning training: " . $conn->error;
            header("Location: ../onboarding.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Error preparing statement to assign training: " . $conn->error;
        header("Location: ../onboarding.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: ../onboarding.php");
    exit;
}
?>
