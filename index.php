<?php
session_start();
require "config/db_talent.php"; // Adjust path if needed

// Helper function to truncate text
function truncateText($text, $maxChars = 100) {
    return strlen($text) > $maxChars ? substr($text, 0, $maxChars) . '...' : $text;
}

// Fetch departments for filtering
$dept_query = "SELECT DISTINCT DepartmentName FROM departments";
$dept_result = mysqli_query($conn, $dept_query);

// Fetch locations for filtering
$loc_query = "SELECT DISTINCT location FROM job_postings";
$loc_result = mysqli_query($conn, $loc_query);

// Fetch job postings with filters
$whereClauses = ["job_postings.status = 'Open'"];
if (!empty($_GET['query'])) {
    $search = mysqli_real_escape_string($conn, $_GET['query']);
    $whereClauses[] = "(job_postings.job_title LIKE '%$search%' OR job_postings.job_description LIKE '%$search%')";
}
if (!empty($_GET['department'])) {
    $department = mysqli_real_escape_string($conn, $_GET['department']);
    $whereClauses[] = "departments.DepartmentName = '$department'";
}
if (!empty($_GET['location'])) {
    $location = mysqli_real_escape_string($conn, $_GET['location']);
    $whereClauses[] = "job_postings.location = '$location'";
}
$whereSQL = implode(" AND ", $whereClauses);

$query = "SELECT job_postings.*, departments.DepartmentName 
          FROM job_postings 
          LEFT JOIN departments ON job_postings.DepartmentID = departments.DepartmentID 
          WHERE $whereSQL";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="stylesheet" href="styledashboard.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Employee Management System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <form class="d-flex me-3" id="searchForm">
    <input class="form-control me-2" type="search" id="searchInput" placeholder="Search jobs...">
</form>

                </li>
                <li class="nav-item"><a class="nav-link" href="#jobs">Apply Now</a></li>
                <li class="nav-item"><a class="btn btn-light text-primary" href="auth/index.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<header class="text-white text-center d-flex align-items-center justify-content-center position-relative" style="min-height: 100vh; overflow: hidden;">
    <div class="slideshow position-absolute w-100 h-100">
        <img src="assets/images/bcp1.jpg" class="active">
        <img src="assets/images/bcp2.jpg">
        <img src="assets/images/bcp4.jpg">
    </div>
    <div class="container position-relative z-index-2">
        <h1 class="display-4 fw-bold">Welcome to the Employee Management System of Bestlink College of the Philippines</h1>
        <p class="lead">Find job opportunities and manage employees efficiently.</p>
    </div>
</header>

<section id="jobs" class="container my-5">
    <h2 class="text-center mb-4">NOW HIRING!</h2>
    <div class="row" id="jobListings">
    <?php if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><?php echo htmlspecialchars($row['job_title']); ?></h5>
                        <p class="card-text"><strong>Job Description:</strong> <?php echo truncateText(htmlspecialchars($row['job_description']), 100); ?></p>
                        
                        <!-- Requirements Section -->
                        <p><strong>Requirements:</strong></p>
                        <ul>
                            <?php 
                            $requirements = explode("\n", $row['requirements']); // Hatiin bawat linya
                            foreach ($requirements as $requirement) { 
                                if (!empty(trim($requirement))) { // Iwasan ang blank items
                                    echo "<li>" . htmlspecialchars($requirement) . "</li>";
                                }
                            } 
                            ?>
                        </ul>
                        
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                        <p><strong>Salary:</strong> <?php echo htmlspecialchars($row['salary_range']); ?></p>
                        <p><strong>Department:</strong> <?php echo htmlspecialchars($row['DepartmentName']); ?></p>
                        <a href="admin/talent/recruitment/apply.php?job_id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-success">Apply Now</a>
                    </div>
                </div>
            </div>
        <?php }
    } else { ?>
        <p class="text-center">No job postings available at the moment.</p>
    <?php } ?>
</div>

</section>

<footer class="bg-dark text-white text-center py-3">
    <p>&copy; <?php echo date("Y"); ?> Employee Management System. All rights reserved.</p>
</footer>
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let query = this.value.trim(); // Kunin ang input value
    let xhr = new XMLHttpRequest(); // Gumawa ng AJAX request
    xhr.open('GET', 'search_jobs.php?query=' + encodeURIComponent(query), true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('jobListings').innerHTML = xhr.responseText; // Palitan ang job listings
        }
    };
    xhr.send();
});
</script>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
