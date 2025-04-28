<?php
session_start();

// Check if employee is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['employeeID'])) {
    header("Location: ../auth/login.php");
    exit();
}

// DB connectio
require('C:/xampp/htdocs/bcp-hrd/config/db_talent.php');

$employeeID = $_SESSION['employeeID'];

// Fetch the latest evaluation for the logged-in employee
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
    <title>Employee Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap + FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; }
        .dashboard-header { height: 70px; position: fixed; width: 100%; z-index: 1030; }
        .main-content { margin-left: 250px; padding: 30px; padding-top: 100px; }
        .sidebar {
            height: 100vh; width: 250px; position: fixed; left: 0; top: 70px;
            background-color: #0b0925; color: white; padding-top: 20px;
        }
        .sidebar a { color: white; display: block; padding: 10px 20px; text-decoration: none; }
        .sidebar a:hover { background-color: #1a173d; }
        .card { box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .section-title { font-weight: bold; color: #004a99; }
        .notification { position: fixed; top: 0; width: 100%; background-color: #28a745; color: white; padding: 10px; text-align: center; display: none; }
    </style>
</head>
<body>

<!-- Notification -->
<div id="notification" class="notification">
    New Evaluation Available!
</div>

<!-- Main Content -->
<div class="dashboard-main-wrapper">
    <!-- Header -->
    <div class="dashboard-header">
        <nav class="navbar navbar-expand-lg bg-white fixed-top">
            <a class="navbar-brand" href="#"><img src="../assets/images/bcp-hrd-logo.jpg" alt="" style="height: 3rem;"></a>
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
        <a href="#">Dashboard</a>
        <a href="latest_eval.php">My Evaluations</a>
        <a href="eval_history.php">Evaluation History</a>
    </div>

    <!-- Content -->
    <div class="main-content">
        <h2>Welcome, <?= $_SESSION['username'] ?>!</h2>

        <div class="row">
            <!-- Latest Evaluation -->
            <div class="col-md-6">
                <div class="card p-4 mb-4">
                    <h5 class="section-title">Latest Evaluation</h5>
                    <?php if ($latest): ?>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Type:</strong> <?= $latest['EvaluationType'] ?: 'N/A' ?></li>
                            <li class="list-group-item"><strong>Score:</strong> <?= $latest['Score'] ?></li>
                            <li class="list-group-item"><strong>Comments:</strong> <?= $latest['Comments'] ?: 'No comment' ?></li>
                            <li class="list-group-item"><strong>Date:</strong> <?= date('F j, Y', strtotime($latest['EvaluationDate'])) ?></li>
                        </ul>
                    <?php else: ?>
                        <p>No evaluation records found.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Evaluation History -->
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <h5 class="section-title">Evaluation History</h5>
                    <?php
                    $stmt = $conn->prepare("SELECT EvaluationType, Score, Comments, EvaluationDate FROM performanceevaluations WHERE EmployeeID = ? ORDER BY EvaluationDate DESC");
                    $stmt->bind_param("i", $employeeID);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $evaluations = [];
                    while ($row = $result->fetch_assoc()) {
                        $evaluations[$row['EvaluationType']][] = $row;
                    }

                    if (!empty($evaluations)):
                        foreach ($evaluations as $type => $records): ?>
                            <h6 class="mt-4 text-primary"><?= $type ?: 'Unspecified Type' ?></h6>
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Score</th>
                                        <th>Comments</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $eval): ?>
                                        <tr>
                                            <td><?= $eval['Score'] ?></td>
                                            <td><?= $eval['Comments'] ?: 'No comment' ?></td>
                                            <td><?= date('F j, Y', strtotime($eval['EvaluationDate'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                    <?php endforeach; else: ?>
                        <p>No evaluations found.</p>
                    <?php endif;

                    $stmt->close();
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // AJAX polling to check for new evaluations
    function checkNewEvaluation() {
        $.ajax({
            url: 'check_new_eval.php', // A PHP file to check for new evaluation
            method: 'GET',
            success: function(response) {
                if (response === 'new') {
                    // Show notification if new evaluation exists
                    $('#notification').fadeIn().delay(5000).fadeOut();
                }
            }
        });
    }

    // Poll every 30 seconds
    setInterval(checkNewEvaluation, 30000);
</script>

</body>
</html>

