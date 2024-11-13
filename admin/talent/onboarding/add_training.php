<?php
// Assuming you have a connection to the database
require "../../../config/db_talent.php"; // Adjust the path as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $training_title = $_POST['training_title'];
    $training_description = $_POST['training_description'];
    $trainer = $_POST['trainer'];
    $department = $_POST['department'];
    $training_materials = $_POST['training_materials'];

    // Insert the training session data into the database
    $sql = "INSERT INTO training_sessions (training_name, training_description, trainer, department, training_materials, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the form data to the prepared statement
        $stmt->bind_param("sssss", $training_title, $training_description, $trainer, $department, $training_materials);

        // Execute the statement
        if ($stmt->execute()) {
            // Success message (optional)
            $_SESSION['success_message'] = "Training session added successfully!";
        } else {
            // Error message
            $_SESSION['error_message'] = "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error message if the statement couldn't be prepared
        $_SESSION['error_message'] = "Error preparing the SQL query: " . $conn->error;
    }

    // Redirect to the previous page or any other page
    header('Location: ../onboarding.php');  // Adjust this to your needs
    exit();
}
?>
