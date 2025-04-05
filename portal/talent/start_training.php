<?php
require "../../config/db_talent.php"; // Ensure your database connection is included
session_start();  // Start the session to use session variables

// Handle the POST request safely
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assignment_id'])) {
    $training_assignment_id = $_POST['assignment_id'];

    // Query to update the status to 'In Progress'
    $query = "UPDATE training_assignments SET status = 'In Progress' WHERE assignment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $training_assignment_id);  // Use the assignment ID to update the correct record
    
    if ($stmt->execute()) {
        // Set a session message indicating success
        $_SESSION['message'] = "Training started successfully!";
        
        // Redirect to training_sessions.php with the success message
        header("Location: training_sessions.php");
        exit;
    } else {
        // Error handling
        echo "Error updating status!";
    }
}
?>
