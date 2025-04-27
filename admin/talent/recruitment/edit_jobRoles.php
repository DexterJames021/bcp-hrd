<?php
session_start();
// Include the database connection file
require "../../../config/db_talent.php";

/// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form values
    $JobRoleID = $_POST['jobRoleID'];  // Correct the variable name here
    $JobTitle = $_POST['JobTitle'];
    $JobDescription = $_POST['JobDescription'];
    $minSalary = $_POST['minSalary'];
    $maxSalary = $_POST['maxSalary'];
    $departmentID = $_POST['department'];

    // Check if all required fields are set
    if (isset($JobRoleID, $JobTitle, $JobDescription, $minSalary, $maxSalary, $departmentID)) {
        // SQL query to update the job role in the database
        $sql = "UPDATE jobroles SET 
                JobTitle = ?, 
                JobDescription = ?, 
                SalaryRangeMin = ?, 
                SalaryRangeMax = ?, 
                DepartmentID = ? 
                WHERE JobRoleID = ?";

        // Prepare and bind the SQL statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind the parameters to the SQL statement
            $stmt->bind_param("ssddii", $JobTitle, $JobDescription, $minSalary, $maxSalary, $departmentID, $JobRoleID);

            // Execute the statement
            if ($stmt->execute()) {
                $_SESSION['message'] = "Job role updated successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Error executing the update query.";
                $_SESSION['message_type'] = "error";
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            $_SESSION['message'] = "Error preparing the update query.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Missing required fields!";
        $_SESSION['message_type'] = "error";
    }

    // Redirect back to the jobs listing page
    header('Location: ../recruitment.php');
    exit();
}

?>
