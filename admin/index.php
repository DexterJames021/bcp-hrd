<?php
require __DIR__ . "../../config/db_talent.php";
require __DIR__ . '../../auth/mysqli_accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

// echo "console.log(ROOT +++++++++++ " . $_SERVER['DOCUMENT_ROOT'] . ")";


// Fetch total employees
$queryEmployees = "SELECT COUNT(*) AS total FROM employees";
$resultEmployees = mysqli_query($conn, $queryEmployees);
$totalEmployees = mysqli_fetch_assoc($resultEmployees)['total'];

// Fetch total applicants
$queryApplicants = "SELECT COUNT(*) AS total FROM applicants";
$resultApplicants = mysqli_query($conn, $queryApplicants);
$totalApplicants = mysqli_fetch_assoc($resultApplicants)['total'];

// Fetch total job postings
$queryJobPostings = "SELECT COUNT(*) AS total FROM job_postings";
$resultJobPostings = mysqli_query($conn, $queryJobPostings);
$totalJobPostings = mysqli_fetch_assoc($resultJobPostings)['total'];

// Fetch total hired employees
$queryHired = "SELECT COUNT(*) AS total FROM applicants WHERE status = 'Hired'";
$resultHired = mysqli_query($conn, $queryHired);
$totalHired = mysqli_fetch_assoc($resultHired)['total'];

// Fetch applicants per department
$queryApplicantsPerDept = "
    SELECT d.DepartmentName, COUNT(a.id) AS totalApplicants
    FROM applicants a
    LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID
    GROUP BY d.DepartmentName";
$resultApplicantsPerDept = mysqli_query($conn, $queryApplicantsPerDept);
$applicantsData = [];
while ($row = mysqli_fetch_assoc($resultApplicantsPerDept)) {
    $applicantsData[$row['DepartmentName']] = $row['totalApplicants'];
}

// Fetch employees per department
$queryEmployeesPerDept = "
    SELECT d.DepartmentName, COUNT(e.EmployeeID) AS totalEmployees
FROM employees e
LEFT JOIN users u ON e.UserID = u.id  -- Get the applicant ID through users table
LEFT JOIN applicants a ON u.applicant_id = a.id  -- Get the department through the applicant
LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID  -- Fetch department name
GROUP BY d.DepartmentName";

$resultEmployeesPerDept = mysqli_query($conn, $queryEmployeesPerDept);
$employeesData = [];
while ($row = mysqli_fetch_assoc($resultEmployeesPerDept)) {
    $employeesData[$row['DepartmentName']] = $row['totalEmployees'];
}

// Convert PHP arrays to JSON
$applicantsJSON = json_encode($applicantsData);
$employeesJSON = json_encode($employeesData);


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- icon -->
    <link rel="shortcut icon" href="../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- ajax -->
    <script defer src="../node_modules/jquery/dist/jquery.min.js"></script>

    <!-- bs -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- global JavaScript -->
    <!--  <script defer type="module" src="../assets/libs/js/global-script.js"></script> --> -->

    <!-- main js -->
    <script defer type="module" src="../assets/libs/js/main-js.js"></script>
    <link rel="stylesheet" href="../assets/libs/css/style.css">

    <!-- assts csss -->
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <script src="./main.js"></script>

    <!-- slimscroll js -->
    <script defer type="module" src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

    <title>Admin Dashboard</title>

    <style>
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #0e0c28;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.3s ease;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 15px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            font-size: 18px;
            color: white;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <body>
        <div id="loading-overlay">
            <div class="spinner"></div>
            <div class="loading-text">Loading Dashboard...</div>
        </div>

        <!-- Rest of your body content -->
        <div class="dashboard-main-wrapper" style="padding:0px;">
            <!-- ... -->
            <!-- ============================================================== -->
            <!-- main wrapper -->
            <!-- ============================================================== -->
            <div class="dashboard-main-wrapper">
                <!-- ============================================================== -->
                <!-- navbar -->
                <!-- ============================================================== -->
                <?php include 'sideandnavbar.php'; ?>
                <!-- ============================================================== -->
                <!-- end navbar -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- left sidebar -->

                <!-- ============================================================== -->
                <!-- end left sidebar -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- wrapper  -->
                <!-- ============================================================== -->
                <div class="dashboard-wrapper">
                    <!-- <div class="dashboard-ecommerce"> -->
                    <div class="container-fluid dashboard-content ">
                        <!-- ============================================================== -->
                        <!-- pageheader  -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- end pageheader  -->
                        <!-- ============================================================== -->
                        <!-- <div class="ecommerce-widget"> -->

                        <?php if ($userData && in_array("VIEW", $userData['permissions'])): ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h1>DASHBOARD</h1>

                                            <!-- Summary Cards -->
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="card bg-light text-white">
                                                        <div class="card-body">
                                                            <h5>Total Employees</h5>
                                                            <h3><?php echo $totalEmployees; ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-light text-white">
                                                        <div class="card-body">
                                                            <h5>Total Applicants</h5>
                                                            <h3><?php echo $totalApplicants; ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-light text-dark">
                                                        <div class="card-body">
                                                            <h5>Total Job Postings</h5>
                                                            <h3><?php echo $totalJobPostings; ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-light text-white">
                                                        <div class="card-body">
                                                            <h5>Total Hired</h5>
                                                            <h3><?php echo $totalHired; ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div> <!-- End of Card Body -->
                                    </div> <!-- End of Card -->

                                    <!-- Charts -->
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5>Applicants Per Job</h5>
                                                    <canvas id="applicantsChart" height="100" width="100"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5>Employees Per Department</h5>
                                                    <canvas id="departmentChart" height="100" width="100"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- End of Col-12 -->
                            </div> <!-- End of Row -->

                        <?php else: ?>
                            <?php include_once "./403.php"; ?>
                        <?php endif; ?>

                        <!-- Chart.js Library -->
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            // Convert PHP JSON to JavaScript Object
                            var applicantsData = <?php echo $applicantsJSON; ?>;
                            var employeesData = <?php echo $employeesJSON; ?>;

                            // Generate labels and data for charts
                            var applicantLabels = Object.keys(applicantsData);
                            var applicantCounts = Object.values(applicantsData);

                            var employeeLabels = Object.keys(employeesData);
                            var employeeCounts = Object.values(employeesData);

                            // Applicants per Department Chart
                            var ctx1 = document.getElementById('applicantsChart').getContext('2d');
                            var applicantsChart = new Chart(ctx1, {
                                type: 'bar',
                                data: {
                                    labels: applicantLabels,
                                    datasets: [{
                                        label: 'Applicants',
                                        data: applicantCounts,
                                        backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8']
                                    }]
                                }
                            });

                            // Employees per Department Chart
                            var ctx2 = document.getElementById('departmentChart').getContext('2d');
                            var departmentChart = new Chart(ctx2, {
                                type: 'pie',
                                data: {
                                    labels: employeeLabels,
                                    datasets: [{
                                        data: employeeCounts,
                                        backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8']
                                    }]
                                }
                            });
                        </script>

                    </div>
                </div>

    </body>

</html>