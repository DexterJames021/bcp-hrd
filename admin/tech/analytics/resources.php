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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
    <script type="module" src="../includes/resource/resources_charts.js"></script>
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
                                <h2 class="pageheader-title">Resources Analytics </h2>
                                <div class="btn-group m-1">
                                    <button type="button" onclick="window.print()"
                                        class="btn btn-outline-primary">Print</button>
                                    <button type="button" id="logsView" class="btn btn-outline-primary">Logs Page</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date">
                        </div>
                        <div class="col-md-2 d-flex  align-items-end">
                            <button id="filterBtn" class="btn btn-primary ">Apply Filter</button>
                            <button id="resetFilterBtn" class="btn btn-outline-primary">Reset</button>
                        </div>

                    </div>

                    <div class="row d-flex">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-6">
                            <!-- donat -->
                            <div class="card">
                                <div class="card-header">
                                    <h4>Categorization Resources</h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="categoryChart"></canvas>
                                </div>
                            </div>

                            <!-- utilization -->
                            <div class="card">
                                <div class="card-header">
                                    <h4>Under Utilized</h4>
                                </div>
                                <!-- utilize -->
                                <div class="card-body" width="100%" height="100%">
                                    <canvas id="unusedResourcesChart"></canvas>
                                </div>
                            </div>


                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-6">

                            <!-- trends -->
                            <div class="card">
                                <div class="card-header">
                                    <h4>Request Trends</h4>
                                </div>
                                <div class="card-header">

                                    <!-- <div class="row">
                                    <div class="col">
                                        <label for="end_date" class="form-label">Year:</label>
                                        <input type="date" id="end_date" class="form-control">
                                    </div>
                                    <div class="col">
                                        <button id="filterBtn" class="btn btn-primary">Filter</button>
                                    </div>
                                </div> -->
                                    <canvas id="requestTrends"></canvas>
                                </div>
                            </div>

                            <!-- usage -->
                            <div class="card">
                                <div class="card-header">
                                    <h4>Ranking Usage</h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="usagePatterns"></canvas>
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
                                <h2 class="pageheader-title">Resources Request Logs </h2>
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
                                    <h1></h1>
                                    
                                    <div class="d-flex ">
                                        <select id="statusFilter" class="form-select mb-3 mx-2" style="width: 250px;">
                                            <option value="">All Statuses</option>
                                            <option value="Returned">Returned</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Rejected">Rejected</option>
                                        </select>
                                        <button type="button" id="openModalBtn" class="btn btn-outline-primary float-right"
                                            data-toggle="modal" data-target="#reportModal">Generate Report</button>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <table id="LogRequestTable" class="table table-hover" width="100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Status</th>
                                                <th>Requested at</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="card-footer"></div>
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
                        <button id="ResourcesGenerateBtn" class="btn btn-outline-primary">Start Generating</button>
                        <button id="downloadBtn" class="btn btn-outline-info" style="display: none;">Download
                            Report</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="error" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-warning text-light">
                    Please select both start and end dates.
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