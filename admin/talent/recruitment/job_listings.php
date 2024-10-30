<?php
require "../../../config/db_talent.php";

// Helper function to truncate text
function truncateText($text, $maxChars = 100) {
    return strlen($text) > $maxChars ? substr($text, 0, $maxChars) . '...' : $text;
}

// Fetch job postings with department names
$query = "
    SELECT job_postings.*, departments.DepartmentName 
    FROM job_postings 
    LEFT JOIN departments ON job_postings.DepartmentID = departments.DepartmentID 
    WHERE job_postings.status = 'Open'";
$result = mysqli_query($conn, $query);

// Check for query execution error
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Check if there are any job postings
if (mysqli_num_rows($result) > 0) {
    echo "<h1>Job Listings</h1>";
    echo "<div class='container'>"; // Start the grid container

    // Display job postings
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='box'>";
        echo "<h3>" . htmlspecialchars($row['job_title']) . "</h3>";
       
        echo "<p><strong>Job Description:</strong> " . htmlspecialchars(truncateText($row['job_description'])) . "</p>";
        echo "<p><strong>Requirements:</strong> " . htmlspecialchars(truncateText($row['requirements'])) . "</p>";
        
        echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
        echo "<p><strong>Salary:</strong> " . htmlspecialchars($row['salary_range']) . "</p>";
        echo "<p><strong>Department:</strong> " . htmlspecialchars($row['DepartmentName']) . "</p>"; // Display department name
        echo "<p><strong>Posted On:</strong> " . htmlspecialchars(date('F j, Y', strtotime($row['created_at']))) . "</p>";
        echo "<a href='apply.php?job_id=" . htmlspecialchars($row['id']) . "'>Apply Now</a>";
        echo "</div>";
    }

    echo "</div>"; // End the grid container
} else {
    echo "<p>No job postings available at the moment.</p>";
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link rel="stylesheet" href="stylejoblist2.css">
    <style>
        /* Include the CSS styles here */
    </style>
</head>
<body>
    <!-- PHP script to display job listings -->
</body>
</html>
