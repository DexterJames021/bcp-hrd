<?php
session_start();
require "../../../config/db_talent.php"; // Include the database connection

// Check if the assignment ID is provided via GET request
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $assignmentId = $_GET['id'];

    // Step 1: Check if the assignment is linked to any records in the system (e.g., employee, applicant)
    $checkAssignmentSQL = "SELECT COUNT(*) AS assignmentCount FROM training_assignments WHERE assignment_id = ?";
    if ($stmt = $conn->prepare($checkAssignmentSQL)) {
        $stmt->bind_param("i", $assignmentId);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row['assignmentCount'] > 0) {
                // If the assignment exists, proceed to delete it
                $deleteAssignmentSQL = "DELETE FROM training_assignments WHERE assignment_id = ?";
                if ($stmt = $conn->prepare($deleteAssignmentSQL)) {
                    $stmt->bind_param("i", $assignmentId);

                    // Execute the deletion of the assignment record
                    if ($stmt->execute()) {
                        $_SESSION['success_message'] = "Assignment deleted successfully!";
                        header("Location: ../succession.php"); // Redirect back to the assignments page
                        exit;
                    } else {
                        $_SESSION['error_message'] = "Error deleting assignment: " . $conn->error;
                        header("Location: ../succession.php");
                        exit;
                    }
                } else {
                    $_SESSION['error_message'] = "Error preparing statement to delete assignment: " . $conn->error;
                    header("Location: ../succession.php");
                    exit;
                }
            } else {
                // If the assignment does not exist
                $_SESSION['error_message'] = "Assignment not found.";
                header("Location: ../succession.php"); // Redirect back to the assignments page
                exit;
            }
        } else {
            $_SESSION['error_message'] = "Error checking assignment existence: " . $conn->error;
            header("Location: ../succession.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Error preparing statement to check assignment existence: " . $conn->error;
        header("Location: ../succession.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "No assignment ID specified.";
    header("Location: ../succession.php");
    exit;
}
?>
