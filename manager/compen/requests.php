<?php
session_start();

if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'manager') {
    // You can add a message for the logged-in manager here
 
} else {
    // Redirect to login page if the user is not a manager
    header("Location: ../auth/index.php");
    exit; // Always call exit to stop further code execution
}
require('../config/Database.php');

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

        try {
            // Ensure session is valid
            if (!isset($_SESSION['user_id'])) {
                throw new Exception("Session expired or user not logged in.");
            }

            $sessionUserId = $_SESSION['user_id'];

            // Get the session user's applicant_name to use as 'head'
            $headStmt = $conn->prepare("
                SELECT a.applicant_name
                FROM users u
                LEFT JOIN applicants a ON u.applicant_id = a.id
                WHERE u.id = :sessionUserId
            ");
            $headStmt->bindParam(':sessionUserId', $sessionUserId, PDO::PARAM_INT);
            $headStmt->execute();
            $headData = $headStmt->fetch(PDO::FETCH_ASSOC);

            if (!$headData || empty($headData['applicant_name'])) {
                throw new Exception("Could not fetch session user name to use as head.");
            }

            $head = $headData['applicant_name']; // ✅ this will go into the head column

            if ($newStatus === 'accepted') {
                // Fetch the leave application data
                $selectStmt = $conn->prepare("
                    SELECT 
                        l.*, 
                        d.DepartmentName
                    FROM leaveapplication l
                    LEFT JOIN users u ON l.employeeId = u.id
                    LEFT JOIN applicants a ON u.applicant_id = a.id
                    LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID
                    WHERE l.id = :id
                ");
                $selectStmt->bindParam(':id', $leaveId, PDO::PARAM_INT);
                $selectStmt->execute();
                $leaveData = $selectStmt->fetch(PDO::FETCH_ASSOC);

                if ($leaveData) {
                    // Insert into leave_requests table using session user's name as head
                    $insertStmt = $conn->prepare("
                        INSERT INTO leave_requests (employeeId, name, leave_type, date, department, message, head) 
                        VALUES (:employeeId, :name, :leaveType, :date, :department, :message, :head)
                    ");
                    $insertStmt->bindParam(':employeeId', $leaveData['employeeId']);
                    $insertStmt->bindParam(':name', $leaveData['name']);
                    $insertStmt->bindParam(':leaveType', $leaveData['leave_type']);
                    $insertStmt->bindParam(':date', $leaveData['date']);
                    $insertStmt->bindParam(':department', $leaveData['DepartmentName']);
                    $insertStmt->bindParam(':message', $leaveData['message']);
                    $insertStmt->bindParam(':head', $head); // ✅ session user's applicant_name
                    $insertStmt->execute();

                    // Delete from leaveapplication
                    $deleteStmt = $conn->prepare("DELETE FROM leaveapplication WHERE id = :id");
                    $deleteStmt->bindParam(':id', $leaveId, PDO::PARAM_INT);
                    $deleteStmt->execute();

                    echo "<script>alert('Leave accepted and moved to leave_requests table');</script>";
                } else {
                    echo "<script>alert('Leave request not found.');</script>";
                }

            } elseif ($newStatus === 'denied') {
                // Update status to denied
                $updateStmt = $conn->prepare("UPDATE leaveapplication SET status = 'denied' WHERE id = :id");
                $updateStmt->bindParam(':id', $leaveId, PDO::PARAM_INT);
                $updateStmt->execute();

                echo "<script>alert('Leave request denied');</script>";
            }

        } catch (PDOException $e) {
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}
// Fetch data from the database (pagination and sorting already applied)
try {
    $userId = $_SESSION['user_id'];

    // Step 1: Get the department name of the logged-in user
    $stmtDept = $conn->prepare("
        SELECT d.DepartmentName 
        FROM users u
        LEFT JOIN applicants a ON u.applicant_id = a.id
        LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID
        WHERE u.id = :userId
    ");
    $stmtDept->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmtDept->execute();
    $result = $stmtDept->fetch(PDO::FETCH_ASSOC);

    if (!$result || empty($result['DepartmentName'])) {
        throw new Exception("Unable to find department for this user.");
    }

    $department = $result['DepartmentName'];

    // Step 2: Fetch leave applications for users in the same department
    $stmt = $conn->prepare("
        SELECT 
            l.id, 
            l.employeeId, 
            l.name, 
            l.leave_type, 
            l.date, 
            l.department, 
            l.message, 
            l.status 
        FROM leaveapplication l
        WHERE l.department = :department
        ORDER BY FIELD(l.status, 'pending') DESC, l.id ASC
        LIMIT :startFrom, :recordsPerPage
    ");


$stmt->bindParam(':department', $department, PDO::PARAM_STR);
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


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- icon -->
    <link rel="shortcut icon" href="../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- ajax -->
    <script defer src="../node_modules/jquery/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- global JavaScript -->
    <script defer type="module" src="../assets/libs/js/global-script.js"></script>

    <!-- main js -->
    <script defer type="module" src="../assets/libs/js/main-js.js"></script>
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <!-- <link rel="stylesheet" href="css/leave2.css"> -->

    <!-- assts csss -->
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Bootstrap Example</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- slimscroll js -->
    <script defer type="module" src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

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
            <nav class="navbar navbar-expand-lg bg-white fixed-top  ">
                <a class="navbar-brand" href="index.php">
                    <img src="../assets/images/bcp-hrd-logo.jpg" alt="" class="" style="height: 3rem;width: auto;">
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
                                                            Rakestraw</span>accepted your invitation to join the
                                                        team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">John Abraham
                                                        </span>is now following you
                                                        <div class="notification-date">2 days ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">Monaan Pechi</span>
                                                        is watching your main repository
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
                                <a class="dropdown-item" href="../auth/logout.php"><i
                                        class="fas fa-power-off mr-2"></i>Logout</a>
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
        <div class="nav-left-sidebar sidebar-white ">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Human Resource Dept.
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="index.php">
                                    <i class="fas fa-fw fa-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-1" aria-controls="submenu-1"><i
                                        class="fa fa-fw fa-user-circle"></i>employee <span
                                        class="badge badge-success">6</span></a>
                                <div id="submenu-1" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                                data-target="#submenu-1-2" aria-controls="submenu-1-2">Lorem, ipsum.</a>
                                            <div id="submenu-1-2" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="index.html">Lorem.</a>
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
                                            <a class="nav-link" href="./records-management/Records.php">Lorem, ipsum
                                                dolor.</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="dashboard-sales.html">Lorem, ipsum dolor.</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                                data-target="#submenu-1-1" aria-controls="submenu-1-1">Lorem, ipsum
                                                dolor.</a>
                                            <div id="submenu-1-1" class="collapse submenu">
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
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-8" aria-controls="submenu-8"><i
                                        class="fas fa-fw fa-columns"></i>Icons</a>
                                <div id="submenu-8" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-fontawesome.html">FontAwesome
                                                Icons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-material.html">Material Icons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-simple-lineicon.html">Simpleline
                                                Icon</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-themify.html">Themify Icon</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-flag.html">Flag Icons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-weather.html">Weather Icon</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-9" aria-controls="submenu-9"><i
                                        class="fas fa-fw fa-money-check-alt"></i>Compensation and Benefits</a>
                                <div id="submenu-9" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="leave.php">My Leave</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="request.php">Leave Requests</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="holiday.php">Holidays</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-10" aria-controls="submenu-10"><i
                                        class="fas fa-f fa-folder"></i>Menu Level</a>
                                <div id="submenu-10" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Level 1</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                                data-target="#submenu-11" aria-controls="submenu-11">Level 2</a>
                                            <div id="submenu-11" class="collapse submenu" style="">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="leave.php">Leave</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="holiday.php">Holidays</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Level 3</a>
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
                            <h2 class="pageheader-title">Leave </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                   <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        <div class="page">
                            <div class="apply">
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
<th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Department</th>
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
<td>" . htmlspecialchars($row['department']) . "</td>
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
                               
                            </div>
                        </div>
                        
                        </div>
                                        </div>
                    </div>
                </div>

                
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