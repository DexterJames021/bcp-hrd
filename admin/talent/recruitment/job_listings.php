<<<<<<< HEAD

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job opportunity</title>
    <link rel="stylesheet" href="stylejoblist4.css">
    <link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">BCP: <span class="text-warning">HRD</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="Home" href="../../../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="Job opportunity" href="job_listings.php">Job opportunity</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="Application" href="#">Application</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="About us" href="#">About us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    
</body>
</html>
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
    echo "<div class='container'>"; // Start the grid container

    // Display job postings
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='box'>";
        echo "<h3>" . htmlspecialchars($row['job_title']) . "</h3>";

        // Truncate job description
        echo "<p><strong>Job Description:</strong> " . htmlspecialchars($row['job_description']) . "</p>";

        // Display requirements as a bullet list
        echo "<p><strong>Requirements:</strong></p><ul>";
        $requirements = explode("\n", $row['requirements']);
        foreach ($requirements as $requirement) {
            echo "<li>" . htmlspecialchars($requirement) . "</li>";
        }
        echo "</ul>";

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
=======
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
>>>>>>> tech-analytics
