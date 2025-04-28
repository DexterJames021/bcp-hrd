<?php
<<<<<<< HEAD
require('C:/xampp/htdocs/bcp-hrd/config/db_talent.php');



=======
require('../../config/db_talent.php');  
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04


// Step 2: Fetch basic statistics for the dashboard
$sqlEmployees = "SELECT COUNT(*) as totalEmployees FROM employees";
$resultEmployees = $conn->query($sqlEmployees);
$totalEmployees = $resultEmployees->fetch_assoc()['totalEmployees'];

$sqlEvaluations = "SELECT COUNT(*) as totalEvaluations FROM performanceevaluations";
$resultEvaluations = $conn->query($sqlEvaluations);
$totalEvaluations = $resultEvaluations->fetch_assoc()['totalEvaluations'];

$sqlRecentEvaluation = "SELECT * FROM performanceevaluations ORDER BY EvaluationDate DESC LIMIT 1";
$resultRecentEvaluation = $conn->query($sqlRecentEvaluation);
$recentEvaluation = $resultRecentEvaluation->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Performance Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #343a40;
            padding-top: 20px;
            overflow-y: auto;
            color: white;
        }

        .sidebar h4 {
            padding-left: 20px;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .sidebar a {
            padding: 12px 20px;
            display: block;
            color: #fff;
            text-decoration: none;
            transition: all 0.2s;
        }

        .sidebar a:hover {
            background-color: #495057;
            text-decoration: none;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }
        }
        .sidebar {
        height: 100vh;
    width: 250px;
    position: fixed;
    left: 0;
    top: 0;
    background-color: #0b0925; /* Updated color */
    padding-top: 20px;
    color: white;
}

.sidebar h4 {
    padding-left: 20px;
    color: white;
}

.sidebar a {
    padding: 10px 20px;
    display: block;
    color: white;
    text-decoration: none;
}

.sidebar a:hover {
    background-color: #1a173d; /* Slightly lighter for hover effect */
}

    </style>
</head>
<body>
    
<!-- Sidebar -->
<!-- Sidebar -->
<div class="sidebar">
    <h4>HRD Menu</h4>
    <a href="index.php">🏠 Main Dashboard</a>
    <a href="hays.php">👤 Employee Profile</a>
<<<<<<< HEAD
   
    <a href="view_evals.php">📝 Evaluations</a>
    <a href="eval.php">📋 Evaluation Result</a>
    <a href="../../auth/logout.php" style="color: #f8d7da;"><strong>🚪 Logout</strong></a>

=======
    <a href="managedep.php">🏢 Departments</a>
    <a href="view_evals.php">📝 Evaluations</a>
    <a href="eval.php">📋 Evaluation Result</a>
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
</div>


<!-- Main Content -->
<div class="main-content">
    <h2 class="mb-4">📊 Performance Dashboard</h2>

    <div class="row">
        <!-- Total Employees -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-header">Total Employees</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $totalEmployees; ?> Employees</h5>
                    <p class="card-text">Total number of employees in the system.</p>
                </div>
            </div>
        </div>

        <!-- Total Evaluations -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success">
                <div class="card-header">Total Evaluations</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $totalEvaluations; ?> Evaluations</h5>
                    <p class="card-text">Total number of performance evaluations submitted.</p>
                </div>
            </div>
        </div>

        <!-- Most Recent Evaluation -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-info">
                <div class="card-header">Most Recent Evaluation</div>
                <div class="card-body">
                    <?php if ($recentEvaluation): ?>
                        <h5 class="card-title"><?php echo $recentEvaluation['EvaluationDate']; ?></h5>
                        <p class="card-text">Employee ID: <?php echo $recentEvaluation['EmployeeID']; ?></p>
                        <p class="card-text"><strong>Score:</strong> <?php echo $recentEvaluation['Score']; ?></p>
                        <a href="view_evaluation.php?evaluation_id=<?php echo $recentEvaluation['EvaluationID']; ?>" class="btn btn-light btn-sm">View Details</a>
                    <?php else: ?>
                        <p class="card-text">No evaluations found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Links -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-secondary">
                <div class="card-body">
                    <h5 class="card-title">View Evaluations</h5>
                    <p class="card-text">Review submitted performance evaluation reports.</p>
                    <a href="view_evals.php" class="btn btn-secondary">View Evaluations</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-info">
                <div class="card-body">
                    <h5 class="card-title">Manage Departments</h5>
                    <p class="card-text">Add or update departments and their employees.</p>
                    <a href="managedep.php" class="btn btn-info">Manage Departments</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
