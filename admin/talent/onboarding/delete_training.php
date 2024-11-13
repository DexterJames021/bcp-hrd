<?php
session_start();
require "../../../config/db_talent.php"; // Include the database connection

// Check if the training session ID is provided via GET request
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $trainingId = $_GET['id'];

    // Step 1: Check if the training session is assigned to any employees (optional based on your requirements)
    // You can check for any related data or constraints before deleting, if necessary.
    // If this check is not required, you can skip this step.

    // For example, if there is a "training_assignment" table linking employees to training sessions:
    // $checkAssignmentSQL = "SELECT COUNT(*) AS assignmentCount FROM training_assignment WHERE training_id = ?";
    // if ($stmt = $conn->prepare($checkAssignmentSQL)) {
    //     $stmt->bind_param("i", $trainingId);

    //     if ($stmt->execute()) {
    //         $result = $stmt->get_result();
    //         $row = $result->fetch_assoc();

    //         if ($row['assignmentCount'] > 0) {
    //             $_SESSION['error_message'] = "Cannot delete this training session because it is assigned to employees.";
    //             header("Location: ../training_sessions.php"); // Redirect to the training sessions page
    //             exit;
    //         }
    //     } else {
    //         $_SESSION['error_message'] = "Error checking training session assignment: " . $conn->error;
    //         header("Location: ../training_sessions.php");
    //         exit;
    //     }
    // }

    // Step 2: Delete the training session from the database
    $deleteTrainingSQL = "DELETE FROM training_sessions WHERE training_id = ?";
    if ($stmt = $conn->prepare($deleteTrainingSQL)) {
        $stmt->bind_param("i", $trainingId);

        // Execute the deletion of the training session
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Training session deleted successfully!";
            header("Location: ../onboarding.php"); // Redirect back to the training sessions page
            exit;
        } else {
            $_SESSION['error_message'] = "Error deleting training session: " . $conn->error;
            header("Location: ../onboarding.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Error preparing statement to delete training session: " . $conn->error;
        header("Location: ../onboarding.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "No training session ID specified.";
    header("Location: ../onboarding.php");
    exit;
}
?>
