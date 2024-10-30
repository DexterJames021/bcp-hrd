<?php
session_start(); // Start the session
require "../../../../config/db_talent.php"; // Adjust the path as needed

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the data from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $hire_date = $_POST['hire_date'];
    $department_id = $_POST['department_id']; // Make sure this is the DepartmentID
    $job_posting_id = $_POST['job_posting_id'];
    $user_id = $_POST['user_id'];

    // Define the values for Salary and Status as NULL
    $salary = NULL; // Set to NULL as required
    $status = 'Active'; // You can set a default status if needed, e.g., 'Pending'

    // Prepare the SQL statement to insert the new employee record
    $insert_query = "
        INSERT INTO employees (FirstName, LastName, Email, Phone, Address, DOB, HireDate, DepartmentID, Salary, Status, UserID, job_posting_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($insert_query);
    
    // Bind parameters
    // Note: Adjust the binding types to include NULL for Salary and string for Status
    $stmt->bind_param("ssssssssssss", $first_name, $last_name, $email, $phone, $address, $dob, $hire_date, $department_id, $salary, $status, $user_id, $job_posting_id);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Successful insert
        $_SESSION['task_progress']++; // Increment task progress
        header("Location: task2.php"); // Redirect to a success page
        exit();
    } else {
        // Error inserting data
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>
