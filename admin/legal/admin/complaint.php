<?php
session_start();
include 'db_connection.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Handle update (if form is submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['complaint_id'])) {
    $complaint_id = $_POST['complaint_id'];
    $status = $_POST['status'];
    $response = $_POST['admin_response'];

    $update = $conn->prepare("UPDATE complaints SET status = ?, admin_response = ? WHERE id = ?");
    $update->bind_param("ssi", $status, $response, $complaint_id);
    $update->execute();
}

// Fetch all complaints with user info
$sql = "SELECT c.id, c.complaint_type, c.description, c.status, c.admin_response, c.submitted_at,
               u.first_name AS submitted_by_first, u.last_name AS submitted_by_last,
               e.first_name AS against_first, e.last_name AS against_last
        FROM complaints c
        LEFT JOIN users u ON c.submitted_by = u.id
        LEFT JOIN users e ON c.against_employee = e.id
        ORDER BY c.submitted_at DESC";

$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- icon -->
    <link rel="shortcut icon" href="../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <script defer src="../node_modules/jquery/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- global JavaScript -->
    <script defer type="module" src="../assets/libs/js/global-script.js"></script> 

    <!-- main js -->
    <script defer type="module" src="../assets/libs/js/main-js.js"></script>
    <link rel="stylesheet" href="../assets/libs/css/style.css">

    <!-- assts csss -->
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <!-- slimscroll js -->
    <script defer type="module" src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap & Styles -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <title>Admin - Complaints Management</title>
    <style>
        .container-mt-1 {
            margin: 40px auto;
            max-width: 1080px;
        }
        .document-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
        }
        .document-title {
            font-weight: bold;
            font-size: 1.1em;
        }
        .btn-group {
            margin-top: 10px;
        }
    </style>
</head>


<body>
    <div class="dashboard-main-wrapper">
        <div class="dashboard-header ">
            <nav class="navbar navbar-expand-lg bg-white fixed-top  ">
                <a class="navbar-brand" href="index.php">
                    <img src="../assets/images/bcp-hrd-logo.jpg" alt="" class="" style="height: 3rem;width: auto;">
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
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="#" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name"> <?= $_SESSION['username'] ?> </h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="../auth/logout.php"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="nav-left-sidebar sidebar-dark ">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Human Resource Dept.
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="index.php" >
                                    <i class="fas fa-fw fa-home"></i> Dashboard
                                </a>
                            </li>
                            <!-- Selection and Recuitment -->
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fa fa-fw fa-user-circle"></i>Selection and Recuitment <span class="badge badge-success">6</span></a>
                                <div id="submenu-1" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1-2" aria-controls="submenu-1-2">insert</a>
                                            <div id="submenu-1-2" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="index.html">insert</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">insert</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">insert</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">insert</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./records-management/Records.php">insert</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="dashboard-sales.html">insert</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1-1" aria-controls="submenu-1-1">insert</a>
                                            <div id="submenu-1-1" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">insert</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">insert</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">insert</a>
                                                    </li>
                                                </ul>
                                            </div>
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
                                            <a class="nav-link" href="pages/cards.html">Cards <span class="badge badge-secondary">New</span></a>
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
                            <!-- Document and Legal -->
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fab fa-fw fa-wpforms"></i>Legal and Documents</a>
                                <div id="submenu-3" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                    <li class="nav-item">
                                            <a class="nav-link" href="emanual.php">Employee's Manual</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="complaint.php">Complaints</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="loi.php">Letter of Intent</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="contract.php">Contracts</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Performance -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-fw fa-table"></i>Performance</a>
                                <div id="submenu-4" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/general-table.html">General Tables</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/data-tables.html">Data Tables</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Talent Management -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-fw fa-columns"></i>Talent management</a>
                                <div id="submenu-5" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/general-table.html">General Tables</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/data-tables.html">Data Tables</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Compensation & Benefits -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-f fa-folder"></i>Compensation & Benefits</a>
                                <div id="submenu-6" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/general-table.html">General Tables</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/data-tables.html">Data Tables</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Tech & Analytics -->
                            <li class="nav-item">
                                <a class="nav-link" href="./analytics/index.php" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-fw fa-chart-pie"></i> Tech & Analytics</a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="./analytics/index.php">C3 Charts</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-chartist.html">Chartist Charts</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-charts.html">Chart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-morris.html">Morris</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-sparkline.html">Sparkline</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-gauge.html">Guage</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-divider">
                                Features
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-fw fa-file"></i> Pages </a>
                                <div id="submenu-8" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/blank-page.html">Blank Page</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/blank-page-header.html">Blank Page Header</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/login.html">Login</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/404-page.html">404 page</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/sign-up.html">Sign up Page</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/forgot-password.html">Forgot Password</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/pricing.html">Pricing Tables</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/timeline.html">Timeline</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/calendar.html">Calendar</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/sortable-nestable-lists.html">Sortable/Nestable List</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/widgets.html">Widgets</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/media-object.html">Media Objects</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/cropper-image.html">Cropper</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/color-picker.html">Color Picker</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-9" aria-controls="submenu-9"><i class="fas fa-fw fa-inbox"></i>Apps <span class="badge badge-secondary">New</span></a>
                                <div id="submenu-9" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/inbox.html">Inbox</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/email-details.html">Email Detail</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/email-compose.html">Email Compose</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/message-chat.html">Message Chat</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
                 
        
        <div class="container mt-5">
    <div class="bg-primary p-4 rounded shadow-sm mb-4">
        <h2 class="text-white">Complaint Management Panel</h2>
        <p class="text-white mb-0">Manage and resolve employee complaints with care and confidentiality.</p>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th class="text-dark">Type</th>
                    <th class="text-dark">Description</th>
                    <th class="text-dark">Submitted By</th>
                    <th class="text-dark">Against</th>
                    <th class="text-dark">Status</th>
                    <th class="text-dark">Admin Response</th>
                    <th class="text-dark">Submitted At</th>
                    <th class="text-dark">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr class="table-light">
                        <form method="POST" action="">
                            <input type="hidden" name="complaint_id" value="<?= $row['id'] ?>">
                            <td><?= htmlspecialchars($row['complaint_type']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= htmlspecialchars($row['submitted_by_first'] . ' ' . $row['submitted_by_last']) ?></td>
                            <td><?= htmlspecialchars($row['against_first'] . ' ' . $row['against_last']) ?></td>
                            <td>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Resolved" <?= $row['status'] == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                                </select>
                            </td>
                            <td>
                                <textarea name="admin_response" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($row['admin_response']) ?></textarea>
                            </td>
                            <td><small><?= $row['submitted_at'] ?></small></td>
                            <td><button type="submit" class="btn btn-outline-primary btn-sm">✔ Update</button></td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </body>
                            
</html>