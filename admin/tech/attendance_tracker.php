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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- main cs -->
    <link rel="stylesheet" href="../../assets/libs/css/style.css">

    <!-- datatable:  cs -->
    <link rel="stylesheet" href="../../node_modules/datatables.net-dt/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Bootstrap JS -->
    <script defer src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- custom js -->
    <script src="./includes/resource/attendance.js"></script>
    <script src="./includes/resource/atendance_analytics.js"></script>

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
                            <h2 class="pageheader-title">Attendance Management </h2>
                            <div class="btn-group m-1">
                                <!-- <button type="button" onclick="window.print()"
                                    class="btn btn-outline-primary">Print</button> -->
                                <button type="button" id="logsView" class="btn btn-outline-primary">Attendance
                                    Analytics</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="col-md-6 py-2">
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
                            <h2 class="pageheader-title">Attendance Analytics </h2>
                            <div class="btn-group m-1">
                                <button id="analyticView" type="button" class="btn btn-outline-primary">Back</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Filters -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Date Range</label>
                                <div class="input-group">
                                    <input type="date" id="startDate" class="form-control">
                                    <span class="input-group-text">to</span>
                                    <input type="date" id="endDate" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Employee</label>
                                <select id="employeeFilter" class="form-control">
                                    <option value="">All Employees</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">View Type</label>
                                <select id="viewType" class="form-control">
                                    <option value="daily">Daily Summary</option>
                                    <option value="monthly">Monthly Summary</option>
                                    <option value="trends">Trend Analysis</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button id="applyFilters" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i>Apply Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0" id="dataTableTitle">Daily Attendance Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-striped" style="width:100%">
                                        <thead class="thead-light" style="background-color:#f8f9fa !important;"></thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Attendance Distribution</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="attendanceChart" height="500"></canvas>
                            </div>
                        </div>

                        <!-- <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Attendance Trend</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="trendChart" height="300"></canvas>
                            </div>
                        </div> -->
                    </div>
                </div>

            </div>

            <!-- Toast Container - Place this in your layout -->
            <!-- <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100"></div> -->

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

            <!-- bs notification -->
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div id="added" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body bg-success text-light">
                            Imported Successfully!
                        </div>
                    </div>
                    <div id="error" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body bg-danger text-light">
                            Something went wrong.
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