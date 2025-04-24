<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['employeeID'])) {
    header("Location: ../auth/login.php");
    exit();
}

// DB connection
require("../config/db_talent.php");

// Set Employee ID to 50 (updated from 44)
$employeeID = 50;

// Fetch employee full name
$stmt_name = $conn->prepare("SELECT CONCAT(FirstName, ' ', LastName) AS full_name FROM employees WHERE EmployeeID = ?");
$stmt_name->bind_param("i", $employeeID);
$stmt_name->execute();
$name_result = $stmt_name->get_result();

if ($name_result->num_rows > 0) {
    $employee_name = $name_result->fetch_assoc()['full_name'];
} else {
    $employee_name = "Unknown";
}
$stmt_name->close();

// Fetch latest evaluation
$sql = "SELECT EvaluationType, Score, Comments, EvaluationDate 
        FROM performanceevaluations 
        WHERE EmployeeID = ? 
        ORDER BY EvaluationDate DESC 
        LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employeeID);
$stmt->execute();
$result = $stmt->get_result();
$latest = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Latest Evaluation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap + FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-header {
            height: 70px;
            position: fixed;
            width: 100%;
            z-index: 1030;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 70px;
            background-color: #0b0925;
            color: white;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #1a173d;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            padding-top: 100px;
        }

        .card {
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 15px 20px;
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #004a99;
            margin-bottom: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="dashboard-header">
    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <a class="navbar-brand" href="#">
            <img src="../assets/images/bcp-hrd-logo.jpg" alt="BCP Logo" style="height: 3rem;">
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown nav-user">
                <a class="nav-link nav-user-img d-flex align-items-center" href="#" data-toggle="dropdown">
                    <img src="../assets/images/default-avatar.png" class="user-avatar-md rounded-circle mr-2" style="height: 35px;">
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center bg-primary text-white">
                        <img src="../assets/images/default-avatar.png" class="rounded-circle mb-2" style="height: 60px;">
                        <h6><?= $_SESSION['username'] ?></h6>
                    </div>
                    <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i> Profile</a>
                    <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i> Settings</a>
                    <a class="dropdown-item" href="../auth/logout.php"><i class="fas fa-power-off mr-2"></i> Logout</a>
                </div>
            </li>
        </ul>
    </nav>
</div>

<!-- Sidebar -->
<div class="sidebar">
    <a href="nonteach_db.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
    <a href="latesteval_nonteach.php"><i class="fas fa-star mr-2"></i>My Evaluations</a>
    <a href="evalhistory_nonteach.php"><i class="fas fa-history mr-2"></i>Evaluation History</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">📋 Latest Evaluation</h4>
        </div>
        <div class="card-body">
            <h5 class="section-title">Your Most Recent Evaluation</h5>

            <?php if ($latest): ?>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Evaluation Type</th>
                            <th>Score</th>
                            <th>Comments</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= htmlspecialchars($latest['EvaluationType'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($latest['Score'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($latest['Comments'] ?: 'No comments') ?></td>
                            <td><?= date("F j, Y", strtotime($latest['EvaluationDate'])) ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">No evaluation data available.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
