<?php
session_start();
require "../../../config/db_talent.php"; // Adjust the path as needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department_id = $_POST['department_id'];
    $department_name = trim($_POST['department_name']);
    $manager_id = $_POST['manager_id'];

    // Check if department ID is valid and exists
    if (empty($department_id)) {
        $_SESSION['message'] = "Invalid department ID.";
        $_SESSION['message_type'] = "danger";
        header("Location: ../recruitment.php");
        exit();
    }

    // Check if department name is not empty
    if (empty($department_name)) {
        $_SESSION['message'] = "Department name cannot be empty.";
        $_SESSION['message_type'] = "danger";
        header("Location: ../recruitment.php");
        exit();
    }

    // If manager_id is empty, set it to NULL
    if (empty($manager_id)) {
        $manager_id = NULL;
    } else {
        // Validate if the provided Manager ID exists in the employees table
        $checkManagerIdSql = "SELECT COUNT(*) FROM employees WHERE EmployeeID = ?";
        if ($stmt = $conn->prepare($checkManagerIdSql)) {
            $stmt->bind_param("i", $manager_id);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            // If the Manager ID does not exist, set it to NULL
            if ($count == 0) {
                $manager_id = NULL;
            }
        } else {
            $_SESSION['message'] = "Error validating Manager ID: " . $conn->error;
            $_SESSION['message_type'] = "danger";
            header("Location: ../recruitment.php");
            exit();
        }
    }

    // Prepare and execute the update statement
    $stmt = $conn->prepare("UPDATE departments SET DepartmentName = ?, ManagerID = ? WHERE DepartmentID = ?");
    if ($stmt) {
        $stmt->bind_param("sii", $department_name, $manager_id, $department_id); // "sii" means string, integer, integer
        if ($stmt->execute()) {
            $_SESSION['message'] = "Department updated successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error: " . $stmt->error;
            $_SESSION['message_type'] = "danger";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error preparing statement: " . $conn->error;
        $_SESSION['message_type'] = "danger";
    }

    $conn->close();
    header("Location: ../recruitment.php");
    exit();
}
?>
