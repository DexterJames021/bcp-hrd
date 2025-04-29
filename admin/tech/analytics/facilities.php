<?php
include_once __DIR__ . '../../../../config/Database.php';
include_once __DIR__ . '../../../../auth/accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- icon -->
    <link rel="shortcut icon" href="../../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- assts csss -->
    <link rel="stylesheet" href="../../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- main cs -->
    <link rel="stylesheet" href="../../../assets/libs/css/style.css">

    <!-- datatable:  cs -->
    <link rel="stylesheet" href="../../../node_modules/datatables.net-dt/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Bootstrap JS -->
    <script defer src="../../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="../../../node_modules/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTable JS -->
    <script src="../../../node_modules/datatables.net/js/dataTables.min.js"></script>

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
    <script type="module" src="../../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script type="module" src="../../../assets/libs/js/main-js.js"></script>


    <!-- custom js -->
    <script type="module" src="../includes/resource/facility_charts.js"></script>
    <script type="module" src="../includes/resource/report_admin.js"></script>


    <!-- charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php include '../../sideandnavbar.php'; ?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <?php if ($userData && in_array("VIEW", $userData['permissions'])): ?>
                <!-- analytics -->
                <div id="analyticPage" class="container-fluid dashboard-content">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header d-flex justify-content-between">
                                <h2 class="pageheader-title">Facility Analytics </h2>
                                <div class="btn-group m-1">
                                    <button type="button" onclick="window.print()"
                                        class="btn btn-outline-primary">Print</button>
                                    <button type="button" id="logsView" class="btn btn-outline-primary">Logs</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="startDate">Start Date</label>
                            <input type="date" id="startDate" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="endDate">End Date</label>
                            <input type="date" id="endDate" class="form-control">
                        </div>
                        <div class="col-md-2 d-flex  align-items-end">
                            <button class="btn btn-primary" id="applyDateFilter">Apply Filter</button>
                            <button id="resetFilterBtn" class="btn btn-outline-primary">Reset</button>
                        </div>
                    </div>

                    <div class="row d-flex">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-6">
                            <!-- Bookings trend -->
                            <div class="card">
                                <div class="card-header">
                                    <h4>Request Trends</h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="bookingTrends"></canvas>
                                </div>
                            </div>


                            <!-- category -->
                            <div class="card">
                                <div class="card-header">
                                    <h4>List Facility </h4>
                                </div>
                                <div class="card-body">
                                    <table id="facilityTable">
                                        <thead>
                                            <tr>
                                                <td>Facility Name</td>
                                                <td>Location</td>
                                                <td>Capacity</td>
                                                <!-- <td>Status</td> -->
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

                            <!-- utilization -->
                            <div class="card">
                                <div class="card-header">
                                    <h4 style="cursor:pointer;"
                                        title="calculates much a facility is being used compared to its total available capacity">
                                        Over Utilized</h4>
                                </div>
                                <!-- utilize -->
                                <div class="card-body" width="100%" height="100%">
                                    <canvas id="facilityUtilization"></canvas>
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
                                <h2 class="pageheader-title">Facility Booking Logs </h2>
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
                                    <div></div>
                                    <div class="d-flex ">
                                        <label for="statusFilter">Filter by:</label>
                                        <select id="statusFilter" class="form-control mx-2" style="width: 250px;">
                                            <option value="">All Statuses</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Rejected">Rejected</option>
                                            <option value="Cancelled">Cancelled</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                        <!-- <button type="button" id="openModalBtn" class="btn btn-outline-primary float-right"
                                            data-toggle="modal" data-target="#reportModal">Generate Report</button> -->
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <table id="LogbookingTable" class="table table-hover" width="100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <!-- <th>Employee</th> -->
                                                <th>Room</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <!-- <th>Purpose</th> -->
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


        <!-- Modal -->
        <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportModalLabel">Generate Facility Log Report</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <label for="filter" class="my-auto">Filter:</label>
                        <select id="filter" class="form-control">
                            <option value="all">All Logs</option>
                            <option value="today">Today</option>
                            <option value="weekly">This Week</option>
                            <option value="monthly">This Month</option>
                        </select>

                        <div id="loading" class="mt-3 text-center" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Generating...</span>
                            </div>
                            <p>Generating report...</p>
                        </div>

                        <!-- <h5 class="mt-3">AI Report:</h5> -->
                        <p id="aiResponse"></p>
                    </div>
                    <div class="modal-footer">
                        <button id="generateBtn" class="btn btn-outline-primary">Start Generating</button>
                        <button id="downloadBtn" class="btn btn-outline-info" style="display: none;">Download
                            Report</button>
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