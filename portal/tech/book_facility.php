<?php
require '../../config/Database.php';
require '../../auth/accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

?>
<!doctype html>
<html lang="en">

<head>
    <script>
        var userPermissions = <?= json_encode($userData['permissions']); ?>;
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- icon -->
    <link rel="shortcut icon" href="../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- datatable:  cs -->
    <link rel="stylesheet" href="../../node_modules/datatables.net-dt/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- main css -->
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
    <!-- <script src="../../node_modules/jquery/dist/jquery.min.js"></script> -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- calendar js -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <!-- main js -->
    <script src="../../assets/libs/js/main-js.js"></script>

    <!-- custom js -->
    <script src="./includes/facility_employee.js"></script>


    <!-- slimscroll js -->
    <script src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

    <title>Employee Dashboard</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
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
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header d-flex justify-content-between">
                                <h2 class="pageheader-title">Events and Booking </h2>
                                <div class="btn-group" role="group" aria-label="Request a Boom or Cancel">
                                    <?php if ($userData && in_array("CREATE", $userData['permissions'])): ?>
                                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                            data-target="#Addbooking">
                                            <i class="fas fa-fw fa-bell"></i>
                                            <span>| Request a Room</span>
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                            data-target="#Addbooking" disabled>
                                            <i class="fas fa-fw fa-bell"></i>
                                            <span>| Request a Room</span>
                                        </button>
                                    <?php endif; ?>

                                    <!-- <button type="button"
                                    class="view-status-btn btn btn-outline-primary float-right"
                                    data-id="< ?= $_SESSION['user_id'] ?>" >
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    View Status Request
                                    <i class="fas fa-fw fa-bell"></i>
                                </button> -->

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="facilityCalendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- clcik Booking Modal -->
                    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bookingModalLabel">Book Facility</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="bookingForm">
                                    <div class="modal-body">
                                        <input type="hidden" name="employee_id" value="<?= $_SESSION['user_id'] ?>">
                                        <div class="mb-3">
                                            <label for="roomSelect" class="form-label">Select Facility</label>
                                            <select id="roomSelect" name="room_id" class="form-control" required>
                                                <option value="">Select Room</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="bookingDate" class="form-label">Booking Date</label>
                                            <input type="text" id="bookingDate" name="booking_date" class="form-control"
                                                readonly>
                                        </div>
                                        <div class="mb-2">
                                            <label for="start_time" class="form-label">Start Time</label>
                                            <input type="time" name="start_time" id="start_time" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="end_time" class="form-label">End Time</label>
                                            <input type="time" name="end_time" id="end_time" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="bookingReason" class="form-label">Reason for Booking</label>
                                            <textarea id="bookingReason" name="purpose" class="form-control" rows="3"
                                                required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-outline-primary">Submit Booking</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Event Details Modal -->
                    <div class="modal fade" id="eventBookedModal" tabindex="-1" aria-labelledby="eventBookedModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eventBookedModalLabel">Facility Booked</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="eventDetails"></div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- book a facility -->
                    <div id="add-modal" class="row">
                        <div class="modal fade" id="Addbooking" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="bookingModalLabel">Book Facility</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="bookingForm2">
                                            <input type="hidden" name="employee_id" value="<?= $_SESSION['user_id'] ?>">

                                            <div class="mb-2">
                                                <label for="roomSelect2" class="form-label">Select Facility</label>
                                                <select name="room_id" id="roomSelect2" class="form-control" required>
                                                    <option value="">Select Room</option>
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label for="bookingReason" class="form-label">Booking Date</label>
                                                <input type="date" id="bookDateForm" name="booking_date" class="form-control" required>
                                            </div>
                                            <div class="mb-2">
                                                <label for="bookingReason" class="form-label">Start Time</label>
                                                <input type="time" name="start_time" class="form-control" required>
                                            </div>
                                            <div class="mb-2">
                                                <label for="bookingReason" class="form-label">End Time</label>
                                                <input type="time" name="end_time" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="bookingReason" class="form-label">Reason for Booking</label>
                                                <textarea id="bookingReason" name="purpose" class="form-control" rows="3"
                                                    required></textarea>
                                            </div>
                                            <div class="mb-2">
                                                <button type="submit" class="btn btn-outline-primary">Submit
                                                    Booking</button>
                                            </div>
                                        </form>
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
            <div class=" z-3 toast-container position-fixed bottom-0 end-0 p-3 ">
                <div id="status" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Request Successfully, Please Wait for Approval.
                    </div>
                </div>
                <div id="cancel" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Request Cancel Successfully.
                    </div>
                </div>
                <div id="error" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-danger text-light">
                        Something went wrong.
                    </div>
                </div>
                <div id="pastDate" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-danger text-light">
                        You cannot book past dates!
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