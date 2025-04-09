<?php
// Include database connection
require "../../../config/db_talent.php";

// Check if the form data is received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $userId = $_POST['id'];
    $username = $_POST['username'];
    $usertype = $_POST['usertype'];

    // Prepare and execute the SQL query to update the user details
    $sql = "UPDATE users SET username = ?, usertype = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssi", $username, $usertype, $userId); // s = string, s = string, i = integer (userId)

        // Execute and check if the query was successful
        if ($stmt->execute()) {
            // Redirect to the onboarding page only after the update is successful
            header("Location: ../onboarding.php"); // Adjust the path if needed
            exit(); // Make sure to call exit() after header redirection
        } else {
            // Display error message
            echo "error: " . $stmt->error; // Return error message if execution fails
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "error: failed to prepare the query"; // Query preparation failed
    }
}
?>
