<?php
session_start();
require "../../../config/db_talent.php"; // Adjust the path as needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department_name = $_POST['department_name'];
    $manager_id = $_POST['manager_id']; // Get the Manager ID from the form

    // Check if Manager ID is empty and set to NULL if so
    if (empty($manager_id)) {
        $manager_id = NULL; // Set to NULL for optional case
    } else {
        // Validate if the provided Manager ID exists in the employees table
        $checkManagerIdSql = "SELECT COUNT(*) FROM employees WHERE EmployeeID = ?";
        $stmt = $conn->prepare($checkManagerIdSql);
        $stmt->bind_param("i", $manager_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        // If the Manager ID does not exist, set it to NULL
        if ($count == 0) {
            $manager_id = NULL;
        }
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO departments (DepartmentName, ManagerID) VALUES (?, ?)");
    $stmt->bind_param("si", $department_name, $manager_id); // "si" means string and integer

    if ($stmt->execute()) {
        $_SESSION['message'] = "New department added successfully!";
        $_SESSION['message_type'] = "success"; // Set message type for display
        header("Location: ../recruitment.php"); // Redirect to recruitment page after successful insertion
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['message_type'] = "danger"; // Set message type for error display
    }

    $stmt->close();
}
$conn->close();
?>
