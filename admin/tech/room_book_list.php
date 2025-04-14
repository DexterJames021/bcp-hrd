<?php
include_once __DIR__ . '../../../config/Database.php';
include_once __DIR__ . '../../../auth/accesscontrol.php';

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

    <!-- assts csss -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <!-- icon -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />

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

    <!-- main js -->
    <script src="../../assets/libs/js/main-js.js"></script>

    <!-- custom -->
    <script src="./includes/resource/facility_admin.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


    <!-- slimscroll js -->
    <script src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

    <title>Admin Dashboard</title>
</head>

<body>
    <script>
        var userPermissions = <?= json_encode($userData['permissions']); ?>;
        var userID = <?= json_encode($_SESSION['user_id']); ?>;
    </script>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">

        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php include '../sideandnavbar.php'; ?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper overflow-y-hidden overflow-x-hidden">
            <div class="container-fluid dashboard-content">
                <?php if ($userData && in_array("VIEW", $userData['permissions'])): ?>
                    <!-- analytics -->
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Total Facilities</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 id="total-card" class="mb-1">0</h1>
                                    </div>
                                </div>
                                <div id="sparkline-revenue"></div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Booked</h5>
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
                                </div>
                                <div id="sparkline-revenue3"></div>
                            </div>
                        </div>
                    </div>

                    <!-- tab navigation -->
                    <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="facility-booking-tab" data-toggle="tab" href="#facility-booking"
                                role="tab" aria-controls="facility-booking" aria-selected="true">Facility Booking</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="facility-pending-tab" data-toggle="tab" href="#facility-pending"
                                role="tab" aria-controls="facility-pending" aria-selected="false">Facility Pending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="facility-list-tab" data-toggle="tab" href="#facility-list" role="tab"
                                aria-controls="facility-list" aria-selected="false">Facility List</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="dashboardTabContent">
                        <!-- booking Tab -->
                        <div class="tab-pane fade show active" id="facility-booking" role="tabpanel"
                            aria-labelledby="facility-booking-tab">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <h1>Booking</h1>
                                            <div class="btn-group" role="group">
                                                <!-- <button type="button" class="btn btn-outline-primary rounded-circle  float-right" data-toggle="modal" data-target="#Addbooking">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                                    <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5" />
                                                    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z" />
                                                </svg>
                                            </button> -->
                                                <!-- <button type="button"  class="btn btn-primary float-right" data-toggle="modal" data-target="#Addbooking">Book a Facility</button> -->
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table id="bookingTable" class="table table-hover ">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Employee</th>
                                                        <th>Room</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Purpose</th>
                                                        <th>Status</th>
                                                        <th class="text-lg">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- pending Tab -->
                        <div class="tab-pane fade " id="facility-pending" role="tabpanel" style="width:100%;"
                            aria-labelledby="facility-pending-tab">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <h2>Pending</h2>
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table id="approvedTable" class="table table-hover ">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <!--<th>By</th>-->
                                                        <th>Facility Name</th>
                                                        <th col="2">Location</th>
                                                        <!-- <th>Capacity</th> -->
                                                        <th>Status</th>
                                                        <th>Booking Date</th>
                                                        <th>Start Time</th>
                                                        <th>End Time</th>
                                                        <th>Checkout Action</th>
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
                        <div class="tab-pane fade" id="facility-list" role="tabpanel" aria-labelledby="facility-list-tab">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <h2>Facility Lists</h2>
                                            <?php if ($userData && in_array("CREATE", $userData['permissions'])): ?>
                                                <button type="button" class="btn float-right" data-toggle="modal"
                                                    data-target="#AddroomModal">
                                                    <i class="bi bi-plus-circle-fill text-primary"
                                                        style="font-size:x-large;"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn float-right" data-toggle="modal"
                                                    data-target="#AddroomModal" disabled>
                                                    <i class="bi bi-plus-circle-fill text-primary"
                                                        style="font-size:x-large;"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-body">
                                            <table id="roomTable" class="table table-hover" width="100% ">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Location</th>
                                                        <th>Capacity</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
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
            <!-- modal book a facility -->
            <div id="add-modal" class="row">
                <div class="modal fade" id="Addbooking" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Book a Facility</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">
                                <form id="bookingForm">
                                    <input type="hidden" name="employee_id" value="<?= $_SESSION['user_id'] ?>">

                                    <div class="mb-2">
                                        <select name="room_id" id="roomSelect" class="form-control" required>
                                            <option value="">Select Room</option>
                                        </select>
                                    </div>
                                    <!-- <div class="mb-2">
                                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                                    </div> -->
                                    <div class="mb-2">
                                        <input type="date" name="booking_date" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <input type="time" name="start_time" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <input type="time" name="end_time" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="purpose" class="form-control" placeholder="Purpose of Booking"
                                            required></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <button type="submit" class="btn btn-primary">Book Room</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal edit facility -->
            <div id="add-modal" class="row">
                <div class="modal fade" id="editRoomModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Facility</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="EditFacilityForm">
                                    <input type="hidden" name="edit_id" id="fm_id">
                                    <div class="mb-2">
                                        <label for="edit_name">Facility Name:</label>
                                        <input type="text" name="edit_name" id="edit_name" class="form-control"
                                            required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="edit_location">Location:</label>
                                        <input type="text" name="edit_location" id="edit_location" class="form-control"
                                            required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="edit_capacity">Capacity:</label>
                                        <input type="number" name="edit_capacity" id="edit_capacity"
                                            class="form-control" required>
                                    </div>
                                    <!-- <div class="mb-2">
                                        <label for="edit_status">Status:</label>
                                        <select name="edit_status" id="edit_status" class="form-control">
                                            <option selected value="Available">Available</option>
                                        </select>
                                    </div> -->
                                    <div class="mb-2">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purpose Modal -->
            <div class="modal fade" id="purposeModal" tabindex="-1" role="dialog" aria-labelledby="purposeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Purpose</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p id="purposeText"></p>
                        </div>
                        <div class="modal-footer bg-light">
                            <a id="downloadPurpose" class="btn btn-sm " download="purpose.txt">
                                <i class="bi bi-download" style="font-size:x-large;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- add room -->
            <div id="add-modal" class="row">
                <div class="modal fade" id="AddroomModal" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Facility</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">
                                <form id="newFacilityForm">
                                    <div class="mb-2">
                                        <label for="fm_name" class="form-label">Name:</label>
                                        <input type="text" name="fm_name" id="fm_name" class="form-control"
                                            placeholder="Facility Name" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="fm_location" class="form-label">Location:</label>
                                        <input type="text" name="fm_location" id="fm_location" class="form-control"
                                            placeholder="Location" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="fm_capacity" class="form-label">Capacity:</label>
                                        <input type="number" name="fm_capacity" id="fm_capacity" class="form-control"
                                            placeholder="Capacity" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="fm_status" class="form-label">Status:</label>
                                        <select name="fm_status" id="fm_status" class="form-control">
                                            <option value="Available">Available</option>
                                            <option value="Maintenance  ">Maintenance</option>
                                            <option value="Damaged">Damaged</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Add Facility</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
                <div id="room_updated" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Update Facility Successfully.
                    </div>
                </div>
                <div id="delete" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Delete Facility Successfully.
                    </div>
                </div>
                <div id="done" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Booking marked as done.
                    </div>
                </div>
                <div id="error" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-danger text-light">
                        <span class="message">Something went wrong.</span>
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