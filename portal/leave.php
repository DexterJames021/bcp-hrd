<?php
session_start();

//  if(isset($_SESSION['usertype']) && $_SESSION['usertype'] !='admin' ){ 
//     echo "<script> alert('welcome') </script>" ;  }else{  header("Location: ../auth/index.php");  } 

require('../config/Database.php');

try {
    // Query the leave types from the database
    $stmt = $conn->prepare("SELECT leave_type FROM leavetype");
    $stmt->execute();

    // Fetch all leave types
    $leaveTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
$messageFeedback = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Check required session data
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("User session data is incomplete.");
        }

        $userId = $_SESSION['user_id'];

        // Sanitize form input
        $leaveType = htmlspecialchars(trim($_POST['leaveType']));
        $leaveDate = htmlspecialchars(trim($_POST['dateInput']));
        $message = htmlspecialchars(trim($_POST['message']));

        // Validate inputs
        if (empty($leaveType) || empty($leaveDate) || empty($message)) {
            throw new Exception("All fields are required.");
        }

        // Fetch applicant_name and department from database using JOIN
        $stmtInfo = $conn->prepare("
            SELECT a.applicant_name, d.DepartmentName
            FROM users u
            LEFT JOIN applicants a ON u.applicant_id = a.id
            LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID
            WHERE u.id = :userId
        ");
        $stmtInfo->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmtInfo->execute();
        $result = $stmtInfo->fetch(PDO::FETCH_ASSOC);

        if (!$result || empty($result['applicant_name']) || empty($result['DepartmentName'])) {
            throw new Exception("Applicant or department information not found.");
        }

        $applicantName = $result['applicant_name'];
        $department = $result['DepartmentName'];

        // Insert leave application into database
        $stmt = $conn->prepare("
            INSERT INTO leaveapplication (employeeId, name, leave_type, date, department, message) 
            VALUES (:employeeId, :name, :leaveType, :leaveDate, :department, :message)
        ");

        $stmt->bindParam(':employeeId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $applicantName);
        $stmt->bindParam(':leaveType', $leaveType);
        $stmt->bindParam(':leaveDate', $leaveDate);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            $messageFeedback = "<p style='color:green;'>Leave request submitted successfully!</p>";
        } else {
            throw new Exception("Failed to submit the request.");
        }
    } catch (Exception $e) {
        $messageFeedback = "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}


// try {
//     // Query to get all records from the leaveapplication table for the specific user
//     $stmt = $conn->prepare("SELECT * FROM leaveapplication WHERE employeeId = :user_id");
//     $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
//     $stmt->execute();

//     // Fetch all results
//     $leaveApplications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// } catch (PDOException $e) {
//     die("Connection failed: " . $e->getMessage());
// }
$recordsPerPage = 5;  // Number of records per page

// Get the current page from the URL, if not set default to 1
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// Calculate offset for pagination
$offset = ($currentPage - 1) * $recordsPerPage;

try {
    // Get the logged-in user's ID
    $userId = $_SESSION['user_id'];

    // Fetch leave data from leaveapplication table
    $stmt1 = $conn->prepare("
        SELECT id, employeeId, name, leave_type, date, department, message, status
        FROM leaveapplication
        WHERE employeeId = :user_id
    ");
    $stmt1->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt1->execute();
    $leaveApplications = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    // Fetch leave data from leave_requests table
    $stmt2 = $conn->prepare("
        SELECT id, employeeId, name, leave_type, date, department, message, status
        FROM leave_requests
        WHERE employeeId = :user_id
    ");
    $stmt2->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt2->execute();
    $leaveRequests = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // Combine both datasets
    $allLeaveData = array_merge($leaveApplications, $leaveRequests);
    
    // Sort data by date in descending order
    usort($allLeaveData, function ($a, $b) {
        return strtotime($b['date']) <=> strtotime($a['date']);
    });

    // Pagination logic
    $totalRecords = count($allLeaveData);
    $totalPages = ceil($totalRecords / $recordsPerPage);
    $paginatedData = array_slice($allLeaveData, $offset, $recordsPerPage);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
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
    <link rel="stylesheet" href="css/leave2.css">

    <!-- assts csss -->
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

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
                                            <a class="nav-link" href="leave.php">Leave</a>
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
                        <div class="card">
                            <div class="card-body">
                        <div class="page-header">
                        </div>

                        <div class="page">
                            <div class="apply">
                                <h3>Apply for Leave</h3>

                                <?= $messageFeedback ?? '' ?>

                                <form method="POST" action="">
                                    <label for="leaveType">Leave Type</label><br>
                                    <select id="leaveType" name="leaveType" required>
                                        <option value="">Select Leave Type</option>
                                        <?php foreach ($leaveTypes as $leaveType): ?>
                                            <option value="<?= htmlspecialchars($leaveType['leave_type']) ?>">
                                                <?= htmlspecialchars($leaveType['leave_type']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select><br><br>

                                    <label for="dateInput">Leave Date</label><br>
                                    <input type="date" id="dateInput" name="dateInput" required><br><br>

                                    <label for="message">Leave Message</label><br>
                                    <input type="text" id="message" name="message" required><br><br>

                                    <button type="submit" id="applyLeaveBtn" class="apply-btn">Apply for Leave</button>
                                </form>
                            </div>
                        </div>
</div>
</div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="leaves">
                                    <h3>My Leaves</h3>
                                    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <thead>
        <tr>
            <?php if (!empty($allLeaveData)): ?>
                <?php foreach (array_keys($allLeaveData[0]) as $column): ?>
                    <th style="background-color: #3d405c; color: white; padding: 10px; text-align: left;">
                        <?= htmlspecialchars($column) ?>
                    </th>
                <?php endforeach; ?>
            <?php else: ?>
                <th colspan="8" style="padding: 10px; text-align: center;">No data available</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($allLeaveData)): ?>
            <?php foreach ($paginatedData as $application): ?>
                <tr>
                    <?php foreach ($application as $key => $value): ?>
                        <?php if ($key === 'status'): ?>
                            <td style="padding: 8px; border: 1px solid #ddd;">
                                <span style="
                                    display: inline-block;
                                    padding: 5px 10px;
                                    border-radius: 4px;
                                    font-weight: bold;
                                    border: 1px solid;
                                    color: <?php
                                        if ($value === 'pending')
                                            echo '#8a6d3b';
                                        elseif ($value === 'approved')
                                            echo 'white';
                                        elseif ($value === 'denied')
                                            echo 'white';
                                        else
                                            echo 'black';
                                    ?>;
                                    background-color: <?php
                                        if ($value === 'pending')
                                            echo '#f0ad4e';
                                        elseif ($value === 'approved')
                                            echo '#5cb85c';
                                        elseif ($value === 'denied')
                                            echo '#d9534f';
                                        else
                                            echo 'transparent';
                                    ?>;
                                    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
                                ">
                                    <?= htmlspecialchars($value) ?>
                                </span>
                            </td>
                        <?php else: ?>
                            <td style="padding: 8px; border: 1px solid #ddd;">
                                <?= htmlspecialchars($value) ?>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="padding: 10px; text-align: center;">
                    No records found.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Pagination Controls -->
<div style="margin-top: 20px; text-align: center;">
    <?php if ($totalPages > 1): ?>
        <!-- Previous Button -->
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1 ?>"
                style="padding: 8px 12px; border: 1px solid #3d405c; margin: 0 4px; text-decoration: none; color: #3d405c;">
                Previous
            </a>
        <?php endif; ?>

        <!-- Page Number Links -->
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>"
                style="padding: 8px 12px; border: 1px solid #3d405c; margin: 0 4px; text-decoration: none; color: <?= $currentPage === $i ? 'white' : '#3d405c'; ?>; background-color: <?= $currentPage === $i ? '#3d405c' : 'transparent'; ?>;">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <!-- Next Button -->
        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>"
                style="padding: 8px 12px; border: 1px solid #3d405c; margin: 0 4px; text-decoration: none; color: #3d405c;">
                Next
            </a>
        <?php endif; ?>
    <?php endif; ?>
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