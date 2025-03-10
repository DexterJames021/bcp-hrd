<!-- training main dashboard -->
<!-- <?php
session_start();

require('../../config/Database.php');

$recordsPerPage = 10;

// Get the current page number from URL parameter, default is 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting record for the SQL query
$startFrom = ($page - 1) * $recordsPerPage;

// Handle form submission to update status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_status']) && isset($_POST['leave_id'])) {
        $leaveId = $_POST['leave_id'];
        $newStatus = $_POST['update_status'];

        // Prepare the SQL query to update the status
        $stmt = $conn->prepare("UPDATE leaveapplication SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $newStatus);
        $stmt->bindParam(':id', $leaveId);

        try {
            $stmt->execute();
            echo "<script>alert('Status updated successfully');</script>"; // Optional: Alert for success
        } catch (PDOException $e) {
            echo "<script>alert('Error updating status: " . $e->getMessage() . "');</script>";
        }
    }
}

// Fetch data from the database (pagination and sorting already applied)
try {
    $stmt = $conn->prepare("SELECT id, employeeId, name, leave_type, date, message, status FROM leaveapplication ORDER BY FIELD(status, 'pending') DESC, id ASC LIMIT :startFrom, :recordsPerPage");
    $stmt->bindParam(':startFrom', $startFrom, PDO::PARAM_INT);
    $stmt->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $benefitData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of records to calculate the number of pages
    $totalStmt = $conn->prepare("SELECT COUNT(*) FROM leaveapplication");
    $totalStmt->execute();
    $totalRecords = $totalStmt->fetchColumn();
    $totalPages = ceil($totalRecords / $recordsPerPage);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

//delete button
// Check if the delete request is made
if (isset($_POST['delete_leave'])) {
    $leaveId = $_POST['leave_id'];  // Get the leave ID to be deleted

    try {
        // Prepare and execute the DELETE query
        $deleteStmt = $conn->prepare("DELETE FROM leaveapplication WHERE id = :leaveId");
        $deleteStmt->bindParam(':leaveId', $leaveId, PDO::PARAM_INT);
        $deleteStmt->execute();

        // Redirect back to the same page (or show a success message)
        header("Location: leave.php");  // Replace 'your_page.php' with the actual page URL
        exit();

    } catch (PDOException $e) {
        // Handle any errors
        die("Error deleting record: " . $e->getMessage());
    }
}



?> -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- icon -->
    <link rel="shortcut icon" href="../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

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
    <link rel="stylesheet" href="css/leave.css">
    <title>Admin Dashboard</title>
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
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
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
                            <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span
                                    class="indicator"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                    <div class="notification-title"> Notification</div>
                                    <div class="notification-list">
                                        <div class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action active">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">Jeremy
                                                            Rakestraw</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">John Abraham </span>is
                                                        now following you
                                                        <div class="notification-date">2 days ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">Monaan Pechi</span> is
                                                        watching your main repository
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">Jessica
                                                            Caruso</span>accepted your invitation to join the team.
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
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="#" alt=""
                                    class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                                aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name"> <?= $_SESSION['username'] ?> </h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="../../auth/logout.php">">
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
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-1" aria-controls="submenu-1"><i
                                        class="fa fa-fw fa-user-circle"></i>Selection and Recuitment <span
                                        class="badge badge-success">6</span></a>
                                <div id="submenu-1" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module <span
                                                    class="badge badge-secondary">New</span></a>
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
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-2" aria-controls="submenu-2"><i
                                        class="fa fa-fw fa-rocket"></i>Talent Management</a>
                                <div id="submenu-2" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/cards.html">Cards <span
                                                    class="badge badge-secondary">New</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/general.html">General</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/carousel.html">Carousel</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/listgroup.html">Group</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/typography.html">Typography</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/accordions.html">Accordions</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/tabs.html">Tabs</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Tech & Analytics -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-3" aria-controls="submenu-3"><i
                                        class="fas fa-fw fa-chart-pie"></i> Tech & Analytics</a>
                                <div id="submenu-3" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module <span
                                                    class="badge badge-secondary">New</span></a>
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
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-4" aria-controls="submenu-4"><i
                                        class="fab fa-fw fa-wpforms"></i>Document and Legal</a>
                                <div id="submenu-4" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module <span
                                                    class="badge badge-secondary">New</span></a>
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
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-5" aria-controls="submenu-5"><i
                                        class="fas fa-fw fa-table"></i>Performance</a>
                                <div id="submenu-5" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module <span
                                                    class="badge badge-secondary">New</span></a>
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
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-6" aria-controls="submenu-6"><i
                                        class="fas fa-fw fa-columns"></i>Talent management</a>
                                <div id="submenu-6" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">module <span
                                                    class="badge badge-secondary">New</span></a>
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
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-7" aria-controls="submenu-7"><i
                                        class="fas fa-f fa-folder"></i>Compensation & benefits</a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="index.php">Attendance <span
                                                    class="badge badge-secondary">New</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="schedule.php">Rates</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="payroll.php">Payroll</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="leave.php">Leave</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="benefits.php">Benefits</a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            <li class="nav-divider">
                                Features
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="" aria-expanded="false" data-target="#submenu-8"
                                    aria-controls="submenu-8">
                                    <i class="fas fa-fw fa-file"></i> Task-management </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-8" aria-controls="submenu-8"><i
                                        class="fa fa-fw fa-user-circle"></i>Dropdown <span
                                        class="badge badge-success">6</span></a>
                                <div id="submenu-8" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                                data-target="#submenu-8-2" aria-controls="submenu-8-2">Lorem, ipsum.</a>
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
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                                data-target="#submenu-8-1" aria-controls="submenu-8-1">Lorem, ipsum
                                                dolor.</a>
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
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Dashboard</h2>

                            <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel
                                mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                        </li>
                                        <!-- <li class="breadcrumb-item active" aria-current="page">Dashboard</li> -->
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader  -->
                <!-- ============================================================== -->
                <!-- <div class="ecommerce-widget"> -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted">Contents</h5>

                                <h1>Leave Applications</h1>

                               <!-- Start of Table -->
                               <table style="width: 100%; max-width: 1500px; border-collapse: collapse;">
    <thead>
        <tr>
            <th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">ID</th>
            <th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Employee ID</th>
            <th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Name</th>
            <th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Leave</th>
            <th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Date</th>
            <th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Message</th>
            <th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Status</th>
            <th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Check if we have any records
        if (!empty($benefitData)) {
            // Loop through the data and display each row
            foreach ($benefitData as $row) {
                // Determine the status and its corresponding CSS class
                $statusClass = '';
                if ($row['status'] == 'pending') {
                    $statusClass = 'status-pending';
                } elseif ($row['status'] == 'accepted') {
                    $statusClass = 'status-accepted';
                } elseif ($row['status'] == 'denied') {
                    $statusClass = 'status-denied';
                }
            
                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['employeeId']) . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['leave_type']) . "</td>
                        <td>" . htmlspecialchars($row['date']) . "</td>
                        <td>" . htmlspecialchars($row['message']) . "</td>
                        <td><span class='status-text $statusClass'>" . htmlspecialchars($row['status']) . "</span></td>
                        <td>";
            
                // Only show buttons if the status is 'pending'
                if ($row['status'] == 'pending') {
                    echo "<form method='POST' action=''>
                            <input type='hidden' name='leave_id' value='" . htmlspecialchars($row['id']) . "' />
                            <button type='submit' name='update_status' value='accepted' style='background-color: #3d405c; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; margin-right: 5px;'>Accept</button>
                          </form>
                          <form method='POST' action=''>
                            <input type='hidden' name='leave_id' value='" . htmlspecialchars($row['id']) . "' />
                            <button type='submit' name='update_status' value='denied' style='background-color: #d9534f; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;'>Decline</button>
                          </form>";
                } else {
                    // Show delete button for accepted or denied statuses
                    echo "<form method='POST' action=''>
                            <input type='hidden' name='leave_id' value='" . htmlspecialchars($row['id']) . "' />
                            <a href='benefits.php?deleteId=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
                            <button type='submit' name='delete_leave' value='delete' style='background-color:rgb(167, 78, 75); color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;'>Delete</button>
                          </form>";
                }
                
                echo "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- End of Table -->
        


<!-- Pagination Links -->
<div style="text-align: center; margin-top: 20px;">
    <ul style="list-style-type: none; padding: 0;">
        <?php if ($page > 1): ?>
            <li style="display: inline; margin-right: 10px;">
                <a href="?page=<?= $page - 1 ?>" style="text-decoration: none; background-color: #3d405c; color: white; padding: 8px 16px; border-radius: 4px;">Previous</a>
            </li>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li style="display: inline; margin-right: 5px;">
                <a href="?page=<?= $i ?>" style="text-decoration: none; background-color: <?= $i == $page ? '#3d405c' : '#f4f4f4'; ?>; color: <?= $i == $page ? 'white' : '#333'; ?>; padding: 8px 16px; border-radius: 4px;"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <li style="display: inline; margin-left: 10px;">
                <a href="?page=<?= $page + 1 ?>" style="text-decoration: none; background-color: #3d405c; color: white; padding: 8px 16px; border-radius: 4px;">Next</a>
            </li>
        <?php endif; ?>
    </ul>
</div>
<!-- End of Pagination -->
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

    <script>
    // Function to open the modal and set the leave ID to be deleted
    function openModal(leaveId) {
        // Set the value of the hidden input in the form to the leave ID
        document.getElementById('leave_id_to_delete').value = leaveId;
        
        // Open the modal
        $('#confirmationModal').modal('show');
    }
</script>
</body>

</html>