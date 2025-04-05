<?php
session_start();
require "../../../config/db_talent.php"; // Include the database connection

// Check if the training session ID is provided via GET request
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $trainingId = $_GET['id'];

    // Step 1: Check if the training session is assigned to any employees
    // This prevents deletion if the training session is still assigned to employees in training_assignments table.
    $checkAssignmentSQL = "SELECT COUNT(*) AS assignmentCount FROM training_assignments WHERE training_id = ?";
    if ($stmt = $conn->prepare($checkAssignmentSQL)) {
        $stmt->bind_param("i", $trainingId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            // Check if there are any training assignments linked to the session
            if ($row['assignmentCount'] > 0) {
                $_SESSION['error_message'] = "Cannot delete this training session because it is assigned to employees.";
                header("Location: ../succession.php"); // Redirect to the training sessions page
                exit;
            } else {
                // Step 2: If no assignments exist, proceed with deletion
                $deleteTrainingSQL = "DELETE FROM training_sessions  WHERE training_id = ?";
                if ($stmtDelete = $conn->prepare($deleteTrainingSQL)) {
                    $stmtDelete->bind_param("i", $trainingId);

                    // Execute the deletion of the training session
                    if ($stmtDelete->execute()) {
                        $_SESSION['success_message'] = "Training session deleted successfully!";
                        header("Location: ../succession.php"); // Redirect to the page where you want after deletion
                        exit;
                    } else {
                        $_SESSION['error_message'] = "Error deleting training session: " . $conn->error;
                        header("Location: ../succession.php");
                        exit;
                    }
                } else {
                    $_SESSION['error_message'] = "Error preparing statement to delete training session: " . $conn->error;
                    header("Location: ../succession.php");
                    exit;
                }
            }
        } else {
            $_SESSION['error_message'] = "Error checking training session assignment: " . $conn->error;
            header("Location: ../succession.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Error preparing statement to check training session assignment: " . $conn->error;
        header("Location: ../succession.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "No training session ID specified.";
    header("Location: ../succession.php");
    exit;
}
?>
