<?php

$base_url = 'http://localhost/bcp-hrd'; // Your project's base URL

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

    <title>Admin Dashboard</title>
</head>

<body>
    <div class="dashboard-header ">
        <nav class="navbar navbar-expand-lg bg-white fixed-top  ">
            <?php
            $base_url_logo = 'http://localhost/bcp-hrd'; // Change to your actual base URL
            ?>

             <a class="navbar-brand" href="index.php">
                <img src="<?php echo $base_url_logo; ?>/assets/images/bcp-hrd-logo.jpg" alt=""
                    style="height: 3rem;width: auto;">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                                        <!--  <a href="#" class="list-group-item list-group-item-action active">
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
                                                        class="notification-list-user-name">John Abraham </span>is now
                                                    following you
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
                                        </a> -->
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <div class="notification-list-user-block"><span
                                                    class="notification-list-user-name">No notification</span>
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
                        <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><img src="#" alt=""
                                class="user-avatar-md rounded-circle"></a>
                        <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                            aria-labelledby="navbarDropdownMenuLink2">
                            <div class="nav-user-info">
                                <h5 class="mb-0 text-white nav-user-name"> <?= $_SESSION['username'] ?> </h5>
                                <span class="status"></span><span class="ml-2">Available</span>
                            </div>
                            <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
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
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'recruitment.php' || basename($_SERVER['PHP_SELF']) == 'employees.php' || basename($_SERVER['PHP_SELF']) == 'succession.php' || basename($_SERVER['PHP_SELF']) == 'onboarding.php' || basename($_SERVER['PHP_SELF']) == 'indextalent.php') ? 'active' : ''; ?>"
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
                                    basename($_SERVER['PHP_SELF']) == 'reports.php') ? 'active' : ''; ?>" href="#"
                                    data-toggle="collapse" aria-expanded="false" data-target="#submenu-3"
                                    aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i> Tech & Analytics</a>
                                <div id="submenu-3" class="collapse submenu <?php echo (basename($_SERVER['PHP_SELF']) == 'resource_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'room_book_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'records.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'usercontrol.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'resources.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'facilities.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'reports.php') ? 'show' : ''; ?>">
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
                                        <a class="nav-link < ?php echo (basename($_SERVER['PHP_SELF']) == 'reports.php') ? 'active' : ''; ?>"
                                            href="< ?php echo $base_url; ?>/admin/tech/reports.php">Administrative
                                            Report</a>
                                    </li> -->
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
                                            <a class="nav-link" href="pages/general-table.html">General Tables</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/data-tables.html">Data Tables</a>
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
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'resource_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'room_book_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'records.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'usercontrol.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'facilities.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'resources.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'reports.php') ? 'active' : ''; ?>" href="#"
                                    data-toggle="collapse" aria-expanded="false" data-target="#submenu-3"
                                    aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i> Tech & Analytics</a>
                                <div id="submenu-3" class="collapse submenu <?php echo (basename($_SERVER['PHP_SELF']) == 'resource_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'room_book_list.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'records.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'usercontrol.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'resources.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'facilities.php' ||
                                    basename($_SERVER['PHP_SELF']) == 'reports.php') ? 'show' : ''; ?>">
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
                                        <!-- <li class="nav-item">
                                        <a class="nav-link < ?php echo (basename($_SERVER['PHP_SELF']) == 'reports.php') ? 'active' : ''; ?>"
                                            href="< ?php echo $base_url; ?>/admin/tech/reports.php">Administrative
                                            Report</a>
                                    </li> -->
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

                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</body>

</html>