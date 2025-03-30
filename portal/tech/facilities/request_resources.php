<?php
session_start();

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != 'employee') {
    header("Location: ../auth/index.php");
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- check if bato-->
    <link rel="stylesheet" href="../../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- datatable:  cs -->
    <link rel="stylesheet" href="../../../node_modules/datatables.net-dt/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- main js -->
    <link rel="stylesheet" href="../../../assets/libs/css/style.css">

    <!-- assts csss -->
    <link rel="stylesheet" href="../../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <!-- icon -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="../../../node_modules/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTable JS -->
    <script src="../../../node_modules/datatables.net/js/dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- main js -->
    <script src="../../../assets/libs/js/main-js.js"></script>

    <!-- slimscroll js -->
    <script src="../../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="../includes/resources_employee.js"></script>


    <title>Admin Dashboard</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header ">
            <nav class="navbar navbar-expand-lg bg-white fixed-top  ">
                <a class="navbar-brand" href="index.php">
                    <img src="../../../assets/images/bcp-hrd-logo.jpg" alt="" class=""
                        style="height: 3rem;width: auto;">
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
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="../../../auth/logout.php"><i
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
        <div class="nav-left-sidebar sidebar-white ">
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
                            <li class="nav-item ">
                                <a class="nav-link " href="../../index.php">
                                    <i class="fas fa-fw fa-home"></i> Dashboard
                                </a>
                            </li>
                            <!-- temp -->
                            <li class="nav-item ">
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
                                            <div id="submenu-1-1" class="collapse submenu bg-light">
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
                            <!-- facilities -->
                            <li class="nav-item ">
                                <a class="nav-link active" href="./index.php" data-toggle="collapse"
                                    aria-expanded="true" data-target="#submenu-2" aria-controls="submenu-2">
                                    <i class="fa fa-fw fa-user-circle"></i>Facilites and Resources
                                    <!-- <span class="badge badge-success">6</span> -->
                                </a>
                                <div id="submenu-2" class="collapse submenu show bg-light">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="./book_facility.php">Book Facility</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="./request_resources.php">Request
                                                Resources</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="./survey.php">Survey</a>
                                        </li> -->
                                    </ul>
                                </div>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-fw fa-columns"></i>Icons</a>
                                <div id="submenu-8" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-fontawesome.html">FontAwesome Icons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-material.html">Material Icons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-simple-lineicon.html">Simpleline Icon</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-themify.html">Themify Icon</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-flag.html">Flag Icons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-weather.html">Weather Icon</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-9" aria-controls="submenu-9"><i class="fas fa-fw fa-map-marker-alt"></i>Maps</a>
                                <div id="submenu-9" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/map-google.html">Google Maps</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/map-vector.html">Vector Maps</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-10" aria-controls="submenu-10"><i class="fas fa-f fa-folder"></i>Menu Level</a>
                                <div id="submenu-10" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Level 1</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-11" aria-controls="submenu-11">Level 2</a>
                                            <div id="submenu-11" class="collapse submenu" style="">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Level 1</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Level 2</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Level 3</a>
                                        </li>
                                    </ul>
                                </div>
                            </li> -->
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
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content ">
                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- <div class="page-header d-flex justify-content-between">
                        <div class="btn-group" role="group" aria-label="Request a Boom or Cancel">
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#requestResourcesModal">
                                <i class="fas fa-fw fa-bell"></i>
                                <span>| Request a resources</span>
                            </button>
                        </div>
                    </div> -->

                    <div class="row">

                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="pageheader-title">Available Items</h2>

                                </div>
                                <div class="card-body">
                                    <table id="ResourcesTable" class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <!-- <td>#</td> -->
                                                <td>Name</td>
                                                <!-- <td>Status</td> -->
                                                <td>Available Quantity</td>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="pageheader-title">Item Request Form
                                        <span class=""
                                            title="Cancellations for requested items are not supported. Please ensure your request is final.">
                                            <i class="bi bi-info-circle-fill text-sm"></i>
                                        </span>
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <form id="resourceRequestForm">
                                        <div class="mb-3">
                                            <label for="resource">Select Resource:</label>
                                            <select id="resource_id" class="form-control" name="resource_id">
                                            </select>
                                        </div>
                                        <input type="hidden" id="employee_id" value="<?= $_SESSION['user_id'] ?>"
                                            name="employee_id" required />
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="quantity">Quantity:</label>
                                                    <input type="number" id="quantity" class="form-control"
                                                        name="quantity" min="1" required />
                                                    <div class="d-none invalid-feedback">
                                                        Requested quantity exceeds available stock.
                                                    </div>
                                                </div>
                                                <div class="col mt-3">
                                                    <div class="input-group">
                                                        <label for="quantity_overview" class="input-group-text"><i
                                                                class="bi bi-archive-fill"></i></label>
                                                        <input type="text" id="quantity_overview" value="0 Stocks"
                                                            class="form-control" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">

                                            <label for="purpose">Purpose:</label>
                                            <textarea id="purpose" name="purpose" class="form-control" rows="10"
                                                required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="submit-request btn btn-outline-primary">Submit
                                                Request</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                    </div>

                    <!-- request resources -->
                    <div id="add-modal" class="row">
                        <div class="modal fade" id="requestResourcesModal" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Request Resources</h4>
                                        <button type="button" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="resourceRequestForm">
                                            <div class="mb-3">
                                                <label for="resource">Select Resource:</label>
                                                <select id="resource_id" class="form-control" name="resource_id">
                                                </select>
                                            </div>
                                            <input type="hidden" id="employee_id" value="<?= $_SESSION['user_id'] ?>"
                                                name="employee_id" required />
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="quantity">Quantity:</label>
                                                        <input type="number" id="quantity" class="form-control"
                                                            name="quantity" min="1" required />
                                                        <div class="d-none invalid-feedback">
                                                            Requested quantity exceeds available stock.
                                                        </div>
                                                    </div>
                                                    <div class="col mt-3">
                                                        <div class="input-group">
                                                            <label for="quantity_overview" class="input-group-text"><i
                                                                    class="bi bi-archive-fill"></i></label>
                                                            <input type="text" id="quantity_overview" value="0 Stocks"
                                                                class="form-control" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">

                                                <label for="purpose">Purpose:</label>
                                                <textarea id="purpose" name="purpose" class="form-control"
                                                    required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit"
                                                    class="submit-request btn btn-outline-primary">Submit
                                                    Request</button>
                                            </div>
                                        </form>

                                        <div id="response"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- bs notification -->
                    <div class="toast-container position-fixed bottom-0 end-0 p-3">
                        <div id="added" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-body bg-success text-light">
                                Added, Successfully.
                            </div>
                        </div>
                        <div id="status" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-body bg-success text-light">
                                Status updated and email sent!
                            </div>
                        </div>
                        <div id="error" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-body bg-danger text-light">
                                Something went wrong.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <!-- <div class="footer mx-2">
                <div class="container-fluid mx-2">
                    <div class="row">
                        <div class="col-xl-7 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        <!-- ============================================================== -->
        <!-- end footer -->
        <!-- ============================================================== -->
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