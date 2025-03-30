<!-- Resources -->
<?php
include_once '../../config/Database.php';
include_once '../../auth/accesscontrol.php';

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

    <link rel="stylesheet" href="./includes/error.css">

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <!-- <script  src="../../node_modules/jquery/dist/jquery.min.js"></script> -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- core DataTable JS -->
    <!-- <script src="../../node_modules/datatables.net/js/dataTables.min.js"></script> -->
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
    <script src="./includes/resource/resources_admin.js"></script>

    <!-- slimscroll js -->
    <script src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>


    <title>Tech and Analytics</title>
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
                                <a class="dropdown-item" href="./settings/emp-info.php<?= $id['EmployeeID'] ?>"><i
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
        <?php include '../sideandnavbar.php'; ?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->

        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content ">
                <?php if ($userData && in_array("VIEW", $userData['permissions'])): ?>
                    <!-- analytics -->
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Total Resources</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 id="total-card" class="mb-1">0</h1>
                                    </div>
                                    <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                        <!-- <span><i class="fa fa-fw fa-arrow-up"></i></span><span>0.1%</span> -->
                                    </div>
                                </div>
                                <div id="sparkline-revenue"></div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">In Maintenance</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 id="on-book" class="mb-1">0</h1>
                                    </div>
                                    <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                        <!-- <span><i class="fa fa-fw fa-arrow-up"></i></span><span>0.00%</span> -->
                                    </div>
                                </div>
                                <div id="sparkline-revenue2"></div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Available</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 id="available" class="mb-1">0.00</h1>
                                    </div>
                                    <div class="metric-label d-inline-block float-right text-primary font-weight-bold">
                                        <span>N/A</span>
                                    </div>
                                </div>
                                <div id="sparkline-revenue3"></div>
                            </div>
                        </div>
                    </div>

                    <!-- tab navigation -->
                    <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="resources-booking-tab" data-toggle="tab"
                                href="#resources-booking" role="tab" aria-controls="resources-booking"
                                aria-selected="true">Request</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="resources-allocation-tab" data-toggle="tab" href="#resources-allocation"
                                role="tab" aria-controls="resources-allocation" aria-selected="false">Allocation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="resources-list-tab" data-toggle="tab" href="#resources-list" role="tab"
                                aria-controls="resources-list" aria-selected="false">List</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="dashboardTabContent">

                        <!-- booking Tab -->
                        <div class="tab-pane fade show active" id="resources-booking" role="tabpanel"
                            aria-labelledby="resources-booking-tab">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <h1>Requests Resources </h1>
                                            <!-- <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-primary float-right"
                                                data-toggle="modal" data-target="#requestModal">Request Resources</button>
                                        </div> -->
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-hover" style="width:100%" id="requestsTable">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>by</th>
                                                        <th>resource</th>
                                                        <th>Quantity</th>
                                                        <th>Requested at</th>
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

                        <!-- allocation Tab -->
                        <div class="tab-pane fade" id="resources-allocation" role="tabpanel"
                            aria-labelledby="resources-allocation-tab">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <h2 class="card-title">Resources Allocation
                                                <span class=""
                                                    title="Tracking allocation involves recording details about who is using a resource, for how long, and the status of that allocation (e.g., ongoing, returned, overdue).">
                                                    <i class="bi bi-info-circle-fill text-sm"></i>
                                                </span>
                                            </h2>
                                            <div class="btn-group">
                                                <?php if ($userData && in_array("CREATE", $userData['permissions'])): ?>
                                                    <button type="button" class="btn btn-outline-primary float-right"
                                                        data-toggle="modal" data-target="#allocateForm">Allocate
                                                        Resource</button>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-outline-primary float-right"
                                                        data-toggle="modal" data-target="#allocateForm" disabled>Allocate
                                                        Resource</button>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-hover" style="width:100%" id="allocationTable">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Resource</th>
                                                        <th>Employee</th>
                                                        <th>Quantity</th>
                                                        <th>Start</th>
                                                        <th>End</th>
                                                        <th>Status</th>
                                                        <th>Returned</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- list Tab -->
                        <div class="tab-pane fade" id="resources-list" role="tabpanel" aria-labelledby="resources-list-tab">
                            <!-- list -->
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <h2 class="card-title">Resources Management</h2>
                                            <div class="btn-group">
                                                <?php if ($userData && in_array("CREATE", $userData['permissions'])): ?>
                                                    <button type="button" class="btn btn-outline-primary float-right"
                                                        data-toggle="modal" data-target="#addAsset">+</button>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-outline-primary float-right"
                                                        data-toggle="modal" data-target="#addAsset" disabled>+</button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="ResourcesTable" style="width: 100%;" class="table table-hover">
                                                    <thead class="thead-light">
                                                        <tr class="border-0">
                                                            <th class="border-0">#</th>
                                                            <th class="border-0">Name</th>
                                                            <th class="border-0">Category</th>
                                                            <th class="border-0">Quantity</th>
                                                            <th class="border-0">Location</th>
                                                            <th class="border-0">Status</th>
                                                            <th class="border-0">Last maintenance</th>
                                                            <th class="border-0">Next maintenance</th>
                                                            <th class="border-0">Created at</th>
                                                            <?php if ($userData && in_array("CREATE", $userData['permissions'])): ?>
                                                                <th class="border-0">Action</th>
                                                            <?php else: ?>
                                                                <th class=" border-0">Action</th>
                                                            <?php endif; ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                <?php else: ?>
                    <?php include_once "../403.php"; ?>
                <?php endif; ?>
            </div>

            <!-- add modal -->
            <div id="add-modal" class="row">
                <div class="modal fade" id="addAsset" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Asset</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">
                                <form id="assets_form">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name:</label>
                                        <input type="text" class="form-control" required name="name" id="name"
                                            placeholder="Asset Name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category:</label>
                                        <input type="text" class="form-control" name="category" id="category"
                                            placeholder="Category">
                                        <!-- <label for="task" class="task-valid d-none text-danger">This field is required!</label> -->
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity:</label>
                                        <input type="number" class="form-control" name="quantity" id="quantity"
                                            placeholder="Quantity">

                                    </div>
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Location:</label>
                                        <input type="text" class="form-control" required name="location" id="location"
                                            placeholder="Location">

                                    </div>
                                    <div class="mb-3">
                                        <label for="status">Status:</label>
                                        <select name="status" id="status" class="form-control  required form-select"
                                            id="assign" aria-label="Default select example" required='required'>
                                            <option value="Available">Available</option>
                                            <option value="In Maintenance">In Maintenance</option>
                                            <option value="Damaged">Damaged</option>
                                            <label for="assign" class="assign-valid d-none text-danger">This field is
                                                required!</label>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="last_maintenance" class="form-label">Last Maintenance:</label>
                                        <input type="date" class="form-control" name="last_maintenance"
                                            id="last_maintenance">
                                    </div>
                                    <div class="mb-3">
                                        <label for="next_maintenance" class="form-label">Next Maintenance:</label>
                                        <input type="date" class="form-control" name="next_maintenance"
                                            id="next_maintenance">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="submit-btn" class="btn btn-primary">Submit</button>
                                        <button type="button" id="close-btn" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--  edit resources modal -->
            <div id="add-modal" class="row">
                <div class="modal fade" id="EditResourcesModal" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Asset</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="editResourceFrom">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name:</label>
                                        <input type="text" class="form-control" required name="edit_name" id="edit_name"
                                            placeholder="Asset Name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category:</label>
                                        <input type="text" class="form-control" name="edit_category" id="edit_category"
                                            placeholder="Category">
                                        <!-- <label for="task" class="task-valid d-none text-danger">This field is required!</label> -->
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity:</label>
                                        <input type="number" class="form-control" name="edit_quantity"
                                            id="edit_quantity" placeholder="Quantity">

                                    </div>
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Location:</label>
                                        <input type="text" class="form-control" required name="edit_location"
                                            id="edit_location" placeholder="Location">

                                    </div>
                                    <div class="mb-3">
                                        <label for="status">Status:</label>
                                        <select name="edit_status" id="edit_status" class="form-control form-select"
                                            aria-label="Default select example" required='required'>
                                            <option value="Available">Available</option>
                                            <option value="In Maintenance">In Maintenance</option>
                                            <option value="Damaged">Damaged</option>
                                            <label for="assign" class="assign-valid d-none text-danger">This field is
                                                required!</label>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="last_maintenance" class="form-label">Last Maintenance:</label>
                                        <input type="date" class="form-control" name="edit_last_maintenance"
                                            id="edit_last_maintenance">
                                    </div>
                                    <div class="mb-3">
                                        <label for="next_maintenance" class="form-label">Next Maintenance:</label>
                                        <input type="date" class="form-control" name="edit_next_maintenance"
                                            id="edit_next_maintenance">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="submit-btn" class="btn btn-primary">Submit</button>
                                        <button type="button" id="close-btn" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- allocation -->
            <div id="add-modal" class="row">
                <div class="modal fade" id="allocateForm" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Allocate</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">
                                <form id="resourceAllocationForm">
                                    <div class="mb-3">
                                        <label for="allocate">Name:</label>
                                        <select id="allocate_id" name="allocate_id" class="form-control" required>
                                        </select>
                                    </div>
                                    <input type="hidden" id="employee_id" class="form-control"
                                        value="<?= $_SESSION['user_id'] ?>" name="employee_id" />
                                    <div class="mb-3">
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" id="quantity" class="form-control" name="quantity" min="1"
                                            required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="allocation_start">Allocation Start</label>
                                        <input type="datetime-local" id="allocation_start" class="form-control"
                                            name="allocation_start" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="allocation_end">Allocation End</label>
                                        <input type="datetime-local" id="allocation_end" class="form-control"
                                            name="allocation_end" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="notes">Notes:</label>
                                        <textarea id="notes" name="notes" class="form-control"
                                            placeholder="Notes (optional)"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-outline-primary">Allocate Resource</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- request resources -->
            <div id="add-modal" class="row">
                <div class="modal fade" id="requestModal" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h4 class="modal-title">Request Resources</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="resourceRequestForm">
                                    <div class="mb-3">
                                        <label for="resource">Select Resource:</label>
                                        <select id="resource_id" class="form-control" name="resource_id">
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col">
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" id="quantity" class="form-control" name="quantity"
                                                    min="1" required />
                                                <div class="d-none invalid-feedback">
                                                    Requested quantity exceeds available stock.
                                                </div>
                                                <input type="hidden" id="employee_id"
                                                    value="<?= $_SESSION['user_id'] ?>" name="employee_id" required />
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
                                        <textarea id="purpose" name="purpose" class="form-control" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="submit-request btn btn-outline-primary">Submit
                                            Request</button>
                                    </div>
                                </form>

                                <div id="response"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- bs toast  -->
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="deleted" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-danger text-light">
                        Deleted, Successfully.
                    </div>
                </div>
                <div id="error" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-warning text-light">
                        Something went wrong.
                    </div>
                </div>
                <div id="added" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Added, Successfully.
                    </div>
                </div>
                <div id="updated" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Updated, Successfully.
                    </div>
                </div>
                <div id="approved" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Updated, Successfully.
                    </div>
                </div>
                <div id="rejected" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-danger text-light">
                        Updated, Successfully.
                    </div>
                </div>
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