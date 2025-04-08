<?php
session_start();
include 'db_connection.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle form submission for new contracts
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];
    $contract_type = $_POST['contract_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reminder_date = $_POST['reminder_date'] ?: null;
    $admin_notes = $_POST['admin_notes'] ?: null;
    
    // Handle file upload
    if (isset($_FILES['contract_file'])) {
        $contract_file = 'uploads/' . basename($_FILES['contract_file']['name']);
        move_uploaded_file($_FILES['contract_file']['tmp_name'], $contract_file);
    }

    // Insert contract into database
    $stmt = $conn->prepare("INSERT INTO contracts (employee_id, contract_type, contract_file, start_date, end_date, reminder_date, admin_notes) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $employee_id, $contract_type, $contract_file, $start_date, $end_date, $reminder_date, $admin_notes);

    if ($stmt->execute()) {
        echo "Contract successfully uploaded.";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch all contracts for the admin
$sql = "SELECT c.id, c.contract_type, c.start_date, c.end_date, c.status, c.reminder_date, c.admin_notes, u.first_name, u.last_name
        FROM contracts c
        LEFT JOIN users u ON c.employee_id = u.id
        ORDER BY c.start_date DESC";
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

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Reports</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <style>
        .report-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
        }
        .report-header {
            font-weight: bold;
        }
        .report-body {
            margin-top: 8px;
        }
        .notification {
            color: #007bff;
            cursor: pointer;
        }

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
        <h2 class="text-white text-center fs-4">Manage Contracts</h2>
    </div>

    <!-- Form to add new contract -->
    <form method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
        <div class="form-group">
            <label for="employee_id">Employee:</label>
            <select name="employee_id" class="form-control" required>
                <?php
                $employee_result = $conn->query("SELECT id, first_name, last_name FROM users WHERE usertype = 'employee'");
                while ($row = $employee_result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['first_name']} {$row['last_name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="contract_type">Contract Type:</label>
            <select name="contract_type" class="form-control" required>
                <option value="Regular">Regular</option>
                <option value="Probationary">Probationary</option>
                <option value="Part-time">Part-time</option>
            </select>
        </div>

        <div class="form-group">
            <label for="contract_file">Upload Signed Contract:</label>
            <input type="file" name="contract_file" class="form-control-file" required>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="reminder_date">Reminder Date (Optional):</label>
            <input type="date" name="reminder_date" class="form-control">
        </div>

        <div class="form-group">
            <label for="admin_notes">Admin Notes:</label>
            <textarea name="admin_notes" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-outline-primary btn-block">Submit Contract</button>
    </form>

    <hr class="my-4">

    <!-- Display list of contracts -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th class="text-dark">Employee Name</th>
                    <th class="text-dark">Contract Type</th>
                    <th class="text-dark">Start Date</th>
                    <th class="text-dark">End Date</th>
                    <th class="text-dark">Status</th>
                    <th class="text-dark">Reminder Date</th>
                    <th class="text-dark">Admin Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['contract_type']) ?></td>
                        <td><?= htmlspecialchars($row['start_date']) ?></td>
                        <td><?= htmlspecialchars($row['end_date']) ?></td>
                        <td>
                            <?php if ($row['status'] == 'Active'): ?>
                                <span class="badge badge-success"><?= htmlspecialchars($row['status']) ?></span>
                            <?php else: ?>
                                <span class="badge badge-danger"><?= htmlspecialchars($row['status']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['reminder_date']) ?: 'N/A' ?></td>
                        <td><?= htmlspecialchars($row['admin_notes']) ?: 'No notes' ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Custom CSS for better design -->
<style>
    .container {
        max-width: 1200px;
    }

    .form-control, .form-control-file {
        border-radius: 5px;
    }

    .form-group label {
        font-weight: bold;
    }

    .btn-block {
        width: 100%;
    }

    .table td, .table th {
        text-align: center;
    }

    .badge {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }

    .table-responsive {
        margin-top: 20px;
    }

    .table-primary {
        background-color: #0066cc;
        color: white;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    hr.my-4 {
        border-top: 2px solid #ccc;
        margin-top: 20px;
        margin-bottom: 20px;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </body>

</html>