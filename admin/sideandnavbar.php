<?php
$base_url = 'http://localhost/bcp-hrd';
$userID = $_SESSION['user_id'] ?? null;

// Default profile picture
$profilePicturePath = $base_url . '/assets/images/noprofile2.jpg';

// Connect using mysqli
$mysqli = new mysqli("localhost", "root", "", "bcp-hrd");
if ($mysqli->connect_error) {
    die("Connection failed (MySQLi): " . $mysqli->connect_error);
}

$employeeData = [];

// Fetch employee info (FirstName, LastName, Email, etc.)
if ($userID) {
    $sql = "
        SELECT 
            e.FirstName,
            e.LastName,
            e.Email,
            e.Phone,
            u.username,
            p.profile_picture_path
        FROM employees e
        INNER JOIN users u ON e.UserID = u.id
        LEFT JOIN employee_profile_pictures p ON e.EmployeeID = p.EmployeeID
        WHERE u.id = ?
        LIMIT 1
    ";

    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $employeeData = $result->fetch_assoc() ?: [];
        $stmt->close();
    }
}
$mysqli->close();

// If profile picture exists in database, check if file exists using PHP file_exists (no need PDO)
if (!empty($employeeData['profile_picture_path'])) {
    $pictureFromDb = ltrim($employeeData['profile_picture_path'], '/'); // Remove leading slash if present
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/bcp-hrd/admin/' . $pictureFromDb; // Full physical path

    if (file_exists($fullPath)) {
        // Set accessible URL path
        $profilePicturePath = $base_url . '/admin/' . $pictureFromDb;
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

    <script defer src="../node_modules/jquery/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>



    <!-- main js -->
    <script defer type="module" src="../assets/libs/js/main-js.js"></script>
    <link rel="stylesheet" href="../assets/libs/css/style.css">

    <!-- assts csss -->
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <script src="./main.js"></script>

    <!-- slimscroll js -->
    <script defer type="module" src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

    <title>Admin Dashboard</title>
</head>

<body>

    <div class="dashboard-header ">
        <nav class="navbar navbar-expand-lg bg-white fixed-top  ">
            <?php
            $base_url_logo = 'https://bcp-hrd.site'; // Change to your actual base URL
            ?>

            <a class="navbar-brand" href="index.php">
                <img src="<?php echo $base_url_logo; ?>/assets/images/bcp-hrd-logo.jpg" alt=""
                    style="height: 3rem;width: auto;">
            </a>

            <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse"
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
                            aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i>
                            <span class="indicator d-none"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                            <li>
                                <div class="notification-title"> Notification</div>
                                <div class="notification-list">
                                    <div class="list-group" id="notification">
                                        No notification
                                    </div>
                                </div>
                            </li>
                            <!-- <li>
                                <div class="list-footer"> <a href="#">View all notifications</a></div>
                            </li> -->
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
    <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <img id="user-avatar" src="<?php echo htmlspecialchars($profilePicturePath); ?>" alt="User Avatar" class="user-avatar-md rounded-circle">

    </a>
    <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
        aria-labelledby="navbarDropdownMenuLink2">
        <div class="nav-user-info">
            <h5 class="mb-0 text-white nav-user-name"><?= $_SESSION['username'] ?></h5>
            <span class="status"></span><span class="ml-2">Available</span>
        </div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#accountModal">
            <i class="fas fa-user mr-2"></i>Account
        </a>
        <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
        <a class="dropdown-item" href="<?php echo $base_url; ?>/auth/logout.php">
            <i class="fas fa-power-off mr-2"></i>Logout
        </a>
    </div>
</li>

                </ul>
            </div>
        </nav>
    </div>
<!-- Account Modal -->
<div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="accountModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= $base_url; ?>/admin/update_profile.php" method="POST" enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title" id="accountModalLabel">My Account</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- Profile Picture -->
          <div class="text-center mb-3">
            <!-- Display current profile picture if available, else show default -->
     <img src="<?= !empty($employeeData['profile_picture_path']) ? $base_url . '/admin/' . ltrim($employeeData['profile_picture_path'], '/') : $base_url . '/assets/images/noprofile2.jpg'; ?>"
     class="rounded-circle" width="120" height="120" id="employee-profile-preview">


            <div class="mt-2">
                <!-- Show file input only if profile picture is not set -->
                <?php if (empty($employeeData['profile_picture_path'])): ?>
                    <input type="file" name="profile_picture" class="form-control" accept="image/*" onchange="previewProfile(event)" required>
                <?php else: ?>
                    <input type="file" name="profile_picture" class="form-control" accept="image/*" onchange="previewProfile(event)">
                <?php endif; ?>
            </div>
          </div>

          <!-- Profile Info -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>First Name</label>
              <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($employeeData['FirstName'] ?? '') ?>" required>
            </div>
            <div class="form-group col-md-6">
              <label>Last Name</label>
              <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($employeeData['LastName'] ?? '') ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($employeeData['Email'] ?? '') ?>" required>
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($employeeData['Phone'] ?? '') ?>">
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
function previewProfile(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('profile-preview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>


    <div class="nav-left-sidebar sidebar-dark ">
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
                        <?php if ($userData['role'] != "superadmin"): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"
                                    href="<?php echo $base_url; ?>/admin/index.php">
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
                                            <a class="nav-link" href="#">Lorem, ipsum
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
                            <!-- Talent Management -->
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'recruitment.php' || basename($_SERVER['PHP_SELF']) == 'employees.php' || basename($_SERVER['PHP_SELF']) == 'succession.php' ||basename($_SERVER['PHP_SELF']) == 'talent_retention.php' || basename($_SERVER['PHP_SELF']) == 'onboarding.php' || basename($_SERVER['PHP_SELF']) == 'indextalent.php') ? 'active' : ''; ?>"
                                    href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2"
                                    aria-controls="submenu-2">
                                    <i class="fa fa-fw fa-rocket"></i> Employee Management
                                </a>


                                <div id="submenu-2" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'indextalent.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/talent/indextalent.php">
                                                Dashboard
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'employees.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/talent/employees.php">
                                                Employees
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'recruitment.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/talent/recruitment.php">
                                                Recruitment
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'onboarding.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/talent/onboarding.php">
                                                Onboarding
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'succession.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/talent/succession.php">
                                                Succession Planning
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'talent_retention.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/talent/talent_retention.php">
                                                Talent Retention
                                            </a>
                                        </li>


                                    </ul>
                                </div>
                            </li>
                            <!-- Tech & Analytics -->
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'resource_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'room_book_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'records.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'usercontrol.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'facilities.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'resources.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'attendance_tracker.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'survey_responses.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'job_order.php') ? 'active' : ''; ?>" href="#"
                                    data-toggle="collapse" aria-expanded="false" data-target="#submenu-3"
                                    aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i> Tech & Analytics</a>
                                <div id="submenu-3" class="collapse submenu <?php echo (basename($_SERVER['PHP_SELF']) == 'resource_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'room_book_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'records.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'usercontrol.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'attendance_tracker.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'resources.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'survey_responses.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'facilities.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'job_order.php') ? 'show' : ''; ?>">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                                data-target="#submenu-3-1" aria-controls="submenu-3-1">Facilities &
                                                Resources</a>
                                            <div id="submenu-3-1"
                                                class="collapse submenu <?php echo (basename($_SERVER['PHP_SELF']) == 'resource_list.php' ||
                                                    basename($_SERVER['PHP_SELF']) == 'room_book_list.php') ? 'show' : ''; ?>">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'resource_list.php') ? 'active' : ''; ?>"
                                                            href="<?php echo $base_url; ?>/admin/tech/resource_list.php">Resources
                                                            Management</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'room_book_list.php') ? 'active' : ''; ?>"
                                                            href="<?php echo $base_url; ?>/admin/tech/room_book_list.php">Facility
                                                            Management</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'records.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/tech/records.php">Employee Personnel
                                                Records</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link < ?php echo (basename($_SERVER['PHP_SELF']) == 'survey_responses.php') ? 'active' : ''; ?>"
                                                href="< ?php echo $base_url; ?>/admin/tech/survey_responses.php">Engagement
                                                Analytics</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link < ?php echo (basename($_SERVER['PHP_SELF']) == 'attendance_tracker.php') ? 'active' : ''; ?>"
                                                href="< ?php echo $base_url; ?>/admin/tech/attendance_tracker.php">Attendance Tracker</a>
                                        </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                                data-target="#submenu-3-2" aria-controls="submenu-3-2">Report and
                                                Analysis</a>
                                            <div id="submenu-3-2" class="collapse submenu  <?php echo (basename($_SERVER['PHP_SELF']) == 'resources.php' ||
                                                basename($_SERVER['PHP_SELF']) == 'facilities.php') ? 'show' : ''; ?>">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'facilities.php') ? 'active' : ''; ?>"
                                                            href="<?php echo $base_url; ?>/admin/tech/analytics/facilities.php">
                                                            Facilities</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'resources.php') ? 'active' : ''; ?>"
                                                            href="<?php echo $base_url; ?>/admin/tech/analytics/resources.php">
                                                            Resources</a>
                                                    </li>
                                                </ul>
                                            </div>
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
                                            <a class="nav-link" href="pages/form-elements.html">Form Elements</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/form-validation.html">Parsely Validations</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/multiselect.html">Multiselect</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/datepicker.html">Date Picker</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/bootstrap-select.html">Bootstrap Select</a>
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
                                            <a class="nav-link" href="pages/general-table.html">General Tables</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/data-tables.html">Data Tables</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- training management -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-6" aria-controls="submenu-6"><i
                                        class="fas fa-fw fa-columns"></i>Talent management</a>
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
                            <!-- Compensation & benefits -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-7" aria-controls="submenu-7"><i
                                        class="fas fa-f fa-folder"></i>Compensation & benefits</a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/admin/compensation/dashboard.php">Rates</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/admin/compensation/leave.php">Leave</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/admin/compensation/benefits.php">Benefits</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/admin/compensation/index.php">Holidays</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php else: ?>
                            <!-- SUPER ADMIN NAVIGATION -->
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"
                                    href="<?php echo $base_url; ?>/admin/index.php">
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
                                            <a class="nav-link" href="#">Lorem, ipsum
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
                            <!-- Talent Management -->
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'recruitment.php' || basename($_SERVER['PHP_SELF']) == 'talent_retention.php' ||basename($_SERVER['PHP_SELF']) == 'employees.php' || basename($_SERVER['PHP_SELF']) == 'onboarding.php' || basename($_SERVER['PHP_SELF']) == 'indextalent.php') ? 'active' : ''; ?>"
                                    href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2"
                                    aria-controls="submenu-2">
                                    <i class="fa fa-fw fa-rocket"></i> Employee Management
                                </a>


                                <div id="submenu-2" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'indextalent.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/talent/indextalent.php">
                                                Dashboard
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'employees.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/talent/employees.php">
                                                Employees
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'recruitment.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/talent/recruitment.php">
                                                Recruitment
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'onboarding.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/talent/onboarding.php">
                                                Onboarding
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'succession.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/talent/succession.php">
                                                Succession Planning
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'talent_retention.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/talent/talent_retention.php">
                                                Talent Retention
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            <!-- tech and analytics -->
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'resource_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'room_book_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'records.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'usercontrol.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'facilities.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'survey_responses.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'attendance_tracker.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'resources.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'job_order.php') ? 'active' : ''; ?>" href="#"
                                    data-toggle="collapse" aria-expanded="false" data-target="#submenu-3"
                                    aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i> Tech & Analytics</a>
                                <div id="submenu-3" class="collapse submenu <?php echo (basename($_SERVER['PHP_SELF']) == 'resource_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'room_book_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'records.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'usercontrol.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'attendance_tracker.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'survey_responses.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'resources.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'facilities.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'job_order.php') ? 'show' : ''; ?>">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                                data-target="#submenu-3-1" aria-controls="submenu-3-1">Facilities &
                                                Resources</a>
                                            <div id="submenu-3-1"
                                                class="collapse submenu <?php echo (basename($_SERVER['PHP_SELF']) == 'resource_list.php' ||
                                                    basename($_SERVER['PHP_SELF']) == 'room_book_list.php') ? 'show' : ''; ?>">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'resource_list.php') ? 'active' : ''; ?>"
                                                            href="<?php echo $base_url; ?>/admin/tech/resource_list.php">Resources
                                                            Management</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'room_book_list.php') ? 'active' : ''; ?>"
                                                            href="<?php echo $base_url; ?>/admin/tech/room_book_list.php">Facility
                                                            Management</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'records.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/tech/records.php">Employee Personnel
                                                Records</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'usercontrol.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/tech/usercontrol.php">
                                                <!-- <i class="bi bi-person-fill-gear"></i> -->
                                                User Control</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'survey_responses.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/tech/survey_responses.php">Engagement
                                                Analytics</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'job_order.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/tech/job_order.php">Job Analysis</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'attendance_tracker.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/admin/tech/attendance_tracker.php">Attendance Tracker</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                                data-target="#submenu-3-2" aria-controls="submenu-3-2">Analytics</a>
                                            <div id="submenu-3-2" class="collapse submenu  <?php echo (basename($_SERVER['PHP_SELF']) == 'resources.php' ||
                                                basename($_SERVER['PHP_SELF']) == 'facilities.php') ? 'show' : ''; ?>">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'facilities.php') ? 'active' : ''; ?>"
                                                            href="<?php echo $base_url; ?>/admin/tech/analytics/facilities.php">Monitor
                                                            Facilities</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'resources.php') ? 'active' : ''; ?>"
                                                            href="<?php echo $base_url; ?>/admin/tech/analytics/resources.php">Monitor
                                                            Resources</a>
                                                    </li>
                                                </ul>
                                            </div>
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
                                            <a class="nav-link" href="pages/form-elements.html">Form Elements</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/form-validation.html">Parsely Validations</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/multiselect.html">Multiselect</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/datepicker.html">Date Picker</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/bootstrap-select.html">Bootstrap Select</a>
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
                                            <a class="nav-link" href="pages/general-table.html">General Tables</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/data-tables.html">Data Tables</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- training management -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-6" aria-controls="submenu-6"><i
                                        class="fas fa-fw fa-columns"></i>Talent management</a>
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
                            <!-- Compensation & benefits -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-7" aria-controls="submenu-7"><i
                                        class="fas fa-f fa-folder"></i>Compensation & benefits</a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/admin/compensation/dashboard.php">Rates</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/admin/compensation/leave.php">Leave</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/admin/compensation/benefits.php">Benefits</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/admin/compensation/index.php">Holidays</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</body>

</html>