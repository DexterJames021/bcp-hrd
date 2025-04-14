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

<div class="nav-left-sidebar sidebar-primary ">
            <div class="menu-list ">
                <nav class="navbar navbar-expand-lg navbar-light">
                <a class="d-xl-none d-lg-none" href="#"><?= strtoupper($_SESSION['usertype']) ?> PANEL</a>
                    <a class="d-xl-none d-lg-none" href="index.php">Human Resource Dept.</a>
                    <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Human Resource Dept.
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"
                                    href="<?php echo $base_url; ?>/portal/index.php">
                                    <i class="fas fa-fw fa-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="./tech/resources.php">Resources Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="./tech/facility.php">Facility
                                    Management</a>
                            </li>
                             <!-- Compensation & benefits -->
                             <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-7" aria-controls="submenu-7"> Compensation & benefits</a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/manager/compen/leave.php">My Leave</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/manager/compen/requests.php">Leave Requests</a>
                                        </li>
                                        <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $base_url; ?>/manager/compen/holiday.php">Holidays</a>
                                        </li>
                                       
                                    </ul>
                                </div>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7">
                                    <i class="fas fa-fw fa-inbox"></i>Facility and Resources Request <span class="badge badge-secondary">New</span>
                                </a>
                                <div id="submenu-7" class="collapse submenu">
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
                            </li> -->
                        </ul>
                    </div>
                </nav>
            </div>
        </div>