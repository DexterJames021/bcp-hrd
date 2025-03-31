<?php

$base_url = 'http://localhost/bcp-hrd';

?>
<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- icon -->
    <link rel="shortcut icon" href="../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">


    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- main js -->
    <script defer type="module" src="../assets/libs/js/main-js.js"></script>
    <link rel="stylesheet" href="../assets/libs/css/style.css">

    <!-- assts csss -->
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <!-- slimscroll js -->
    <script type="module" src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

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
    <!-- ============================================================== -->
    <!-- end navbar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- left sidebar -->
    <!-- ============================================================== -->
    <div class="nav-left-sidebar sidebar-white ">
        <div class="menu-list">
            <nav class="navbar navbar-expand-lg cc">
                <a class="d-xl-none d-lg-none" href="#"><?= strtoupper($_SESSION['usertype']) ?> PANEL</a>
                <button class="navbar-toggler btn-light" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav  flex-column">
                        <li class="nav-divider">
                            <?= strtoupper($_SESSION['usertype']) ?> PANEL
                        </li>
                        <?php if ($userData['role'] == "employee"): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"
                                    href="<?php echo $base_url; ?>/portal/index.php">
                                    <i class="fas fa-fw fa-home"></i> Dashboard
                                </a>
                            </li>
                            <!-- temp -->
                            <!-- <li class="nav-item ">
                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                data-target="#submenu-1" aria-controls="submenu-1"><i
                                    class="fa fa-fw fa-user-circle"></i>employee <span
                                    class="badge badge-success">6</span></a>
                            <div id="submenu-1" class="collapse submenu bg-light">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                            data-target="#submenu-1-2" aria-controls="submenu-1-2">Lorem, ipsum.</a>
                                        <div id="submenu-1-2" class="collapse submenu bg-light">
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
                        </li> -->
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
                    </div>
            </div>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="./tech/facilities/survey.php">Survey</a>
            </li>
        <?php endif; ?>
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
</body>

</html>