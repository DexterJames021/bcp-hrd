<!-- training main dashboard -->
<!-- <?php
session_start();

require('../../config/Database.php');

// Initialize variables for displaying messages
$message = '';
$success = false;

try {
    // Handle form submission for adding new entry (Create)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['create'])) {
            $date = $_POST['date'];
            $min_salary = $_POST['min_salary'];
            $max_salary = $_POST['max_salary'];
            $position = $_POST['position'];

            // Insert new data into the database
            $stmt = $conn->prepare("INSERT INTO `average_rates` (`date`, `min_salary`, `max_salary`, `position`) VALUES (?, ?, ?, ?)");
            $stmt->execute([$date, $min_salary, $max_salary, $position]);

            $message = "Data added successfully!";
            $success = true;
        }

        // Handle form submission for updating entry (Update)
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $date = $_POST['date'];
            $min_salary = $_POST['min_salary'];
            $max_salary = $_POST['max_salary'];
            $position = $_POST['position'];

            // Update data in the database
            $stmt = $conn->prepare("UPDATE `average_rates` SET `date` = ?, `min_salary` = ?, `max_salary` = ?, `position` = ? WHERE `id` = ?");
            $stmt->execute([$date, $min_salary, $max_salary, $position, $id]);

            $message = "Data updated successfully!";
            $success = true;
        }

        // Handle form submission for deleting entry (Delete)
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];

            // Delete data from the database
            $stmt = $conn->prepare("DELETE FROM `average_rates` WHERE `id` = ?");
            $stmt->execute([$id]);

            $message = "Data deleted successfully!";
            $success = true;
        }
    }

    // Fetch all records for display (Read)
    $stmt = $conn->query("SELECT `id`, `date`, `min_salary`, `max_salary`, `position` FROM `average_rates`");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}



//salary data chart
try {
    // Database query to fetch data
    $stmt = $conn->query("SELECT `id`, `date`, `min_salary`, `max_salary`, `position` FROM `average_rates` WHERE 1");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for chart
    $dates = [];
    $min_salaries = [];
    $max_salaries = [];
    $positions = [];

    foreach ($data as $row) {
        $dates[] = $row['date'];
        $min_salaries[] = $row['min_salary'];
        $max_salaries[] = $row['max_salary'];
        $positions[] = $row['position']; // Store the position in the array
    }

    // Get unique positions for the dropdown
    $unique_positions = array_unique($positions);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
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
     <script defer src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
    <link rel="stylesheet" href="css/dashboard.css">
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
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="#" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name"> <?= $_SESSION['name'] ?> </h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="../../auth/logout.php"><i class="fas fa-power-off mr-2"></i>Logout</a>
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
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="index.php">Attendance <span
                                                    class="badge badge-secondary">New</span></a>
                                        </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="dashboard.php">Rates</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="payroll.php">Payroll</a>
                                        </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="leave.php">Leave</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="benefits.php">Benefits</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="index.php">Holidays</a>
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
                                <!-- <h5 class="text-muted">Salary Data</h5> -->

                                <!-- <h1 class="mb-1">Schedule</h1> -->

                                <h2>Salary Overview - Min & Max Salary Trends</h2>

                                <div class="form-group">
                                    <label for="positionSelect">Select Position:</label>
                                    <select id="positionSelect" class="form-control">
                                        <option value="">All Positions</option>
                                        <?php foreach ($unique_positions as $position): ?>
                                            <option value="<?= htmlspecialchars($position) ?>">
                                                <?= htmlspecialchars($position) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Chart Container -->
                                <div class="chart-container">
                                    <canvas id="salaryChart"></canvas>
                                </div>

                                <div class="footer">
                                    <p>&copy; 2025 Your Company. All rights reserved.</p>
                                </div>


                                <script>
                                    // Initial Data for the chart
                                    var allData = <?php echo json_encode($data); ?>;

                                    // Function to filter data based on selected position
                                    function filterData(position) {
                                        if (position === '') {
                                            return allData; // If no position is selected, return all data
                                        }
                                        return allData.filter(function (item) {
                                            return item.position === position;
                                        });
                                    }

                                    // Function to update the chart with filtered data
                                    function updateChart(position) {
                                        var filteredData = filterData(position);
                                        var dates = filteredData.map(function (item) { return item.date; });
                                        var minSalaries = filteredData.map(function (item) { return item.min_salary; });
                                        var maxSalaries = filteredData.map(function (item) { return item.max_salary; });

                                        salaryChart.data.labels = dates;
                                        salaryChart.data.datasets[0].data = minSalaries;
                                        salaryChart.data.datasets[1].data = maxSalaries;
                                        salaryChart.update();
                                    }

                                    // Initial chart setup
                                    var ctx = document.getElementById('salaryChart').getContext('2d');
                                    var salaryChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: <?php echo json_encode($dates); ?>, // Dates
                                            datasets: [{
                                                label: 'Min Salary',
                                                data: <?php echo json_encode($min_salaries); ?>, // Min Salary Data
                                                borderColor: '#4caf50', // Green for min salary
                                                backgroundColor: 'rgba(76, 175, 80, 0.2)',
                                                fill: true,
                                                tension: 0.4
                                            }, {
                                                label: 'Max Salary',
                                                data: <?php echo json_encode($max_salaries); ?>, // Max Salary Data
                                                borderColor: '#f44336', // Red for max salary
                                                backgroundColor: 'rgba(244, 67, 54, 0.2)',
                                                fill: true,
                                                tension: 0.4
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            interaction: {
                                                mode: 'index',
                                                intersect: false
                                            },
                                            scales: {
                                                x: {
                                                    title: {
                                                        display: true,
                                                        text: 'Date'
                                                    },
                                                    grid: {
                                                        display: false
                                                    }
                                                },
                                                y: {
                                                    title: {
                                                        display: true,
                                                        text: 'Salary (in USD)'
                                                    },
                                                    grid: {
                                                        color: '#ddd'
                                                    }
                                                }
                                            },
                                            plugins: {
                                                tooltip: {
                                                    backgroundColor: '#333',
                                                    titleColor: '#fff',
                                                    bodyColor: '#fff',
                                                    borderColor: '#4caf50',
                                                    borderWidth: 1,
                                                    padding: 10
                                                }
                                            }
                                        }
                                    });

                                    // Event listener to update chart when position is selected
                                    document.getElementById('positionSelect').addEventListener('change', function () {
                                        var selectedPosition = this.value;
                                        updateChart(selectedPosition);
                                    });
                                </script>

                                <!-- Bootstrap JS and dependencies -->
                                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                                <script
                                    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
                                <script
                                    src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>



                            </div>
                            <div id="sparkline-revenue"></div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                   
                                    
                                   
        <h2>Manage Average Rates</h2>

        <!-- Display messages (Success/Error) -->
        <?php if ($message): ?>
            <div class="alert alert-<?= $success ? 'success' : 'danger' ?>"><?= $message ?></div>
        <?php endif; ?>

        <!-- Form to Create or Update -->
        <form method="POST">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="min_salary">Min Salary</label>
                    <input type="number" id="min_salary" name="min_salary" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="max_salary">Max Salary</label>
                    <input type="number" id="max_salary" name="max_salary" class="form-control" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="position">Position</label>
                    <input type="text" id="position" name="position" class="form-control" required>
                </div>
            </div>

            <!-- Buttons for Create/Update -->
            <button type="submit" name="create" class="btn btn-primary">Add New Entry</button>
        </form>

        <hr>

        <!-- Table to display all records -->
        <h3>Existing Entries</h3>
        <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="color:black">Date</th>
                    <th style="color:black">Min Salary</th>
                    <th style="color:black">Max Salary</th>
                    <th style="color:black">Position</th>
                    <th style="color:black">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['date']) ?></td>
                        <td><?= htmlspecialchars($row['min_salary']) ?></td>
                        <td><?= htmlspecialchars($row['max_salary']) ?></td>
                        <td><?= htmlspecialchars($row['position']) ?></td>
                        <td>
                            <!-- Update Button (Triggers Modal) -->
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateModal" 
                                    data-id="<?= $row['id'] ?>" data-date="<?= $row['date'] ?>" 
                                    data-min_salary="<?= $row['min_salary'] ?>" data-max_salary="<?= $row['max_salary'] ?>" 
                                    data-position="<?= $row['position'] ?>">Edit</button>
                            
                            <!-- Delete Form -->
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this?');">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="updateId">
                        <div class="form-group">
                            <label for="updateDate">Date</label>
                            <input type="date" id="updateDate" name="date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="updateMinSalary">Min Salary</label>
                            <input type="number" id="updateMinSalary" name="min_salary" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="updateMaxSalary">Max Salary</label>
                            <input type="number" id="updateMaxSalary" name="max_salary" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="updatePosition">Position</label>
                            <input type="text" id="updatePosition" name="position" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fill in modal fields when editing an entry
        $('#updateModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var date = button.data('date');
            var min_salary = button.data('min_salary');
            var max_salary = button.data('max_salary');
            var position = button.data('position');

            $('#updateId').val(id);
            $('#updateDate').val(date);
            $('#updateMinSalary').val(min_salary);
            $('#updateMaxSalary').val(max_salary);
            $('#updatePosition').val(position);
        });
    </script>
                                </div>
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