<?php
require __DIR__ . '../../../config/Database.php';
require __DIR__ . '../../../auth/accesscontrol.php';

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

    <!-- assts csss -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- main cs -->
    <link rel="stylesheet" href="../../assets/libs/css/style.css">

    <!-- datatable:  cs -->
    <link rel="stylesheet" href="../../node_modules/datatables.net-dt/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Bootstrap JS -->
    <script defer src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>

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


    <!-- slimscroll js -->
    <script type="module" src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script type="module" src="../../assets/libs/js/main-js.js"></script>


    <!-- custom js -->
    <script type="module" src="./includes/resource/employee_report_admin.js"></script>


    <!-- charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <title>Report and Analytics</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            /* Hide elements you don't want in the print version */
            button, a {
                display: none !important;
            }

            /* Ensure the content expands to full page */
            .report-container {
                width: 100%;
                height: 100vh;
                page-break-before: always;
            }
        }
        </style>
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
        <!-- <div class="dashboard-header ">
            <nav class="navbar navbar-expand-lg bg-white fixed-top  ">
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
                                <a class="dropdown-item" href="../../auth/logout.php"><i
                                        class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div> -->
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php include '../sideandnavbar.php'; ?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper ">
            <?php if ($userData && in_array("VIEW", $userData['permissions'])): ?>
                <!-- analytics -->
                <div id="analyticPage" class="container-fluid dashboard-content">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header d-flex justify-content-between">
                                <h2 class="pageheader-title">Reports and Analytics</h2>
                                <div class="btn-group m-1">
                                    <button type="button" onclick="printReport()"
                                        class="btn btn-outline-primary">Print</button>
                                    <button type="button" id="logsView" class="btn btn-outline-primary">Logs</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex report-container">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-6">

                            <!-- utilization -->
                            <div class="card">
                                <div class="card-header">
                                    <h4>Over Utilized</h4>
                                </div>
                                <!-- utilize -->
                                <div class="card-body" width="100%" height="100%">
                                    <canvas id="facilityUtilization"></canvas>
                                </div>
                            </div>

                            <!-- category -->
                            <div class="card">
                                <div class="card-header">
                                    <h4>Categorization </h4>
                                </div>
                                <div class="card-body">
                                    <table id="facilityTable">
                                        <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Location</td>
                                                <td>Capacity</td>
                                                <td>Status</td>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-6">

                            <!-- distribution -->
                            <div class="card">
                                <div class="card-header">
                                    <h4>Status Distribution</h4>
                                </div>
                                <div class="card-body" width="100%" height="100%">
                                    <canvas id="bookingStatusDistribution"></canvas>
                                </div>
                            </div>

                            <!-- Bookings trend -->
                            <div class="card">
                                <div class="card-header">
                                    <h4>Booking Trends</h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="bookingTrends"></canvas>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>


                <!-- logs page -->
                <div id="logPage" class="container-fluid dashboard-content" style="display:none;">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header d-flex justify-content-between">
                                <h2 class="pageheader-title">Reports </h2>
                                <div class="btn-group m-1">
                                    <button id="analyticView" type="button" class="btn btn-outline-primary">Back</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between ">
                                    <div class="d-flex ">

                                    </div>
                                    <div>
                                        <button type="button" id="openModalBtn" class="btn btn-outline-primary float-right"
                                            data-toggle="modal" data-target="#reportModal">Generate Report</button>
                                        <!--
                                            logs number
                                            suggestion not need 
                                            what is trend
                                        -->
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="LogbookingTable" class="table table-hover" width="100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Employee</th>
                                                <th>Room</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Purpose</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <?php include_once "../../403.php"; ?>
            <?php endif; ?>
        </div>

        <!-- bs notification -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="room_added" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-success text-light">
                    Added, Successfully.
                </div>
            </div>
            <div id="status" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-success text-light">
                    Status updated and email sent!
                </div>
            </div>
            <div id="done" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-success text-light">
                    Booking marked as done.
                </div>
            </div>
            <div id="error" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-danger text-light">
                    Something went wrong.
                </div>
            </div>
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