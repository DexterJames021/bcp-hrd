<?php
$base_url = 'http://localhost/bcp-hrd';

##################3###################
#   DASHBOARD
#       manager
#####################################
?>

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
                        <!-- <span
                            class="indicator"></span> -->
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                        <li>
                            <div class="notification-title"> Notification</div>
                            <div class="notification-list">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action active">
                                        <div class="notification-info">
                                            No notification
                                        </div>
                                    </a>
                                    <!-- More notification items here -->
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="list-footer"> <a href="#">View all notifications</a></div>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown nav-user">
                    <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img id="user-avatar"
                            src="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? '../assets/images/noprofile2.jpg' : '../../assets/images/noprofile2.jpg' ?>"
                            alt="" class="user-avatar-md rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                        aria-labelledby="navbarDropdownMenuLink2">
                        <div class="nav-user-info">
                            <h5 class="mb-0 text-white nav-user-name"> <?= $_SESSION['username'] ?> </h5>
                            <span class="status"></span><span class="ml-2">Available</span>
                        </div>
                        <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                        <a class="dropdown-item" href="<?php echo $base_url; ?>/auth/logout.php"><i
                                class="fas fa-power-off mr-2"></i>Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>

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
                                        <!-- <li class="nav-item">
                                                    <a class="nav-link" href="./tech/facilities/survey.php">Survey</a>
                                                </li> -->
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
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="./tech/facilities/survey.php">Survey</a>
                                        </li> -->
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
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="./tech/facilities/survey.php">Survey</a>
                                        </li> -->
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
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="./tech/facilities/survey.php">Survey</a>
                                        </li> -->
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