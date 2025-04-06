<?php
require "../../../config/db_talent.php"; // Include the database connection

if (isset($_GET['id']) && isset($_GET['grade'])) {
    $assignment_id = $_GET['id'];
    $grade = $_GET['grade']; // Capture the grade

    // Insert the grade into the training_grades table
    $sql = "INSERT INTO training_grades (assignment_id, grade) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('id', $assignment_id, $grade); // Insert both assignment_id and grade

    if ($stmt->execute()) {
        // Update the status to 'Completed' and set the completion date in the training_assignments table
        $sql_update = "UPDATE training_assignments SET status = 'Completed', completion_date = NOW() WHERE assignment_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param('i', $assignment_id); // Bind assignment_id for update

        if ($stmt_update->execute()) {
            // Redirect back to the page with a success message
            $_SESSION['success_message'] = "Assignment marked as completed with grade: $grade%";
            header("Location: ../succession.php"); // Redirect to the appropriate page
            exit();
        } else {
            // Handle error in updating assignment
            $_SESSION['error_message'] = "There was an error updating the assignment status.";
            header("Location: ../succession.php"); // Redirect back
            exit();
        }
    } else {
        // Handle error in inserting grade
        $_SESSION['error_message'] = "There was an error inserting the grade.";
        header("Location: ../succession.php"); // Redirect back
        exit();
    }
} else {
    // If no ID or grade is provided
    $_SESSION['error_message'] = "Invalid assignment ID or missing grade.";
    header("Location: ../succession.php"); // Redirect back
    exit();
}
?>
