<?php
require "config/db_talent.php"; // Database connection

$query = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';

$whereSQL = "job_postings.status = 'Open'";
if (!empty($query)) {
    $whereSQL .= " AND (job_postings.job_title LIKE '%$query%' OR job_postings.job_description LIKE '%$query%')";
}

$sql = "SELECT job_postings.*, departments.DepartmentName 
        FROM job_postings 
        LEFT JOIN departments ON job_postings.DepartmentID = departments.DepartmentID 
        WHERE $whereSQL";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="col-md-4 mb-4">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary"><?php echo htmlspecialchars($row['job_title']); ?></h5>
                    <p class="card-text"><strong>Job Description:</strong> <?php echo substr(htmlspecialchars($row['job_description']), 0, 100) . '...'; ?></p>
                    <p><strong>Requirements:</strong></p>
                    <ul>
                        <?php foreach (explode("\n", $row['requirements']) as $requirement) { ?>
                            <li><?php echo htmlspecialchars($requirement); ?></li>
                        <?php } ?>
                    </ul>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                    <p><strong>Salary:</strong> <?php echo htmlspecialchars($row['salary_range']); ?></p>
                    <p><strong>Department:</strong> <?php echo htmlspecialchars($row['DepartmentName']); ?></p>
                    <a href="admin/talent/recruitment/apply.php?job_id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-success">Apply Now</a>
                </div>
            </div>
        </div>
    <?php }
} else {
    echo "<p class='text-center'>No job postings found.</p>";
}
?>
