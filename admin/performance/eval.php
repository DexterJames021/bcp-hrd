<?php
// eval.php

require('../../config/db_talent.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filter = $_GET['type'] ?? 'Teaching';

// ✅ Function to show evaluation table by type
function showEvaluationTable($conn, $employeeType, $evaluationType)
{
    $stmt = $conn->prepare("
        SELECT 
            e.EmployeeID,
            CONCAT(e.FirstName, ' ', e.LastName) AS FullName,
            ROUND(AVG(p.Score), 2) AS AverageScore,
            MAX(p.Comments) AS LatestComment
        FROM employees e
        INNER JOIN performanceevaluations p ON e.EmployeeID = p.EmployeeID
        WHERE e.EmployeeType = ? AND p.EvaluationType = ?
        GROUP BY e.EmployeeID
    ");
    $stmt->bind_param("ss", $employeeType, $evaluationType);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <div class="card mb-4">
        <h4 class="section-title"><?= $evaluationType ?></h4>
        <table class="table table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>Employee Name</th>
                <th>Average Score</th>
                <th>Latest Comment</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['FullName'] ?></td>
                        <td><?= $row['AverageScore'] ?? 'N/A' ?></td>
                        <td><?= $row['LatestComment'] ?: 'No comment' ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3">No evaluations found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Evaluation Results</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            margin-top: 40px;
            margin-bottom: 60px;
        }

        h2 {
            color: #004a99;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .card {
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #004a99;
            margin-bottom: 15px;
        }

        .filter-form select {
            max-width: 300px;
        }

        .back-btn {
            float: right;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Employee Evaluation Results</h2>
        <a href="perf_dboard.php" class="btn btn-secondary back-btn">← Back to Dashboard</a>
    </div>

    <!-- Filter Form -->
    <form method="GET" class="mb-4 filter-form">
        <label for="type"><strong>Filter by Employee Type:</strong></label>
        <select name="type" id="type" class="form-control w-auto d-inline-block" onchange="this.form.submit()">
            <option value="Teaching" <?= $filter == 'Teaching' ? 'selected' : '' ?>>Teaching</option>
            <option value="Non-Teaching" <?= $filter == 'Non-Teaching' ? 'selected' : '' ?>>Non-Teaching</option>
            <option value="Officer" <?= $filter == 'Officer' ? 'selected' : '' ?>>Officer</option>
        </select>
    </form>

    <!-- Display Evaluation Tables -->
    <?php if ($filter === 'Teaching'): ?>
        <?php
        showEvaluationTable($conn, 'Teaching', 'Supervisor Evaluation');
        showEvaluationTable($conn, 'Teaching', 'Students Evaluation');
        showEvaluationTable($conn, 'Teaching', 'Peer Evaluation');
        ?>
    <?php else: ?>
        <?php
        $stmt = $conn->prepare("
            SELECT 
                e.EmployeeID,
                CONCAT(e.FirstName, ' ', e.LastName) AS FullName,
                p.EvaluationType,
                p.Score,
                p.Comments,
                p.EvaluationDate
            FROM employees e
            LEFT JOIN performanceevaluations p ON e.EmployeeID = p.EmployeeID
            WHERE e.EmployeeType = ?
            ORDER BY e.EmployeeID, p.EvaluationDate DESC
        ");
        $stmt->bind_param("s", $filter);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>

        <div class="card">
            <h4 class="section-title"><?= $filter ?> Evaluation Results</h4>
            <table class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>Employee Name</th>
                    <th>Evaluation Type</th>
                    <th>Score</th>
                    <th>Comments</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['FullName'] ?></td>
                            <td><?= $row['EvaluationType'] ?: 'N/A' ?></td>
                            <td><?= $row['Score'] ?? 'N/A' ?></td>
                            <td><?= $row['Comments'] ?: 'No comment' ?></td>
                            <td><?= $row['EvaluationDate'] ?? 'N/A' ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">No evaluations found for this type.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php $stmt->close(); ?>
    <?php endif; ?>
</div>
</body>
</html>

<?php $conn->close(); ?>
