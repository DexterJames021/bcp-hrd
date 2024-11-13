<?php
session_start();
require "../../config/db_talent.php";

// Fetch the total number of applicants
$applicant_query = "SELECT COUNT(*) AS totalApplicants FROM applicants";
$applicant_result = mysqli_query($conn, $applicant_query);
$applicant_count = 0;

if ($applicant_result) {
    $row = mysqli_fetch_assoc($applicant_result);
    $applicant_count = $row['totalApplicants'];
}

// Fetch the total number of job postings
$job_posting_query = "SELECT COUNT(*) AS job_posting_count FROM job_postings";
$job_posting_result = mysqli_query($conn, $job_posting_query);
$job_posting_count = 0;

// If job postings exist, fetch the count
if ($job_posting_result) {
    $row = mysqli_fetch_assoc($job_posting_result);
    $job_posting_count = $row['job_posting_count'];
}

// Fetch the total number of open job postings
$open_job_posting_query = "SELECT COUNT(*) AS open_job_posting_count FROM job_postings WHERE status = 'Open'";
$open_job_posting_result = mysqli_query($conn, $open_job_posting_query);
$open_job_posting_count = 0;

// If open job postings exist, fetch the count
if ($open_job_posting_result) {
    $row = mysqli_fetch_assoc($open_job_posting_result);
    $open_job_posting_count = $row['open_job_posting_count'];
}

// Fetch the total number of departments
$department_query = "SELECT COUNT(*) AS department_count FROM departments";
$department_result = mysqli_query($conn, $department_query);
$department_count = 0;

// If departments exist, fetch the count
if ($department_result) {
    $row = mysqli_fetch_assoc($department_result);
    $department_count = $row['department_count'];
}

// Updated SQL query to include department names
$sql = "SELECT jp.*, d.DepartmentName AS department_name 
FROM job_postings jp 
JOIN departments d ON jp.DepartmentID = d.DepartmentID";
$result = $conn->query($sql);

// Fetch departments for the dropdown
$department_sql = "SELECT DepartmentID, DepartmentName FROM departments";
$department_result = $conn->query($department_sql);
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- icon -->
    <link rel="shortcut icon" href="../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styledash6.css">

    <script defer src="../../node_modules/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap CSS and JS -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- jQuery -->
    <script defer src="../../node_modules/jquery/dist/jquery.js"></script>

    <!-- Global JavaScript -->
    <script defer type="module" src="../../assets/libs/js/global-script.js"></script>

    <!-- Main JS -->
    <script defer type="module" src="../../assets/libs/js/main-js.js"></script>
    <link rel="stylesheet" href="../../assets/libs/css/style.css">

    <!-- Assets CSS -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <!-- Slimscroll JS -->
    <script defer type="module" src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <title>Admin Recruitment</title>
    <script>
        // Function to automatically hide the alert after a few seconds
        function autoHideAlert() {
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.display = 'none'; // Hide the alert
                }, 5000); // Change 5000 to the number of milliseconds you want
            }
        }

        // Call the function on page load
        window.onload = autoHideAlert;
    </script>

</head>
<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header ">
            <nav class="navbar navbar-expand-lg bg-white fixed-top ">
                <a class="navbar-brand" href="index.php">
                    <img src="../../assets/images/bcp-hrd-logo.jpg" alt="" class="" style="height: 3rem;width: auto;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search..">
                            </div>
                        </li>
                        <li class="nav-item dropdown notification">
                            <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                    <div class="notification-title"> Notification</div>
                                    <div class="notification-list">
                                        <div class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action active">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jeremy Rakestraw</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">John Abraham </span>is now following you
                                                        <div class="notification-date">2 days ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Monaan Pechi</span> is watching your main repository
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jessica Caruso</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-footer"> <a href="#">View all notifications</a></div>
                                </li>
                            </ul>
                        </li>
                        <!-- <li class="nav-item dropdown connection">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-fw fa-th"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                                <li class="connection-list">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/github.png" alt="" > <span>Github</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/dribbble.png" alt="" > <span>Dribbble</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/dropbox.png" alt="" > <span>Dropbox</span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/bitbucket.png" alt=""> <span>Bitbucket</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/mail_chimp.png" alt="" ><span>Mail chimp</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/slack.png" alt="" > <span>Slack</span></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="conntection-footer"><a href="#">More</a></div>
                                </li>
                            </ul>
                        </li> -->
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="#" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name"> <?= $_SESSION['username'] ?> </h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="<?php include_once "../../auth/logout.php" ?>">
                                    <button class="btn btn-danger">
                                        <i class="fas fa-power-off mr-2"></i>
                                        Logout
                                    </button>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark ">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light overflow-scroll">
                    <!-- <a class="d-xl-none d-lg-none" href="#">Dashboard</a> -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Human Resource Dept.
                            </li>
                            <!-- main dashboard -->
                            <li class="nav-item ">
                                <a class="nav-link active" href="index.php">
                                    <i class="fas fa-fw fa-home"></i> Dashboard
                                </a>
                            </li>
                            <!-- Selection and Recuitment -->
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fa fa-fw fa-user-circle"></i>Selection and Recuitment <span class="badge badge-success">6</span></a>
                                <div id="submenu-1" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module <span class="badge badge-secondary">New</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                             <!-- Talent Management -->
                             <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fa fa-fw fa-rocket"></i>Talent Management</a>
                                <div id="submenu-2" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="index.php">Dashboard<span class="badge badge-secondary">New</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="recruitment.php">Recruitment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="onboarding.php">Onboarding</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="talent/talentretention.php">Talent Retention</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="talent/succession.php">Succession Planning</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="talent/career.php">Career Development</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="talent/performance.html">Performance Review</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Document and Legal -->
                            <!-- Tech & Analytics -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i> Tech & Analytics</a>
                                <div id="submenu-3" class="collapse submenu" style="">
                                <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module <span class="badge badge-secondary">New</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Document and Legal -->
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fab fa-fw fa-wpforms"></i>Document and Legal</a>
                                <div id="submenu-4" class="collapse submenu" style="">
                                <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module <span class="badge badge-secondary">New</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Performance -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-fw fa-table"></i>Performance</a>
                                <div id="submenu-5" class="collapse submenu" style="">
                                <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module <span class="badge badge-secondary">New</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Talent management -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-fw fa-columns"></i>Talent management</a>
                                <div id="submenu-6" class="collapse submenu" style="">
                                <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module <span class="badge badge-secondary">New</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Compensation & benefits -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-f fa-folder"></i>Compensation & benefits</a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module <span class="badge badge-secondary">New</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-divider">
                                Features
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8">
                                    <i class="fas fa-fw fa-file"></i> Task-management </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fa fa-fw fa-user-circle"></i>Dropdown <span class="badge badge-success">6</span></a>
                                <div id="submenu-8" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8-2" aria-controls="submenu-8-2">Lorem, ipsum.</a>
                                            <div id="submenu-8-2" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="">Lorem.</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">lorem1</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem.</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem.</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="">Lorem, ipsum dolor.</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="dashboard-sales.html">Lorem, ipsum dolor.</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8-1" aria-controls="submenu-8-1">Lorem, ipsum dolor.</a>
                                            <div id="submenu-8-1" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem, ipsum dolor.</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem, ipsum dolor.</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem, ipsum dolor.</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
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
                            < class="card-body">
                                <h1>Recruitment</h1>
                            
                                <!-- Overview Section -->
                                <div class="d-flex justify-content-start gap-3">

                                    <!-- Add Job Posting Box -->
                                    <div class="box p-3 rounded shadow-sm text-center" style="width: 200px;">
                                        <!-- Icon inside the box -->
                                        <div class="icon-box">
                                            <i class="fas fa-briefcase"></i>
                                        </div>
                                        <button class="btn btn-primary d-flex align-items-center justify-content-center w-100 mb-2" data-toggle="modal" data-target="#addJobModal">
                                            <i class="fas fa-plus mr-2"></i> Add Job
                                        </button>
                                        <div class="count">
                                            <strong><?php echo $job_posting_count; ?></strong> Jobs
                                        </div>
                                    </div>

                                    <!-- Add Department Box -->
                                    <div class="box p-3 rounded shadow-sm text-center" style="width: 200px;">
                                        <!-- Icon inside the box -->
                                        <div class="icon-box">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <button class="btn btn-primary d-flex align-items-center justify-content-center w-100 mb-2" data-toggle="modal" data-target="#addDepartmentModal">
                                            <i class="fas fa-plus mr-2"></i> Add Department
                                        </button>
                                        <div class="count">
                                            <strong><?php echo $department_count; ?></strong> Departments
                                        </div>
                                    </div>

                                    <!-- View Job Postings Box -->
                                    <div class="box p-3 rounded shadow-sm text-center" style="width: 200px;">
                                        <!-- Icon inside the box -->
                                        <div class="icon-box">
                                            <i class="fas fa-eye"></i>
                                        </div>
                                        <button class="btn btn-primary d-flex align-items-center justify-content-center w-100 mb-2" onclick="window.location.href='recruitment/job_listings.php'">
                                            <i class="fas fa-eye mr-2"></i> View Job Openings
                                        </button>
                                        <div class="count">
                                            <strong><?php echo $open_job_posting_count; ?></strong> Job Openings
                                        </div>
                                    </div>

                                    <!-- View Applicants Box (New) -->
                                    <div class="box p-3 rounded shadow-sm text-center" style="width: 200px;">
                                        <!-- Icon inside the box -->
                                        <div class="icon-box">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <button class="btn btn-primary d-flex align-items-center justify-content-center w-100 mb-2" onclick="window.location.href='#applicant'">
                                            <i class="fas fa-eye mr-2"></i> View Applicants
                                        </button>
                                        <div class="count">
                                            <strong><?php echo $applicant_count; ?></strong> Applicants
                                        </div>
                                    </div>

                                </div>
                            



                                <hr>
                                <?php if (isset($_SESSION['message'])): ?>
                                    <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                                        <?php 
                                        echo $_SESSION['message']; 
                                        unset($_SESSION['message']); // Clear the message after displaying
                                        ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>
                                <h3>Job Postings</h3>
                                    <div class="custom-table-container">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="sticky-header">Job Title</th>
                                                        <th class="sticky-header">Status</th>
                                                        <th class="sticky-header">Department</th>
                                                        <th class="sticky-header">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            // Fetch the count of applicants for the specific job ID
                                                            $jobId = $row['id'];
                                                            $applicantCountSql = "SELECT COUNT(*) as totalApplicants FROM applicants WHERE job_id = ?";
                                                            $stmt = $conn->prepare($applicantCountSql);
                                                            $stmt->bind_param("i", $jobId);
                                                            $stmt->execute();
                                                            $resultApplicants = $stmt->get_result();
                                                            $applicantCount = 0;

                                                            if ($resultApplicants->num_rows > 0) {
                                                                $countRow = $resultApplicants->fetch_assoc();
                                                                $applicantCount = $countRow['totalApplicants'];
                                                            }

                                                            echo "<tr>";
                                                            echo "<td>" . htmlspecialchars($row['job_title']) . "</td>";
                                                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                                            echo "<td>" . htmlspecialchars($row['department_name']) . "</td>";
                                                            echo "<td>
                                                                    <button class='btn btn-warning btn-sm btn-action' 
                                                                            data-toggle='modal' 
                                                                            data-target='#editJobModal' 
                                                                            data-id='" . htmlspecialchars($row['id']) . "' 
                                                                            data-title='" . htmlspecialchars($row['job_title']) . "' 
                                                                            data-description='" . htmlspecialchars($row['job_description']) . "' 
                                                                            data-requirements='" . htmlspecialchars($row['requirements']) . "' 
                                                                            data-location='" . htmlspecialchars($row['location']) . "' 
                                                                            data-salary='" . htmlspecialchars($row['salary_range']) . "' 
                                                                            data-status='" . htmlspecialchars($row['status']) . "'>Edit</button>
                                                                    
                                                                    <a href='recruitment/delete_job.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm btn-action' onclick='return confirm(\"Are you sure you want to delete this job posting?\");'>Delete</a>
                                                                    
                                                                    <a href='recruitment/manage_application.php?job_id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary btn-sm btn-action'>
                                                                        Applicant (" . $applicantCount . ")
                                                                    </a>
                                                                </td>";
                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='4'>No job postings found.</td></tr>"; // Adjusted colspan
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr><br>

                                    <h3>Departments</h3>
                                        <div class="custom-table-container">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="sticky-header">Department Name</th>
                                                            <th class="sticky-header">Manager</th> <!-- Added manager column -->
                                                            <th class="sticky-header">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // Assuming you have a query to fetch departments from the database
                                                        $sql = "SELECT d.DepartmentID, d.DepartmentName, e.FirstName AS Manager 
                                                                FROM departments d
                                                                LEFT JOIN employees e ON d.ManagerID = e.EmployeeID";
                                                        $result = $conn->query($sql);
                                                        
                                                        if ($result->num_rows > 0) {
                                                            while($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>" . htmlspecialchars($row['DepartmentName']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['Manager'] ?? 'No Manager') . "</td>"; // Show manager name or 'No Manager'
                                                                echo "<td>
                                                                        <button class='btn btn-warning btn-sm btn-action' 
                                                                                data-toggle='modal' 
                                                                                data-target='#editDepartmentModal' 
                                                                                data-id='" . $row['DepartmentID'] . "' 
                                                                                data-name='" . $row['DepartmentName'] . "' 
                                                                                data-manager='" . $row['Manager'] . "'>Edit</button>
                                                                        
                                                                        <a href='recruitment/delete_department.php?DepartmentID=" . $row['DepartmentID'] . "' class='btn btn-danger btn-sm btn-action' onclick='return confirm(\"Are you sure you want to delete this department?\");'>Delete</a>
                                                                
                                                                    
                                                                    </td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='3'>No departments found.</td></tr>"; // Adjusted colspan
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><hr><br>
                                        <section id="applicant">                 
                                        <h3>Applicants</h3>
                                        <div class="custom-table-container">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="sticky-header">Applicant Name</th>
                                                            <th class="sticky-header">Email</th>
                                                            <th class="sticky-header">Job Position</th>
                                                            <th class="sticky-header">Status</th>
                                                            <th class="sticky-header">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // Assuming you have a query to fetch applicants from the database
                                                        $sql = "SELECT a.id, a.applicant_name, a.email, j.job_title, a.status, 
                                                                    a.applied_at, a.interview_date, a.interview_time, d.DepartmentName
                                                                FROM applicants a
                                                                LEFT JOIN job_postings j ON a.job_id = j.id
                                                                LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID";
                                                        $result = $conn->query($sql);
                                                        
                                                        if ($result->num_rows > 0) {
                                                            while($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>" . htmlspecialchars($row['applicant_name']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['job_title']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                                            
                                                                echo "<td>
                                                                        <button class='btn btn-warning btn-sm btn-action' 
                                                                                data-toggle='modal' 
                                                                                data-target='#editApplicantModal' 
                                                                                data-id='" . $row['id'] . "' 
                                                                                data-name='" . $row['applicant_name'] . "' 
                                                                                data-email='" . $row['email'] . "' 
                                                                                data-job='" . $row['job_title'] . "' 
                                                                                data-status='" . $row['status'] . "' 
                                                                                data-applied='" . $row['applied_at'] . "' 
                                                                                data-interview-date='" . $row['interview_date'] . "' 
                                                                                data-interview-time='" . $row['interview_time'] . "'>Edit</button>
                                                                        
                                                                        <a href='recruitment/delete_applicant.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm btn-action' onclick='return confirm(\"Are you sure you want to delete this applicant?\");'>Delete</a>
                                                                    </td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='8'>No applicants found.</td></tr>"; // Adjusted colspan
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        </section>                           


<!-- Add Department Modal (You need to implement this modal in your HTML) -->
<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDepartmentModalLabel">Add Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="recruitment/add_department.php" method="POST">
                    <div class="form-group">
                        <label for="department_name">Department Name:</label>
                        <input type="text" class="form-control" id="department_name" name="department_name" required>
                    </div>
                    <div class="form-group">
                        <label for="manager_id">Manager ID: (OPTIONAL)</label>
                        <input type="text" class="form-control" id="manager_id" name="manager_id"> <!-- Removed required attribute -->
                    </div>
                    <button type="submit" class="btn btn-primary">Add Department</button>
                </form>
            </div>
        </div>
    </div>
</div>



                        <!-- Modal for displaying messages -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if (isset($_SESSION['success_message'])) {
                        echo $_SESSION['success_message'];
                        unset($_SESSION['success_message']); // Clear the message after displaying
                    } elseif (isset($_SESSION['error_message'])) {
                        echo $_SESSION['error_message'];
                        unset($_SESSION['error_message']); // Clear the message after displaying
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show the modal if there's a message
        window.onload = function() {
            <?php if (isset($_SESSION['success_message']) || isset($_SESSION['error_message'])): ?>
                var modal = new bootstrap.Modal(document.getElementById('messageModal'));
                modal.show();
            <?php endif; ?>
        }
    </script>

<!-- Add Job Posting Modal -->
<!-- Add Job Posting Modal -->
<div class="modal fade" id="addJobModal" tabindex="-1" role="dialog" aria-labelledby="addJobModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJobModalLabel">Add Job Posting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="recruitment/add_job.php" method="POST">
                    <div class="form-group">
                        <label for="job_title">Job Title:</label>
                        <input type="text" class="form-control" id="job_title" name="job_title" required>
                    </div>
                    <div class="form-group">
                        <label for="job_description">Job Description:</label>
                        <textarea class="form-control" id="job_description" name="job_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="requirements">Job Requirements:</label>
                        <textarea class="form-control" id="requirements" name="requirements" placeholder="Enter each requirement on a new line" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="form-group">
                        <label for="salary_range">Salary Range:</label>
                        <input type="text" class="form-control" id="salary_range" name="salary_range" placeholder="e.g. ₱30,000 - ₱50,000" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Open">Open</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="department_id">Department:</label>
                        <select class="form-control" id="department_id" name="DepartmentID" required>
                            <option value="">Select Department</option>
                            <?php
                            // Fetch departments for the dropdown
                            if ($department_result->num_rows > 0) {
                                while ($row = $department_result->fetch_assoc()) {
                                    echo "<option value='" . $row['DepartmentID'] . "'>" . $row['DepartmentName'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No departments available</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Job Posting</button>
                </form>
            </div>
        </div>
    </div>
</div>





<!-- Edit Job Modal -->
<div class="modal fade" id="editJobModal" tabindex="-1" role="dialog" aria-labelledby="editJobModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJobModalLabel">Edit Job Posting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="recruitment/edit_job.php" method="POST" id="editJobForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_job_id" name="job_id">
                    <div class="form-group">
                        <label for="edit_job_title">Job Title:</label>
                        <input type="text" class="form-control" id="edit_job_title" name="job_title" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_job_description">Job Description:</label>
                        <textarea class="form-control" id="edit_job_description" name="job_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_requirements">Job Requirements:</label>
                        <textarea class="form-control" id="edit_requirements" name="requirements" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_location">Location:</label>
                        <input type="text" class="form-control" id="edit_location" name="location" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_salary_range">Salary Range:</label>
                        <input type="text" class="form-control" id="edit_salary_range" name="salary_range" placeholder="e.g. ₱30,000 - ₱50,000" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status:</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="Open">Open</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Job Posting</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Populate edit modal with job details
    $('#editJobModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var jobId = button.data('id');
        var jobTitle = button.data('title');
        var jobDescription = button.data('description');
        var jobRequirements = button.data('requirements');
        var jobLocation = button.data('location');
        var jobSalary = button.data('salary');
        var jobStatus = button.data('status');

        // Update the modal's content.
        var modal = $(this);
        modal.find('#edit_job_id').val(jobId);
        modal.find('#edit_job_title').val(jobTitle);
        modal.find('#edit_job_description').val(jobDescription);
        modal.find('#edit_requirements').val(jobRequirements);
        modal.find('#edit_location').val(jobLocation);
        modal.find('#edit_salary_range').val(jobSalary);
        modal.find('#edit_status').val(jobStatus);
    });
</script>
                            </div>
                            <div id="sparkline-revenue"></div>
                        </div>
                    </div>
                </div>



                <!-- </div> -->
            </div>
            <!-- </div> -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <!-- <div class="footer mx-2">
                <div class="container-fluid mx-2">
                    <div class="row">
                        <div class="col-xl-7 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
</body>

</html>