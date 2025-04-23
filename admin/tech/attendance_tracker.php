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
    <script src="./includes/resource/attendance.js"></script>

    <title>Admin Dashboard</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php include '../sideandnavbar.php'; ?>
        <!-- ============================================================== -->
        <!-- endleft sidebar -->
        <!-- ============================================================== -->
    </div>


    <div class="dashboard-wrapper">
        <?php if ($userData && in_array("VIEW", $userData['permissions'])): ?>
            <!-- analytics -->
            <div id="initialView" class="container-fluid dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header d-flex justify-content-between">
                            <h2 class="pageheader-title">Attendance Tracker </h2>
                            <div class="btn-group m-1">
                                <!-- <button type="button" onclick="window.print()"
                                    class="btn btn-outline-primary">Print</button> -->
                                <button type="button" id="logsView" class="btn btn-outline-primary">Logs</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="col-md-6 py-2">
                                    <!-- <div class="input-group">
                                            <input type="text" id="employeeSearch" class="form-control"
                                                placeholder="Search employee...">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary time-in-btn" type="button">Time In</button>
                                                <button class="btn btn-secondary time-out-btn" type="button">Time
                                                    Out</button>
                                            </div>
                                        </div> -->
                                </div>
                                <div class="col-md-6 text-right">
                                    <button id="importCsvBtn" class="btn btn-outline-primary">Import CSV</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="attendancetable" style="width: 100%;" class="table table-hover">
                                    <thead class="thead-light"></thead>
                                </table>
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
                            <h2 class="pageheader-title">Attendance Analytics  </h2>
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
                                    <button id="importCsvBtn" class="btn btn-outline-primary">Import CSV</button>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
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

            <!-- Toast Notifications Container -->
            <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100"></div>

            <!-- CSV Import Modal -->
            <div class="modal fade" id="csvImportModal" tabindex="-1" role="dialog" aria-labelledby="csvImportModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="csvImportModalLabel">Import Attendance from CSV</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="csvImportForm">
                                <div class="form-group">
                                    <label for="csvFile">Select CSV File</label>
                                    <input type="file" class="form-control-file" id="csvFile" name="csvFile" accept=".csv"
                                        required>
                                    <small class="form-text text-muted">
                                        CSV format: employee_id,date,time_in,time_out,status
                                    </small>
                                </div>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <?php include_once "../../403.php"; ?>
        <?php endif; ?>
    </div>


    <!-- ============================================================== -->
    <!-- end wrapper  -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
</body>

</html>