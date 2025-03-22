<!-- tech record  -->
<?php
require '../../config/Database.php';
require '../../auth/accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- icon -->
    <link rel="shortcut icon" href="../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- check if bato-->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- datatable:  cs -->
    <link rel="stylesheet" href="../../node_modules/datatables.net-dt/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- main js -->
    <link rel="stylesheet" href="../../assets/libs/css/style.css">

    <!-- toastify cs -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- assts csss -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <!-- icon -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <!-- <script  src="../../node_modules/jquery/dist/jquery.min.js"></script> -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTable JS -->
    <script src="../../node_modules/datatables.net/js/dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

    <!-- JSZip and pdfmake -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- main js -->
    <script src="../../assets/libs/js/main-js.js"></script>

    <!-- custom js -->
    <script src="./includes/resource/records_admin.js"></script>

    <!-- slimscroll js -->
    <script src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>


    <title>Admin Dashboard</title>
</head>

<body>
    <script>
        var userPermissions = <?= json_encode($userData['permissions']); ?>;
    </script>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header ">
            <nav class="navbar navbar-expand-lg bg-white fixed-top ">
                <a class="navbar-brand" href="index.php">
                    <img src="../../assets/images/bcp-hrd-logo.jpg" alt="" class="" style="height: 3rem;width: auto;">
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
                                                            class="notification-list-user-name">John Abraham </span>is
                                                        now following you
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
                                <a class="dropdown-item" href="./settings/emp-info.php?id=<?= $id['EmployeeID'] ?>"><i
                                        class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="../../auth/logout.php"><i
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
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <!-- <a class="d-xl-none d-lg-none" href="#">Dashboard</a> -->
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
                                <a class="nav-link " href="../index.php">
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
                            <!-- Talent Management -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-2" aria-controls="submenu-2"><i
                                        class="fa fa-fw fa-rocket"></i>Talent Management</a>
                                <div id="submenu-2" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/cards.html">Cards <span
                                                    class="badge badge-secondary">New</span></a>
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
                            <!-- Tech & Analytics -->
                            <li class="nav-item">
                                <a class="nav-link active" href="#" data-toggle="collapse" aria-expanded="true"
                                    data-target="#submenu-3" aria-controls="submenu-3"><i
                                        class="fas fa-fw fa-chart-pie"></i> Tech & Analytics</a>
                                <div id="submenu-3" class="collapse submenu show">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                                data-target="#submenu-3-1" aria-controls="submenu-3-1">Facilities &
                                                Resources</a>
                                            <div id="submenu-3-1" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link " href="./index.php">Resources Management</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="./room_book_list.php">Facility
                                                            Management</a>
                                                    </li>
                                                    <!-- <li class="nav-item">
                                                        <a class="nav-link" href="./request.php">Bookings and Request</a>
                                                    </li> -->
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="./records.php">Employee Personnel
                                                Records</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./reports.php">Administrative Report</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./usercontrol.php">Roles and Permission
                                                Mangement</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                                data-target="#submenu-3-2" aria-controls="submenu-3-2">Analytics</a>
                                            <div id="submenu-3-2" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="./analytics/facilities.php">Monitor
                                                            Facilities</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="./analytics/resources.php">Monitor
                                                            Resources</a>
                                                    </li>
                                                    <!-- <li class="nav-item">
                                                        <a class="nav-link" href="#">Engagement insight</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link"
                                                            href="./analytics/performace.php">Performance metric</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link"
                                                            href="./analytics/effieciency.php">Efficiency
                                                            analysis</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="./analytics/workforce.php">Workforce
                                                            optimazition</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="./analytics/talent.php">Talent
                                                            insight</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link"
                                                            href="./analytics/retention.php">Retention</a>
                                                    </li> -->
                                                </ul>
                                            </div>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-sparkline.html">Sparkline</a>
                                        </li> -->
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-gauge.html">Guage</a>
                                        </li> -->
                                    </ul>
                                </div>
                            </li>
                            <!-- Document and Legal -->
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-4" aria-controls="submenu-4"><i
                                        class="fab fa-fw fa-wpforms"></i>Document and Legal</a>
                                <div id="submenu-4" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/form-elements.html">Form Elements</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/form-validation.html">Parsely
                                                Validations</a>
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
                                <div id="submenu-5" class="collapse submenu">
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
                            <!-- Talent management -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-6" aria-controls="submenu-6"><i
                                        class="fas fa-fw fa-columns"></i>Talent management</a>
                                <div id="submenu-6" class="collapse submenu">
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
                                <div id="submenu-7" class="collapse submenu">
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
                            <li class="nav-divider">
                                Features
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./task-management/index.php" aria-expanded="false"
                                    data-target="#submenu-8" aria-controls="submenu-8">
                                    <i class="fas fa-fw fa-file"></i> Task-management </a>
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
        <div class="dashboard-wrapper" id="dashboardWrapper">
            <?php if ($userData && in_array("VIEW", $userData['permissions'])): ?>
                <!-- Employee Records Section -->
                <div class="container-fluid dashboard-content" id="employeeListView">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h2 class="card-title ">Employees Records management</h2>
                                </div>
                                <div class="card-body p-2">
                                    <div class="table-responsive">
                                        <table id="RecordsTable" class="table table-hover">
                                            <thead class="thead-light">
                                                <tr class="border-0">
                                                    <th class="border-0">Employee ID</th>
                                                    <th class="border-0">Name</th>
                                                    <th class="border-0">Email</th>
                                                    <th class="border-0">Phone</th>
                                                    <th class="border-0">Address</th>
                                                    <th class="border-0">Birthday</th>
                                                    <th class="border-0">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Employee rows will be populated by JS -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employee Details Tab-->
                <div class="container-fluid dashboard-content" id="employeeDetailView" style="display: none;">
                    <div class="row p-2">
                        <div class="col-12">

                            <!-- overview -->
                            <div class="card">
                                <div class="card-title p-3 d-flex justify-content-between">
                                    <h2>Overview</h2>
                                    <div>
                                        <button id="backButton" class="btn btn-outline-light d-inline">Back to List</button>
                                        <button type="button" onclick="window.print()"
                                            class="btn btn-outline-primary">Download
                                            as PDF</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    department <br>
                                    Performance <br>
                                    trainings <br>
                                    user acccounts <br>
                                    employee/applicant <br>
                                    Compensation <br>
                                </div>
                            </div>

                            <!-- employee info -->
                            <div class="card">
                                <div class="card-header p-3 m-0">
                                    <h3 class="m-0">Employee Details</h3>
                                </div>
                                <div class="card-body">
                                    <form id="editEmployeeForm" method="POST">
                                        <input type="hidden" name="edit_id" id="edit_id">

                                        <div class="mb-2">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="edit_name">First Name:</label>
                                                    <input type="text" name="edit_FirstName" id="edit_name"
                                                        class="form-control" required>
                                                </div>
                                                <div class="col">
                                                    <label for="edit_LastName">Last Name:</label>
                                                    <input type="text" name="edit_LastName" id="edit_LastName"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-2">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="edit_email">Email:</label>
                                                    <input type="email" name="edit_email" id="edit_email"
                                                        class="form-control" required>
                                                </div>
                                                <div class="col">
                                                    <label for="edit_phone">Phone:</label>
                                                    <input type="text" name="edit_phone" id="edit_phone"
                                                        class="form-control" required>
                                                </div>
                                                <div class="col">
                                                    <label for="edit_birthday">Birthday:</label>
                                                    <input type="date" name="edit_birthday" id="edit_birthday"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="edit_address">Address:</label>
                                            <input type="text" name="edit_address" id="edit_address" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-2">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- application details -->
                            <div class="card ">
                                <div class="card-title p-3 d-flex justify-content-between">
                                    <h3>Application Details</h3>
                                    <!-- <div>
                                    <button id="backButton" class="btn btn-outline-light d-inline">Back to List</button>
                                </div> -->
                                </div>
                                <div class="card-body">
                                    <form id="editEmployeeForm" action="update_employee.php" method="POST">
                                        <input type="hidden" name="edit_id" id="edit_id">

                                        <div class="mb-2">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="edit_name">First Name:</label>
                                                    <input type="text" name="edit_FirstName" id="edit_name"
                                                        class="form-control" required>
                                                </div>
                                                <div class="col">
                                                    <label for="edit_LastName">Last Name:</label>
                                                    <input type="text" name="edit_LastName" id="edit_LastName"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-2">
                                            <label for="edit_email">Email:</label>
                                            <input type="email" name="edit_email" id="edit_email" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="edit_phone">Phone:</label>
                                            <input type="text" name="edit_phone" id="edit_phone" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="edit_address">Address:</label>
                                            <input type="text" name="edit_address" id="edit_address" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="edit_birthday">Birthday:</label>
                                            <input type="date" name="edit_birthday" id="edit_birthday" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-2">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>

                                </div>

                            </div>

                            <!-- user account details -->
                            <div class="card ">
                                <div class="card-title p-3 d-flex justify-content-between">
                                    <h3>User Account Details</h3>
                                    <!-- <div>
                                    <button id="backButton" class="btn btn-outline-light d-inline">Back to List</button>
                                </div> -->
                                </div>
                                <div class="card-body">
                                    <form id="editEmployeeForm" action="update_employee.php" method="POST">
                                        <input type="hidden" name="edit_id" id="edit_id">

                                        <div class="mb-2">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="edit_name">First Name:</label>
                                                    <input type="text" name="edit_FirstName" id="edit_name"
                                                        class="form-control" required>
                                                </div>
                                                <div class="col">
                                                    <label for="edit_LastName">Last Name:</label>
                                                    <input type="text" name="edit_LastName" id="edit_LastName"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-2">
                                            <label for="edit_email">Email:</label>
                                            <input type="email" name="edit_email" id="edit_email" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="edit_phone">Phone:</label>
                                            <input type="text" name="edit_phone" id="edit_phone" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="edit_address">Address:</label>
                                            <input type="text" name="edit_address" id="edit_address" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="edit_birthday">Birthday:</label>
                                            <input type="date" name="edit_birthday" id="edit_birthday" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-2">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- bs notification -->
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div id="status" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body bg-success text-light">
                            Updated Successfully!
                        </div>
                    </div>
                    <div id="error" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body bg-success text-light">
                            Something went wrong.
                        </div>
                    </div>
                    <div id="required" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body bg-success text-light">
                            All fields are required
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <?php include_once "../403.php"; ?>
            <?php endif; ?>
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