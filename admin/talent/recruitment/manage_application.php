<?php
// Include database connection
require "../../../config/db_talent.php";

// Check if job_id is present in the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
} else {
    die("Error: job_id parameter missing in the URL.");
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
    <title>Manage Applications</title>
    <link rel="stylesheet" href="style_ma2.css"> <!-- Link to the CSS file -->
</head>
<body>

<!-- Display the applicants -->
<h2>Applicants for Job ID <?= $job_id ?></h2>
<table>
    <tr>
        <th>Applicant Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Applied At</th>
        <th>Resume</th>
        <th>Department</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($applicants as $applicant): ?>
        <tr>
            <td data-label="Applicant Name"><?= htmlspecialchars($applicant['applicant_name']) ?></td>
            <td data-label="Email"><?= htmlspecialchars($applicant['email']) ?></td>
            <td data-label="Status"><?= htmlspecialchars($applicant['status']) ?></td>
            <td data-label="Applied At"><?= date('F j, Y, g:i A', strtotime($applicant['applied_at'])) ?></td>
            <td data-label="Resume">
                <?php if (!empty($applicant['resume_path'])): ?>
                    <a href="<?= htmlspecialchars($applicant['resume_path']) ?>" download>Download Resume</a>
                <?php else: ?>
                    No Resume Uploaded
                <?php endif; ?>
            </td>
            <td data-label="Department"><?= htmlspecialchars($applicant['DepartmentName'] ?? 'N/A') ?></td> <!-- Display department name or 'N/A' if null -->

            <td data-label="Actions">
                <?php if ($applicant['status'] === 'Pending'): ?>
                    <form action="update_status.php?job_id=<?= $job_id ?>" method="POST" style="display:inline;">
                        <input type="hidden" name="applicant_id" value="<?= $applicant['id'] ?>">
                        <button type="submit" name="status" value="Selected for Interview" onclick="return confirm('Are you sure you want to hire this applicant?')">Selected</button>
                        <button type="submit" name="status" value="Rejected" onclick="return confirm('Are you sure you want to reject this applicant?')">Reject</button>
                    </form>
                <?php elseif ($applicant['status'] === 'Selected for Interview'): ?>
                    <form action="schedule_interview.php" method="POST" style="display:inline;">
                        <input type="hidden" name="applicant_id" value="<?= $applicant['id'] ?>">
                        <input type="hidden" name="job_id" value="<?= $job_id ?>">
                        <label for="interview_date">Interview Date:</label>
                        <input type="date" name="interview_date" required><br>
                        <label for="interview_time">Interview Time:</label>
                        <input type="time" name="interview_time" required><br>
                        <button type="submit">Schedule Interview</button>
                    </form>
                <?php elseif ($applicant['status'] === 'Interviewed'): ?>
                    <span>Interview Scheduled for <?= date('F j, Y', strtotime($applicant['interview_date'])) ?> at <?= date('g:i A', strtotime($applicant['interview_time'])) ?></span><br>
                    <form action="update_status.php?job_id=<?= $job_id ?>" method="POST" style="display:inline;">
                        <input type="hidden" name="applicant_id" value="<?= $applicant['id'] ?>">
                        <button type="submit" name="status" value="Shortlisted">Interview Passed</button>
                        <button type="submit" name="status" value="Rejected">Interview Failed</button>
                    </form>
                <?php elseif ($applicant['status'] === 'Shortlisted'): ?>
                    <form action="update_status.php?job_id=<?= $job_id ?>" method="POST" style="display:inline;">
                        <input type="hidden" name="applicant_id" value="<?= $applicant['id'] ?>">
                        <button type="submit" name="status" value="Hired">Job Offer</button>
                        <button type="submit" name="status" value="Rejected">Reject</button>
                    </form>
                <?php else: ?>
                    <span><?= htmlspecialchars($applicant['status']) ?></span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
