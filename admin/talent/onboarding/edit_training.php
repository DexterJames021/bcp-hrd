<?php
session_start();
require "../../../config/db_talent.php"; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['training_id'])) {
    // Ensure that training_id is not empty
    if (empty($_POST['training_id'])) {
        $_SESSION['error_message'] = "Training ID is missing.";
        header("Location: ../onboarding.php");
        exit;
    }

    // Sanitize and fetch the input data
    $trainingId = $_POST['training_id'];
    $trainingName = $_POST['training_name'];
    $trainer = $_POST['trainer'];
    $department = $_POST['department'];
    $trainingDescription = $_POST['training_description'];
    $trainingMaterials = $_POST['training_materials'];

    // Prepare the update SQL statement
    $sql = "UPDATE training_sessions 
            SET training_name = ?, trainer = ?, department = ?, training_description = ?, training_materials = ?
            WHERE training_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("sssssi", $trainingName, $trainer, $department, $trainingDescription, $trainingMaterials, $trainingId);

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Training session updated successfully.";
            header("Location: ../onboarding.php"); // Redirect to the training list page
            exit;
        } else {
            $_SESSION['error_message'] = "Error updating training session: " . $conn->error;
            header("Location: ../onboarding.php");
            exit;
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Error preparing update statement: " . $conn->error;
        header("Location: ../onboarding.php");
        exit;
    }
}
?>
