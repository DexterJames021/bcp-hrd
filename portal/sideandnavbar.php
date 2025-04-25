<?php
$base_url = 'http://localhost/bcp-hrd';
$userID = $_SESSION['user_id'];

// Default profile picture
$profilePicturePath = $base_url . '/assets/images/noprofile2.jpg';

// Fetch employee data using mysqli
$mysqli = new mysqli("localhost", "root", "", "bcp-hrd");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch employee info (FirstName, LastName, etc.)
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
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$employeeData = mysqli_fetch_assoc($result) ?: [];
$stmt->close();
$mysqli->close();

// If profile picture exists in database, check if file exists
if (!empty($employeeData['profile_picture_path'])) {
    $pictureFromDb = ltrim($employeeData['profile_picture_path'], '/'); // Remove leading slash if present
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/bcp-hrd/portal/' . $pictureFromDb; // Full physical path

    // Using PDO to check the file's existence
    try {
        // Using PDO to confirm file existence
        $pdo = new PDO('mysql:host=localhost;dbname=bcp-hrd', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the file exists with PDO (Using PDO for file check)
        if (file_exists($fullPath)) {
            // Use base_url for accessible path
            $profilePicturePath = $base_url . '/portal/' . $pictureFromDb;
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>

<head>
    <script src="./notif.js"></script>
</head>
<script>
    var userID = <?= json_encode($_SESSION['user_id']); ?>;
</script>
<div class="dashboard-header ">
    <nav class="navbar navbar-expand-lg bg-light fixed-top">
        <a class="navbar-brand" href="index.php">
            <img src="<?php echo $base_url; ?>/assets/images/bcp-hrd-logo.jpg" alt="" style="height: 3rem;width: auto;">
        </a>
        <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
                <li class="nav-item dropdown nav-user">
    <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <img id="user-avatar" src="<?= $profilePicturePath ?>" alt="User Avatar" class="user-avatar-md rounded-circle">


    </a>
    <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
        aria-labelledby="navbarDropdownMenuLink2">
        <div class="nav-user-info">
            <h5 class="mb-0 text-white nav-user-name"><?= $_SESSION['username'] ?></h5>
            <span class="status"></span><span class="ml-2">Available</span>
        </div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#employeeAccountModal">
            <i class="fas fa-user mr-2"></i>Account
        </a>
        <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
        <a class="dropdown-item" href="<?= $base_url; ?>/auth/logout.php">
            <i class="fas fa-power-off mr-2"></i>Logout
        </a>
    </div>
</li>

            </ul>
        </div>
    </nav>
</div>
<!-- Employee Account Modal -->
<div class="modal fade" id="employeeAccountModal" tabindex="-1" role="dialog" aria-labelledby="employeeAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= $base_url; ?>/portal/update_profile.php" method="POST" enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title" id="employeeAccountModalLabel">My Account</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- Profile Picture -->
          <div class="text-center mb-3">
            <!-- Display current profile picture if available, else show default -->
            <img src="<?= !empty($employeeData['profile_picture_path']) ? $base_url . '/portal/' . ltrim($employeeData['profile_picture_path'], '/') : $base_url . '/assets/images/noprofile2.jpg'; ?>"
     class="rounded-circle" width="120" height="120" id="employee-profile-preview">

            <div class="mt-2">
                <?php if (empty($employeeData['profile_picture_path'])): ?>
                    <input type="file" name="profile_picture" class="form-control" accept="image/*" onchange="previewEmployeeProfile(event)" required>
                <?php else: ?>
                    <input type="file" name="profile_picture" class="form-control" accept="image/*" onchange="previewEmployeeProfile(event)">
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
// Separate function para di mag-conflict sa admin modal
function previewEmployeeProfile(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('employee-profile-preview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>


<div class="nav-left-sidebar sidebar-white">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg">
            <a class="d-xl-none d-lg-none" href="#"><?= strtoupper($_SESSION['usertype']) ?> PANEL</a>
            <button class="navbar-toggler navbar-light btn-light" type="button" data-toggle="collapse"
                data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        <?= strtoupper($_SESSION['usertype']) ?> PANEL
                    </li>
                    <?php if (isset($userData['role'])): ?>
                        <?php if ($userData['role'] === 'employee'): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"
                                    href="<?php echo $base_url; ?>/portal/index.php">
                                    <i class="fas fa-fw fa-home"></i> Dashboard
                                </a>
                            </li>
                            <!-- facilities -->
                            <li class="nav-item ">
                                <a class="nav-link <?php echo (
                                    basename($_SERVER['PHP_SELF']) == 'request_resources.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'book_facility.php') || 
                                    basename($_SERVER['PHP_SELF']) == 'survey.php' ? 'active' : ''; ?>"
                                    href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2"
                                    aria-controls="submenu-2">
                                    <i class="fa fa-fw fa-user-circle"></i>Facilites and Resources
                                </a>
                                <div id="submenu-2"
                                    class="collapse submenu bg-light <?php echo (
                                        basename($_SERVER['PHP_SELF']) == 'book_facility.php' || 
                                        basename($_SERVER['PHP_SELF']) == 'request_resources.php') || 
                                        basename($_SERVER['PHP_SELF']) == 'survey.php'? 'show' : ''; ?>">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link  <?php echo (basename($_SERVER['PHP_SELF']) == 'book_facility.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/tech/book_facility.php">Book
                                                Facility</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'request_resources.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/tech/request_resources.php">Request
                                                Resources</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link  <?php echo (basename($_SERVER['PHP_SELF']) == 'survey.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/tech/survey.php">Survey</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- talent -->
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'training_sessions.php' || basename($_SERVER['PHP_SELF']) == 'available.php' || basename($_SERVER['PHP_SELF']) == 'onboarding.php' || basename($_SERVER['PHP_SELF']) == 'indextalent.php') ? 'active' : ''; ?>"
                                    href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3"
                                    aria-controls="submenu-3">
                                    <i class="fa fa-fw fa-rocket"></i> Employee Management
                                </a>
                                <div id="submenu-3" class="collapse submenu bg-light">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'talent/available.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/talent/available.php">
                                                My Succession
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'talent/award.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/talent/award.php">
                                                My Awards
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Compensation & benefits -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-7" aria-controls="submenu-7"><i
                                        class="fas fa-folder"></i>Compensation & benefits</a>
                                <div id="submenu-7" class="collapse submenu bg-light" style="">
                                    <ul class="nav flex-column">
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/portal/leave.php">My leave</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/portal/holiday.php">Holidays</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php elseif ($userData['role'] === 'nonteaching'): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"
                                    href="<?php echo $base_url; ?>/portal/index.php">
                                    <i class="fas fa-fw fa-home"></i> Dashboard
                                </a>
                            </li>
                            <!-- facilities -->
                            <li class="nav-item ">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'request_resources.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'book_facility.php') ? 'active' : ''; ?>"
                                    href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2"
                                    aria-controls="submenu-2">
                                    <i class="fa fa-fw fa-user-circle"></i>Facilites and Resources
                                </a>
                                <div id="submenu-2"
                                    class="collapse submenu bg-light <?php echo (basename($_SERVER['PHP_SELF']) == 'book_facility.php' || basename($_SERVER['PHP_SELF']) == 'request_resources.php') ? 'show' : ''; ?>">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link  <?php echo (basename($_SERVER['PHP_SELF']) == 'book_facility.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/tech/book_facility.php">Book
                                                Facility</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'request_resources.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/tech/request_resources.php">Request
                                                Resources</a>
                                        </li>
                                        <li
                                            class="nav-item">
                                            <a class="nav-link  <?php echo (basename($_SERVER['PHP_SELF']) == 'survey.php') ? 'active' : ''; ?>" 
                                                href="<?php echo $base_url; ?>/portal/tech/survey.php">Survey</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- talent -->
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'training_sessions.php' || basename($_SERVER['PHP_SELF']) == 'available.php' || basename($_SERVER['PHP_SELF']) == 'onboarding.php' || basename($_SERVER['PHP_SELF']) == 'indextalent.php') ? 'active' : ''; ?>"
                                    href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3"
                                    aria-controls="submenu-3">
                                    <i class="fa fa-fw fa-rocket"></i> Employee Management
                                </a>
                                <div id="submenu-3" class="collapse submenu bg-light">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'talent/training_sessions.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/talent/training_sessions.php">
                                                My Training Sessions
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'talent/training_sessions.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/talent/available.php">
                                                Available Trainings
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Compensation & benefits -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-7" aria-controls="submenu-7"><i
                                        class="fas fa-folder"></i>Compensation & benefits</a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/portal/leave.php">My leave</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/portal/holiday.php">Holidays</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php elseif ($userData['role'] === 'teaching'): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"
                                    href="<?php echo $base_url; ?>/portal/index.php">
                                    <i class="fas fa-fw fa-home"></i> Dashboard
                                </a>
                            </li>
                            <!-- facilities -->
                            <li class="nav-item ">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'request_resources.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'book_facility.php') ? 'active' : ''; ?>"
                                    href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2"
                                    aria-controls="submenu-2">
                                    <i class="fa fa-fw fa-user-circle"></i>Facilites and Resources
                                </a>
                                <div id="submenu-2"
                                    class="collapse submenu bg-light <?php echo (basename($_SERVER['PHP_SELF']) == 'book_facility.php' || basename($_SERVER['PHP_SELF']) == 'request_resources.php') ? 'show' : ''; ?>">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link  <?php echo (basename($_SERVER['PHP_SELF']) == 'book_facility.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/tech/book_facility.php">Book
                                                Facility</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'request_resources.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/tech/request_resources.php">Request
                                                Resources</a>
                                        </li>
                                        <li
                                            class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'survey.php') ? 'active' : ''; ?>" 
                                            href="<?php echo $base_url; ?>/portal/tech/survey.php"">Survey</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- talent -->
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'training_sessions.php' || basename($_SERVER['PHP_SELF']) == 'available.php' || basename($_SERVER['PHP_SELF']) == 'onboarding.php' || basename($_SERVER['PHP_SELF']) == 'indextalent.php') ? 'active' : ''; ?>"
                                    href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3"
                                    aria-controls="submenu-3">
                                    <i class="fa fa-fw fa-rocket"></i> Employee Management
                                </a>
                                <div id="submenu-3" class="collapse submenu bg-light">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'talent/training_sessions.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/talent/training_sessions.php">
                                                My Training Sessions
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'talent/training_sessions.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/talent/available.php">
                                                Available Trainings
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Compensation & benefits -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-7" aria-controls="submenu-7"><i
                                        class="fas fa-folder"></i>Compensation & benefits</a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/portal/leave.php">My leave</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/portal/holiday.php">Holidays</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php elseif ($userData['role'] === 'staff'): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"
                                    href="<?php echo $base_url; ?>/portal/index.php">
                                    <i class="fas fa-fw fa-home"></i> Dashboard
                                </a>
                            </li>
                            <!-- facilities -->
                            <li class="nav-item ">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'request_resources.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'book_facility.php') ? 'active' : ''; ?>"
                                    href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2"
                                    aria-controls="submenu-2">
                                    <i class="fa fa-fw fa-user-circle"></i>Facilites and Resources
                                </a>
                                <div id="submenu-2"
                                    class="collapse submenu bg-light < ?php echo (basename($_SERVER['PHP_SELF']) == 'book_facility.php' || basename($_SERVER['PHP_SELF']) == 'request_resources.php') ? 'show' : ''; ?>">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link  < ?php echo (basename($_SERVER['PHP_SELF']) == 'book_facility.php') ? 'active' : ''; ?>"
                                                href="< ?php echo $base_url; ?>/portal/tech/book_facility.php">Book
                                                Facility</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link < ?php echo (basename($_SERVER['PHP_SELF']) == 'request_resources.php') ? 'active' : ''; ?>"
                                                href="< ?php echo $base_url; ?>/portal/tech/request_resources.php">Request
                                                Resources</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link < ?php echo (basename($_SERVER['PHP_SELF']) == 'survey.php') ? 'active' : ''; ?>"
                                                href="< ?php echo $base_url; ?>/portal/tech/survey.php">Request
                                                Resources</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- talent -->
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'training_sessions.php' || basename($_SERVER['PHP_SELF']) == 'available.php' || basename($_SERVER['PHP_SELF']) == 'onboarding.php' || basename($_SERVER['PHP_SELF']) == 'indextalent.php') ? 'active' : ''; ?>"
                                    href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3"
                                    aria-controls="submenu-3">
                                    <i class="fa fa-fw fa-rocket"></i> Employee Management
                                </a>
                                <div id="submenu-3" class="collapse submenu bg-light">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'talent/training_sessions.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/talent/training_sessions.php">
                                                My Training Sessions
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'talent/training_sessions.php') ? 'active' : ''; ?>"
                                                href="<?php echo $base_url; ?>/portal/talent/available.php">
                                                Available Trainings
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Compensation & benefits -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-7" aria-controls="submenu-7"><i
                                        class="fas fa-folder"></i>Compensation & benefits</a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/portal/leave.php">My leave</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/portal/holiday.php">Holidays</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php else: ?>
                            <li>
                                <p>Unauthorized role.</p>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php Header("Location: ../"); ?>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</div>