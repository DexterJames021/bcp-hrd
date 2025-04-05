<?php

require "../../../config/db_talent.php"; // Include the database connection

if (isset($_GET['id'])) {
    $assignment_id = $_GET['id'];

    // Update the status to 'Completed'
    $sql = "UPDATE training_assignments SET status = 'Completed', completion_date = NOW() WHERE assignment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $assignment_id);

    if ($stmt->execute()) {
        // Redirect back to the page with a success message
        $_SESSION['success_message'] = "Assignment marked as completed.";
        header("Location: ../succession.php"); // Redirect to the appropriate page
        exit();
    } else {
        // Handle error
        $_SESSION['error_message'] = "There was an error updating the assignment.";
        header("Location: ../succession.php"); // Redirect back
        exit();
    }
} else {
    // If no ID is provided
    $_SESSION['error_message'] = "Invalid assignment ID.";
    header("Location: ../succession.php"); // Redirect back
    exit();
}
?>
