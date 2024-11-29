<?php
require "../../../config/db_talent.php";

// Fetch job postings
$query = "SELECT * FROM job_postings WHERE STATUS = 'Open'";
$result = mysqli_query($conn, $query);

// Check if there are any job postings
if (mysqli_num_rows($result) > 0) {
    echo "<h1>Job Listings</h1>";
    echo "<ul>";

    // Display job postings
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>";
        echo "<h3>" . htmlspecialchars($row['job_title']) . "</h3>";
        echo "<p><strong>Job Description:</strong> " . htmlspecialchars($row['job_description']) . "</p>";
        echo "<p><strong>Requirements:</strong> " . htmlspecialchars($row['requirements']) . "</p>"; // Added requirements
        echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
        echo "<p><strong>Salary:</strong> " . htmlspecialchars($row['salary_range']) . "</p>";
        echo "<a href='apply.php?job_id=" . htmlspecialchars($row['id']) . "'>Apply Now</a>";
        echo "</li>";
    }

    echo "</ul>";
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
    <link rel="stylesheet" href="stylejoblist1.css">
</head>
<body>
    
</body>
</html>
