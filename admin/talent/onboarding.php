<!-- training main dashboard -->
<?php
session_start();
require "../../config/db_talent.php";

// Fetch the count of training assignments
$assignment_count = 0;
$sql = "SELECT COUNT(*) AS count FROM training_assignments";
if ($result = $conn->query($sql)) {
    $row = $result->fetch_assoc();
    $assignment_count = $row['count'];
}
// Assuming you have an active database connection $conn
$query = "SELECT COUNT(*) AS total_users FROM users";
$result = mysqli_query($conn, $query);

if ($result) {
    $user_count = mysqli_fetch_assoc($result)['total_users'];
} else {
    // Handle the error if the query fails
    $user_count = 0;
}

// Assuming you have a connection to your database already set up
$sql = "SELECT COUNT(*) AS count FROM employees";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$employee_count = $row['count'];

// Fetch the count of training sessions from the database
$sql = "SELECT COUNT(*) AS training_count FROM training_sessions";
$result = $conn->query($sql);

// Get the count value
$trainingCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $trainingCount = $row['training_count'];
}
// Fetch applicants with status 'Hired'
$hiredApplicants = [];
$query = "SELECT id, applicant_name FROM applicants WHERE status = 'Hired'";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $hiredApplicants[] = $row; // Add hired applicants to the array
    }
} else {
    $_SESSION['error_message'] = "Error fetching applicants: " . mysqli_error($conn);
}

// Fetch applicants who already have accounts
$existingApplicants = [];
$query = "SELECT applicant_id FROM users WHERE applicant_id IS NOT NULL";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $existingApplicants[] = $row['applicant_id']; // Store applicant_id of users who have accounts
    }
} else {
    $_SESSION['error_message'] = "Error fetching existing applicants: " . mysqli_error($conn);
}
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

    <!-- bs -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- jquery -->
    <script defer src="../../node_modules/jquery/dist/jquery.js"></script>

    <!-- global JavaScript -->
    <script defer type="module" src="../../assets/libs/js/global-script.js"></script>

    <!-- main js -->
    <script defer type="module" src="../../assets/libs/js/main-js.js"></script>
    <link rel="stylesheet" href="../../assets/libs/css/style.css">

    <!-- assts csss -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <!-- slimscroll js -->
    <script defer type="module" src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <title>Admin Onboarding</title>
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
                    <!-- Button to Open the Modal -->
<!-- Display messages -->
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['error_message']); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php unset($_SESSION['error_message']); // Clear the message after displaying it ?>
    </div>
<?php elseif (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['success_message']); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php unset($_SESSION['success_message']); // Clear the message after displaying it ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body"> 
                <h1>Onboarding</h1>

                <!-- Display error messages if any -->
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($_SESSION['error_message']); ?>
                        <?php unset($_SESSION['error_message']); // Clear the message after displaying ?>
                    </div>
                <?php endif; ?>
                <div class="d-flex justify-content-start gap-3">
                <div class="box p-3 rounded shadow-sm text-center" style="width: 200px;">
                    <!-- Icon inside the box -->
                    <div class="icon-box">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center w-100 mb-2" data-toggle="modal" data-target="#createAccountModal">
                        <i class="fas fa-plus mr-2"></i> Create Account
                    </button>
                    <div class="count">
                    <strong><?php echo $user_count; ?></strong> Users
                    </div>
                </div>

                <div class="box p-3 rounded shadow-sm text-center" style="width: 200px;">
                    <!-- Icon inside the box -->
                    <div class="icon-box">
                        <i class="fas fa-users"></i>
                    </div>
                    <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center w-100 mb-2" data-toggle="modal" data-target="#viewEmployeesModal">
                        <i class="fas fa-eye mr-2"></i> View Employees
                    </button>
                    <div class="count">
                        <strong><?php echo $employee_count; ?></strong> Employees
                    </div>
                </div>
                <!-- Add Training Button -->
                <div class="box p-3 rounded shadow-sm text-center" style="width: 200px;">
                    <!-- Icon inside the box -->
                    <div class="icon-box">
                    <i class="fas fa-graduation-cap"></i>

                    </div>
                    <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center w-100 mb-2" data-toggle="modal" data-target="#addTrainingModal">
                        <i class="fas fa-plus mr-2"></i> Add Training
                    </button>
                    <div class="count">
                        <strong><?php echo $trainingCount; ?></strong> Trainings
                    </div>
                </div>
                 <!-- Assign Training Box -->
                <div class="box p-3 rounded shadow-sm text-center" style="width: 200px;">
                    <div class="icon-box">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center w-100 mb-2" data-toggle="modal" data-target="#assignTrainingModal">
                        <i class="fas fa-plus mr-2"></i> Assign Training
                    </button>
                    <div class="count">
                        <!-- You can add a dynamic count here for the number of training assignments if needed -->
                        <strong><?php echo $assignment_count; ?></strong> Assignments
                    </div>
                </div>

            </div>        
                <hr>

<!-- Bootstrap Modal -->
<div class="modal fade" id="assignTrainingModal" tabindex="-1" role="dialog" aria-labelledby="assignTrainingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assignTrainingModalLabel">Assign Training</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="onboarding/assign_training.php" method="POST"> <!-- Adjust action URL as needed -->
        <div class="modal-body">
          <div class="form-group">
            <label for="training_id">Training ID</label>
            <select class="form-control" id="training_id" name="training_id" required>
              <option value="" disabled selected>Select Training</option>
              <?php
              // Fetch available trainings from the database
              $trainingSql = "SELECT training_id, training_name FROM training_sessions";
              $trainingResult = $conn->query($trainingSql);
              if ($trainingResult->num_rows > 0) {
                  while ($trainingRow = $trainingResult->fetch_assoc()) {
                      echo "<option value='" . $trainingRow['training_id'] . "'>" . htmlspecialchars($trainingRow['training_name']) . " </option>";
                  }
              } else {
                  echo "<option value='' disabled>No trainings available</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="employee_id">Employee ID</label>
            <select class="form-control" id="employee_id" name="employee_id" required>
              <option value="" disabled selected>Select Employee</option>
              <?php
              // Fetch available employees from the database
              $employeeSql = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) AS employee_name FROM employees";
              $employeeResult = $conn->query($employeeSql);
              if ($employeeResult->num_rows > 0) {
                  while ($employeeRow = $employeeResult->fetch_assoc()) {
                      echo "<option value='" . $employeeRow['EmployeeID'] . "'>" . htmlspecialchars($employeeRow['employee_name']) . " </option>";
                  }
              } else {
                  echo "<option value='' disabled>No employees available</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="completion_date">Completion Date</label>
            <input type="date" class="form-control" id="completion_date" name="completion_date">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Assign Training</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Training Modal -->
<div class="modal fade" id="addTrainingModal" tabindex="-1" role="dialog" aria-labelledby="addTrainingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTrainingModalLabel">Add Training</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="onboarding/add_training.php">
                <div class="modal-body">
                    <!-- Training Title -->
                    <div class="form-group">
                        <label for="training_title">Training Title</label>
                        <input type="text" name="training_title" id="training_title" class="form-control" required>
                    </div>
                    <!-- Training Description -->
                    <div class="form-group">
                        <label for="training_description">Description</label>
                        <textarea name="training_description" id="training_description" class="form-control" rows="4" required></textarea>
                    </div>
                    <!-- Trainer -->
                    <div class="form-group">
                        <label for="trainer">Trainer</label>
                        <input type="text" name="trainer" id="trainer" class="form-control" required>
                    </div>
                    <!-- Department (Optional or Required based on your use case) -->
                    <div class="form-group">
                        <label for="department">Department</label>
                        <select name="department" id="department" class="form-control" required>
                            <option value="">Select Department</option>
                            <!-- You can fetch departments from your DB -->
                            <?php
                            // Assuming you have a departments table
                            $result = $conn->query("SELECT DepartmentID, DepartmentName FROM departments");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['DepartmentID']}'>{$row['DepartmentName']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Optional: Training Materials -->
                    <div class="form-group">
                        <label for="training_materials">Training Materials (Optional)</label>
                        <textarea name="training_materials" id="training_materials" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Training</button>
                </div>
            </form>
        </div>
    </div>
</div>



                <h3>Users</h3>
                    <div class="custom-table-container">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="sticky-header">Username</th>
                                        <th class="sticky-header">User Type</th> <!-- Added user type column -->
                                        <th class="sticky-header">Applicant Name</th> <!-- Added applicant column -->
                                        <th class="sticky-header">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Assuming you have a query to fetch users from the database
                                    $sql = "SELECT u.id, u.username, u.usertype, a.applicant_name 
                                            FROM users u
                                            LEFT JOIN applicants a ON u.applicant_id = a.id";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['usertype']) . "</td>"; // Show user type (admin, employee, New Hire)
                                            echo "<td>" . htmlspecialchars($row['applicant_name'] ?? 'N/A') . "</td>"; // Show applicant name or 'N/A' if not linked
                                            echo "<td>
                                                    <button class='btn btn-warning btn-sm btn-action' 
                                                            data-toggle='modal' 
                                                            data-target='#editUserModal' 
                                                            data-id='" . $row['id'] . "' 
                                                            data-username='" . $row['username'] . "' 
                                                            data-usertype='" . $row['usertype'] . "'>Edit</button>
                                                    
                                                    <a href='onboarding/delete_user.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm btn-action' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
                                                </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No users found.</td></tr>"; // Adjusted colspan
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
<hr><br>
<h3>Employees</h3>
<div class="custom-table-container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="sticky-header">First Name</th>
                    <th class="sticky-header">Last Name</th>
                    <th class="sticky-header">Email</th>
                    <th class="sticky-header">Phone</th>
                    <th class="sticky-header">Status</th>
                    <th class="sticky-header">Username</th>
                    <th class="sticky-header">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to fetch employee data from the database
                $sql = "SELECT e.EmployeeID, e.FirstName, e.LastName, e.Email, e.Phone, e.Status, u.username 
                        FROM employees e
                        LEFT JOIN users u ON e.UserID = u.id"; // Join with users table to get username
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>
                                <button class='btn btn-warning btn-sm btn-action' 
                                        data-toggle='modal' 
                                        data-target='#editEmployeeModal' 
                                        data-id='" . $row['EmployeeID'] . "' 
                                        data-firstname='" . $row['FirstName'] . "' 
                                        data-lastname='" . $row['LastName'] . "' 
                                        data-email='" . $row['Email'] . "' 
                                        data-phone='" . $row['Phone'] . "' 
                                        data-status='" . $row['Status'] . "'
                                        data-status='" . $row['username'] . "'>Edit</button>
                                

                                <a href='onboarding/delete_employee.php?id=" . $row['EmployeeID'] . "' class='btn btn-danger btn-sm btn-action' onclick='return confirm(\"Are you sure you want to delete this employee?\");'>Delete</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No employees found.</td></tr>"; // Adjusted colspan
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<hr><br>
<h3>Training Sessions</h3>
<div class="custom-table-container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="sticky-header">Training Name</th>
                    <th class="sticky-header">Trainer</th> <!-- Added trainer column -->
                    <th class="sticky-header">Department</th> <!-- Added department column -->
                    <th class="sticky-header">Description</th> <!-- Added description column -->
                    <th class="sticky-header">Materials</th> <!-- Added materials column -->
                    <th class="sticky-header">Actions</th> <!-- Actions column -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Assuming you have a query to fetch training sessions from the database
                $sql = "SELECT training_id, training_name, training_description, trainer, department, training_materials, created_at 
                        FROM training_sessions";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['training_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['trainer']) . "</td>"; // Show trainer
                        echo "<td>" . htmlspecialchars($row['department']) . "</td>"; // Show department
                        echo "<td>" . htmlspecialchars($row['training_description']) . "</td>"; // Show description
                        echo "<td>" . htmlspecialchars($row['training_materials']) . "</td>"; // Show materials
                        echo "<td>
                                <button class='btn btn-warning btn-sm btn-action' 
                                        data-toggle='modal' 
                                        data-target='#editTrainingModal' 
                                        data-id='" . $row['training_id'] . "' 
                                        data-training_name='" . $row['training_name'] . "' 
                                        data-trainer='" . $row['trainer'] . "' 
                                        data-department='" . $row['department'] . "' 
                                        data-training_description='" . $row['training_description'] . "' 
                                        data-training_materials='" . $row['training_materials'] . "'>Edit</button>
                                
                                <a href='onboarding/delete_training.php?id=" . $row['training_id'] . "' class='btn btn-danger btn-sm btn-action' onclick='return confirm(\"Are you sure you want to delete this training?\");'>Delete</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No training sessions found.</td></tr>"; // Adjusted colspan
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<hr><br>
<h3>Training Assignments</h3>
<div class="custom-table-container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="sticky-header">Employee Name</th>
                    <th class="sticky-header">Training Title</th>
                    <th class="sticky-header">Status</th>
                    <th class="sticky-header">Completion Date</th>
                    <th class="sticky-header">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to fetch training assignment data from the database
                $sql = "SELECT ta.assignment_id, e.FirstName, e.LastName, tr.training_name, ta.status, ta.completion_date
                        FROM training_assignments ta
                        JOIN employees e ON ta.employee_id = e.EmployeeID
                        JOIN training_sessions tr ON ta.training_id = tr.training_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['FirstName']) . " " . htmlspecialchars($row['LastName']) . "</td>"; // Employee Name
                        echo "<td>" . htmlspecialchars($row['training_name']) . "</td>"; // Training Title
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>"; // Status
                        $completion_date = $row['completion_date'] ? date('M d, Y', strtotime($row['completion_date'])) : 'N/A'; // Format: Nov 31, 2020

                        echo "<td>" . htmlspecialchars($completion_date) . "</td>"; // Completion Date formatted
                        echo "<td>
                                <button class='btn btn-warning btn-sm btn-action' 
                                        data-toggle='modal' 
                                        data-target='#editAssignmentModal' 
                                        data-id='" . $row['assignment_id'] . "' 
                                        data-status='" . $row['status'] . "'>Edit</button>
                                <a href='onboarding/delete_training_assignment.php?id=" . $row['assignment_id'] . "' class='btn btn-danger btn-sm btn-action' onclick='return confirm(\"Are you sure you want to delete this assignment?\");'>Delete</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No training assignments found.</td></tr>"; // Adjusted colspan for 5 columns
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<hr><br>




                <!-- The Modal -->
<div class="modal fade" id="createAccountModal" tabindex="-1" role="dialog" aria-labelledby="createAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAccountModalLabel">Create Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="onboarding/create_account.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="applicant_id">Select Applicant</label>
                        <select class="form-control" id="applicant_id" name="applicant_id" required>
                            <option value="">Select an Applicant</option>
                            <?php foreach ($hiredApplicants as $applicant): ?>
                                <?php 
                                    // Check if the applicant already has an account
                                    if (in_array($applicant['id'], $existingApplicants)) {
                                        continue; // Skip applicants who already have an account
                                    }
                                ?>
                                <option value="<?php echo $applicant['id']; ?>">
                                    <?php echo htmlspecialchars($applicant['applicant_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="usertype">User Type</label>
                        <select class="form-control" id="usertype" name="usertype" required>
                            <option value="">Select User Type</option>
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                            <option value="New Hire">New Hire</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Include Bootstrap JS and jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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