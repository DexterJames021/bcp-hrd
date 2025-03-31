<?php
require "../../config/db_talent.php";
require '../../auth/mysqli_accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);


// Fetch total employees
$queryEmployees = "SELECT COUNT(*) AS total FROM employees";
$resultEmployees = mysqli_query($conn, $queryEmployees);
$totalEmployees = mysqli_fetch_assoc($resultEmployees)['total'];

// Fetch total applicants
$sql = "SELECT COUNT(*) AS pending_applicants FROM applicants WHERE status != 'Hired'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$pendingApplicants = $row['pending_applicants'];

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
    <title>Dashboard</title>
    <link rel="shortcut icon" href="../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styledash6.css">
    <link rel="stylesheet" href="../../assets/libs/css/style.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js (required for Bootstrap 4 for tooltips, popovers, modals, etc.) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

    <!-- Bootstrap JS (needed for Bootstrap components like modals, tooltips) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Bootstrap Bundle (includes Popper.js and Bootstrap JS) [Optional: Use this instead of both the previous JS scripts] -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> -->

    <!-- Custom JS -->
    <script defer type="module" src="../../assets/libs/js/global-script.js"></script>
    <script defer type="module" src="../../assets/libs/js/main-js.js"></script>

    <!-- Slimscroll JS (if needed) -->
    <script defer type="module" src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

</head>
<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <?php include '../sideandnavbar.php'; ?>
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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                        

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
                                                <h5>Pending Applicants</h5>
                                                <h3><?php echo $pendingApplicants; ?></h3>
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
                                        <h5>Applicants Per Department</h5>
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