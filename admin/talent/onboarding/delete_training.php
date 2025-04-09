<?php
session_start();
require "../../../config/db_talent.php"; // Adjust the path as needed

// Check if the ID is provided and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $training_id = $_GET['id'];

    // Prepare the DELETE SQL query
    $delete_query = "DELETE FROM training_sessions WHERE training_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $training_id);

    // Execute the query and check for success
    if ($delete_stmt->execute()) {
        // Redirect with a success message after deletion
        header("Location: ../succession.php?message=Training deleted successfully");
        exit();
    } else {
        // Redirect with an error message if deletion fails
        header("Location: ../succession.php?message=Error deleting training");
        exit();
    }
} else {
    // Redirect to the list page with an error if no valid ID is provided
    header("Location: ../succession.php?message=Invalid training ID");
    exit();
}
?>
