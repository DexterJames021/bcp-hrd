<?php
require "../../../config/db_talent.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $jobTitle = $_POST['jobTitle'];
    $jobDescription = $_POST['jobDescription'];
    $departmentID = $_POST['departmentID'];
    $salaryMin = $_POST['salaryMin'];
    $salaryMax = $_POST['salaryMax'];

    // Prepare an SQL statement to insert the data
    $sql = "INSERT INTO jobroles (JobTitle, JobDescription, DepartmentID, SalaryRangeMin, SalaryRangeMax) 
            VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("ssidd", $jobTitle, $jobDescription, $departmentID, $salaryMin, $salaryMax);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect back to the recruitment page after a successful insert
            header("Location: ../recruitment.php");
        } else {
            // If the insertion failed, show an error message
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle prepare statement failure
        echo "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
