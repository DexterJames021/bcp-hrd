<!-- training main dashboard -->
<?php
session_start();


require_once('../../config/Database.php');

//benefit deduction
try {
    $stmt = $conn->prepare("SELECT id, type, amount FROM deduction");
    $stmt->execute();
    $benefitData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}

// Fetch existing benefits from the database
try {
    $stmt = $conn->prepare("SELECT id, type, amount FROM deduction");
    $stmt->execute();
    $benefitData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}

// Handle form submission for adding a new benefit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addBenefit'])) {
    try {
        // Add new benefit
        $benefitType = $_POST['benefitType'];
        $amount = $_POST['amount'];

        $stmt = $conn->prepare("INSERT INTO deduction (type, amount) VALUES (:type, :amount)");
        $stmt->bindParam(':type', $benefitType, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<script>alert('Benefit added successfully!'); window.location.href = 'benefits.php';</script>";
        } else {
            echo "<script>alert('Error adding benefit');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}

// Handle form submission for editing a benefit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editBenefit'])) {
    try {
        // Edit benefit
        $benefitId = $_POST['benefitId'];
        $benefitType = $_POST['benefitType'];
        $amount = $_POST['amount'];

        $stmt = $conn->prepare("UPDATE deduction SET type = :type, amount = :amount WHERE id = :id");
        $stmt->bindParam(':id', $benefitId, PDO::PARAM_INT);
        $stmt->bindParam(':type', $benefitType, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<script>alert('Benefit updated successfully!'); window.location.href = 'benefits.php';</script>";
        } else {
            echo "<script>alert('Error updating benefit');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}

// Handle deletion
if (isset($_GET['deleteId'])) {
    try {
        $deleteId = $_GET['deleteId'];
        $stmt = $conn->prepare("DELETE FROM deduction WHERE id = :id");
        $stmt->bindParam(':id', $deleteId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Benefit deleted successfully!'); window.location.href = 'benefits.php';</script>";
        } else {
            echo "<script>alert('Error deleting benefit');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}


// Fetch existing incentives from the database
try {
    $stmt = $conn->prepare("SELECT id, type, amount FROM incentives");
    $stmt->execute();
    $incentiveData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}

// Handle form submission for adding a new incentive
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addIncentive'])) {
    try {
        // Add new incentive
        $incentiveType = $_POST['incentiveType'];
        $amount = $_POST['amount'];

        $stmt = $conn->prepare("INSERT INTO incentives (type, amount) VALUES (:type, :amount)");
        $stmt->bindParam(':type', $incentiveType, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<script>alert('Incentive added successfully!'); window.location.href = 'benefits.php';</script>";
        } else {
            echo "<script>alert('Error adding incentive');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}

// Handle form submission for editing an incentive
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editIncentive'])) {
    try {
        // Edit incentive
        $incentiveId = $_POST['incentiveId'];
        $incentiveType = $_POST['incentiveType'];
        $amount = $_POST['amount'];

        $stmt = $conn->prepare("UPDATE incentives SET type = :type, amount = :amount WHERE id = :id");
        $stmt->bindParam(':id', $incentiveId, PDO::PARAM_INT);
        $stmt->bindParam(':type', $incentiveType, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<script>alert('Incentive updated successfully!'); window.location.href = 'benefits.php';</script>";
        } else {
            echo "<script>alert('Error updating incentive');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}

// Handle deletion
if (isset($_GET['deleteId'])) {
    try {
        $deleteId = $_GET['deleteId'];
        $stmt = $conn->prepare("DELETE FROM incentives WHERE id = :id");
        $stmt->bindParam(':id', $deleteId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Incentive deleted successfully!'); window.location.href = 'benefits.php';</script>";
        } else {
            echo "<script>alert('Error deleting incentive');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}

?>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/benefits.css">
    <script src="js/benefits.js"></script>



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
                                <a class="dropdown-item" href="../../auth/logout.php">
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
                                            <a class="nav-link" href="schedule.php">Schedule</a>
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
                                <h5 class="text-muted">Benefits</h5>



                                <!-- Table to Display Benefits -->
                                <table style="width: 100%; max-width: 1500px; border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th
                                                style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">
                                                Benefit Type</th>
                                            <th
                                                style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">
                                                Amount</th>
                                            <th
                                                style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Check if we have any records
                                        if (!empty($benefitData)) {
                                            // Loop through the data and display each row
                                            foreach ($benefitData as $row) {
                                                echo "<tr>
                    <td>" . htmlspecialchars($row['type']) . "</td>
                    <td>" . htmlspecialchars($row['amount']) . "</td>
                    <td>
                        <button onclick='openEditModal(" . $row['id'] . ", \"" . htmlspecialchars($row['type']) . "\", \"" . htmlspecialchars($row['amount']) . "\")' style='background-color: #3d405c; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; margin-right: 5px;'>Edit</button>
                        <a href='benefits.php?deleteId=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
                            <button style='background-color: #d9534f; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;'>Delete</button>
                        </a>
                    </td>
                </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='3'>No records found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <!-- Add Benefit Modal -->
                                <div id="addBenefitModal"
                                    style="display:none; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; justify-content: center; align-items: center;">
                                    <div
                                        style="background-color: white; padding: 20px; border-radius: 5px; max-width: 400px; width: 100%;">
                                        <h3>Add New Benefit</h3>
                                        <form method="POST" action="benefits.php">
                                            <label for="benefitType">Benefit Type:</label>
                                            <input type="text" name="benefitType" id="benefitType" required><br><br>

                                            <label for="amount">Amount:</label>
                                            <input type="number" name="amount" id="amount" step="0.01" required><br><br>

                                            <button type="submit" name="addBenefit"
                                                style="background-color: #3d405c; color: white; padding: 10px 20px; border: none; cursor: pointer;">Add
                                                Benefit</button>
                                            <button type="button" onclick="closeAddModal()"
                                                style="background-color: #d9534f; color: white; padding: 10px 20px; border: none; cursor: pointer;">Cancel</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Edit Benefit Modal -->
                                <div id="editBenefitModal"
                                    style="display:none; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; justify-content: center; align-items: center;">
                                    <div
                                        style="background-color: white; padding: 20px; border-radius: 5px; max-width: 400px; width: 100%;">
                                        <h3>Edit Benefit</h3>
                                        <form method="POST" action="benefits.php">
                                            <input type="hidden" name="benefitId" id="editBenefitId">
                                            <label for="editBenefitType">Benefit Type:</label>
                                            <input type="text" name="benefitType" id="editBenefitType" required><br><br>

                                            <label for="editAmount">Amount:</label>
                                            <input type="number" name="amount" id="editAmount" step="0.01"
                                                required><br><br>

                                            <button type="submit" name="editBenefit"
                                                style="background-color: #3d405c; color: white; padding: 10px 20px; border: none; cursor: pointer;">Update
                                                Benefit</button>
                                            <button type="button" onclick="closeEditModal()"
                                                style="background-color: #d9534f; color: white; padding: 10px 20px; border: none; cursor: pointer;">Cancel</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Button to open Add Modal -->
                                <button onclick="openAddModal()"
                                    style="background-color: #3d405c; color: white; padding: 10px 20px; border: none; cursor: pointer;">Add
                                    Benefit</button>

                                <script>
                                    // Open and Close Modals
                                    function openAddModal() {
                                        document.getElementById('addBenefitModal').style.display = 'flex';
                                    }

                                    function closeAddModal() {
                                        document.getElementById('addBenefitModal').style.display = 'none';
                                    }

                                    function openEditModal(id, type, amount) {
                                        document.getElementById('editBenefitId').value = id;
                                        document.getElementById('editBenefitType').value = type;
                                        document.getElementById('editAmount').value = amount;
                                        document.getElementById('editBenefitModal').style.display = 'flex';
                                    }

                                    function closeEditModal() {
                                        document.getElementById('editBenefitModal').style.display = 'none';
                                    }
                                </script>


                            </div>
                        </div>

                        <div class="card">
    <div class="card-body">
        <h5 class="text-muted">Incentives</h5>

        <!-- Table to Display Incentives -->
        <table style="width: 100%; max-width: 1500px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Incentive Type</th>
                    <th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Amount</th>
                    <th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($incentiveData)) {
                    foreach ($incentiveData as $row) {
                        echo "<tr>
                            <td>" . htmlspecialchars($row['type']) . "</td>
                            <td>" . htmlspecialchars($row['amount']) . "</td>
                            <td>
                                <button onclick='openEditModal(" . $row['id'] . ", \"" . htmlspecialchars($row['type']) . "\", \"" . htmlspecialchars($row['amount']) . "\")' style='background-color: #3d405c; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; margin-right: 5px;'>Edit</button>
                                <a href='benefits.php?deleteId=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
                                    <button style='background-color: #d9534f; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;'>Delete</button>
                                </a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Add Incentive Modal -->
        <div id="addIncentiveModal" style="display:none; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; justify-content: center; align-items: center;">
            <div style="background-color: white; padding: 20px; border-radius: 5px; max-width: 400px; width: 100%;">
                <h3>Add New Incentive</h3>
                <form method="POST" action="benefits.php">
                    <label for="incentiveType">Incentive Type:</label>
                    <input type="text" name="incentiveType" id="incentiveType" required><br><br>

                    <label for="amount">Amount:</label>
                    <input type="number" name="amount" id="amount" step="0.01" required><br><br>

                    <button type="submit" name="addIncentive" style="background-color: #3d405c; color: white; padding: 10px 20px; border: none; cursor: pointer;">Add Incentive</button>
                    <button type="button" onclick="closeAddModal()" style="background-color: #d9534f; color: white; padding: 10px 20px; border: none; cursor: pointer;">Cancel</button>
                </form>
            </div>
        </div>

        <!-- Edit Incentive Modal -->
        <div id="editIncentiveModal" style="display:none; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; justify-content: center; align-items: center;">
            <div style="background-color: white; padding: 20px; border-radius: 5px; max-width: 400px; width: 100%;">
                <h3>Edit Incentive</h3>
                <form method="POST" action="benefits.php">
                    <input type="hidden" name="incentiveId" id="editIncentiveId">
                    <label for="editIncentiveType">Incentive Type:</label>
                    <input type="text" name="incentiveType" id="editIncentiveType" required><br><br>

                    <label for="editAmount">Amount:</label>
                    <input type="number" name="amount" id="editAmount" step="0.01" required><br><br>

                    <button type="submit" name="editIncentive" style="background-color: #3d405c; color: white; padding: 10px 20px; border: none; cursor: pointer;">Update Incentive</button>
                    <button type="button" onclick="closeEditModal()" style="background-color: #d9534f; color: white; padding: 10px 20px; border: none; cursor: pointer;">Cancel</button>
                </form>
            </div>
        </div>

        <!-- Button to open Add Modal -->
        <button onclick="openAddModal()" style="background-color: #3d405c; color: white; padding: 10px 20px; border: none; cursor: pointer;">Add Incentive</button>

        <script>
            // Open and Close Modals
            function openAddModal() {
                document.getElementById('addIncentiveModal').style.display = 'flex';
            }

            function closeAddModal() {
                document.getElementById('addIncentiveModal').style.display = 'none';
            }

            function openEditModal(id, type, amount) {
                document.getElementById('editIncentiveId').value = id;
                document.getElementById('editIncentiveType').value = type;
                document.getElementById('editAmount').value = amount;
                document.getElementById('editIncentiveModal').style.display = 'flex';
            }

            function closeEditModal() {
                document.getElementById('editIncentiveModal').style.display = 'none';
            }
        </script>
    </div>
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