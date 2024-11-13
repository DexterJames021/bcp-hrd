<?php
// Include database connection
require "../../../config/db_talent.php";

// Check if job_id is present in the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
} else {
    die("Error: job_id parameter missing in the URL.");
}

// Prepare the SQL query to get the job title for the job_id
$jobTitleSql = "SELECT job_title FROM job_postings WHERE id = ?";
$stmt = $conn->prepare($jobTitleSql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$stmt->bind_result($job_title);
$stmt->fetch();
$stmt->close();

// If no job title is found, terminate
if (!$job_title) {
    die("Error: Job not found.");
}

// Prepare the SQL query to get applicants for the job_id, along with department information
$sql = "
    SELECT a.*, d.DepartmentName 
    FROM applicants a 
    LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID 
    WHERE a.job_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();

// Use get_result() and fetch_assoc() to fetch all applicants
$result = $stmt->get_result();
$applicants = [];
while ($row = $result->fetch_assoc()) {
    $applicants[] = $row;
}

// Close the statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicants for <?= htmlspecialchars($job_title) ?></title>
    <link rel="stylesheet" href="style_ma6.css"> <!-- Link to the CSS file -->
</head>
<body>

<!-- Back Button -->
<div class="back-button">
    <a href="../recruitment.php" class="btn btn-primary">
        Back
    </a>
</div>

<!-- Display the applicants -->
<div class="container">
    <h1>Applicants for <?= htmlspecialchars($job_title) ?></h1>
    <div class="table-responsive">
        <table class="table table1">
            <thead class="sticky-header">
                <tr>
                    <th>Applicant Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Applied At</th>
                    <th>Resume</th>
                    <th>Department</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applicants as $applicant): ?>
                    <tr>
                        <td data-label="Applicant Name"><?= htmlspecialchars($applicant['applicant_name']) ?></td>
                        <td data-label="Email"><?= htmlspecialchars($applicant['email']) ?></td>
                        <td data-label="Status"><?= htmlspecialchars($applicant['status']) ?></td>
                        <td data-label="Applied At"><?= date('F j, Y, g:i A', strtotime($applicant['applied_at'])) ?></td>
                        <td data-label="Resume">
                            <?php if (!empty($applicant['resume_path'])): ?>
                                <a href="<?= htmlspecialchars($applicant['resume_path']) ?>" download class="btn btn-primary">Download Resume</a>
                            <?php else: ?>
                                <span>No Resume Uploaded</span>
                            <?php endif; ?>
                        </td>
                        <td data-label="Department"><?= htmlspecialchars($applicant['DepartmentName'] ?? 'N/A') ?></td>

                        <td data-label="Actions">
                            <?php if ($applicant['status'] === 'Pending'): ?>
                                <form action="update_status.php?job_id=<?= htmlspecialchars($job_id) ?>" method="POST" class="action-buttons">
                                    <input type="hidden" name="applicant_id" value="<?= htmlspecialchars($applicant['id']) ?>">
                                    <button type="submit" name="status" value="Selected for Interview" class="btn btn-primary" onclick="return confirm('Are you sure you want to select this applicant for an interview?')">Select for Interview</button>
                                    <button type="submit" name="status" value="Rejected" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this applicant?')">Reject</button>
                                </form>
                            <?php elseif ($applicant['status'] === 'Selected for Interview'): ?>
                                <form action="schedule_interview.php" method="POST" class="action-buttons">
                                    <input type="hidden" name="applicant_id" value="<?= htmlspecialchars($applicant['id']) ?>">
                                    <input type="hidden" name="job_id" value="<?= htmlspecialchars($job_id) ?>">
                                    <label for="interview_date">Interview Date:</label>
                                    <input type="date" name="interview_date" required><br>
                                    <label for="interview_time">Interview Time:</label>
                                    <input type="time" name="interview_time" required><br>
                                    <button type="submit" class="btn btn-primary">Schedule Interview</button>
                                </form>
                            <?php elseif ($applicant['status'] === 'Interviewed'): ?>
                                <span>Interview Scheduled for <?= date('F j, Y', strtotime($applicant['interview_date'])) ?> at <?= date('g:i A', strtotime($applicant['interview_time'])) ?></span><br>
                                <form action="update_status.php?job_id=<?= htmlspecialchars($job_id) ?>" method="POST" class="action-buttons">
                                    <input type="hidden" name="applicant_id" value="<?= htmlspecialchars($applicant['id']) ?>">
                                    <button type="submit" name="status" value="Shortlisted" class="btn btn-success">Interview Passed</button>
                                    <button type="submit" name="status" value="Rejected" class="btn btn-danger">Interview Failed</button>
                                </form>
                            <?php elseif ($applicant['status'] === 'Shortlisted'): ?>
                                <form action="update_status.php?job_id=<?= htmlspecialchars($job_id) ?>" method="POST" class="action-buttons">
                                    <input type="hidden" name="applicant_id" value="<?= htmlspecialchars($applicant['id']) ?>">
                                    <button type="submit" name="status" value="Hired" class="btn btn-success">Job Offer</button>
                                    <button type="submit" name="status" value="Rejected" class="btn btn-danger">Reject</button>
                                </form>
                            <?php else: ?>
                                <span><?= htmlspecialchars($applicant['status']) ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
