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
    <script type="module" src="./includes/resource/report_admin.js"></script>


    <!-- charts -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <title>Admin Dashboard</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            /* Hide elements you don't want in the print version */
            button,
            a {
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
                                <h2 class="pageheader-title">Job Analysis</h2>
                                <div class="btn-group m-1">
                                    <button type="button" onclick="window.print()"
                                        class="btn btn-outline-primary">Print</button>
                                    <button type="button" id="logsView" class="btn btn-outline-primary">Report</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- analytics -->
                    <div class="row">
                        <div class="col-xl-2 col-lg-2 col-md-5 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-lead">Job Open</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 id="open_job" class="mb-1 display-5">0</h1>
                                    </div>
                                    <div title="Close"
                                        class="metric-label d-inline-block float-right text-danger font-weight-bold">
                                        <span id="closed_job" style="font-size:20px;">N/A</span>
                                    </div>
                                </div>
                                <div id="sparkline-revenue3"></div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-lead"> Total Applicants</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 id="totaljob" class="mb-1 display-5">0</h1>
                                    </div>
                                </div>
                                <div id="sparkline-revenue3"></div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-5 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <h5 class="text-muted">Departments</h5> -->
                                    <div id="employee_per_dept" style="width:100%; height:300px;"></div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <h5 class="text-muted">Applicants</h5> -->
                                    <div id="applicant_per_dept" style="width:100%; height:300px;"></div>
                                </div>
                                <div id="sparkline-revenue2"></div>
                            </div>
                        </div>

                    </div>

                    <div class="row d-flex report-container">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-6">

                            <div class="card">
                                <div class="card-header d-flex justify-content-between ">
                                    <div class="d-flex ">
                                        <h3 class="">
                                            Job Trend Analysis
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="trendTable" class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Number of Application</th>
                                                <th>Job Title</th>
                                                <th>Department</th>
                                                <!-- <th></th> -->
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>


                        </div>
                        <!-- <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-6">
                        <div class="card">
                                <div class="card-header d-flex justify-content-between ">
                                    <div class="d-flex ">
                                        <h3 class="">
                                            what chart?
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="chart"></div>
                                </div>
                            </div>
                         
                        </div> -->
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
                                <h2 class="pageheader-title">Job Order/Reports </h2>
                                <div class="btn-group m-1">
                                    <button id="analyticView" type="button" class="btn btn-outline-primary">Back</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between ">
                                    <div class="d-flex ">
                                        <h3>
                                            Job Analysis Report
                                        </h3>
                                    </div>
                                    <div>
                                        <button type="button" id="openModalBtn" class="btn btn-outline-primary float-right"
                                            data-toggle="modal" data-target="#reportModal">Generate Report</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="LogbookingTable" style="width: 100%;" class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Job Title</th>
                                                <th>Department</th>
                                                <!-- <th></th> -->
                                                <!-- <th>Time</th>
                                                <th>Purpose</th>
                                                <th>Status</th> -->
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header ">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="">
                                            Manage Job Postings
                                        </h3>
                                        <button type="button" data-toggle="modal" data-target="#AddJob" class="btn"> Post
                                            New Job
                                            <i class="fa-solid fa-circle-plus"></i>

                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="jobPosting" style="width: 100%;" class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Status</th>
                                                <th>Job Title</th>
                                                <th>Action</th>
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

        <!-- add modal -->
        <div id="add-modal" class="row">
            <div class="modal fade" id="AddJob" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Job</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </div>
                        <div class="modal-body">
                            <form id="job_form">
                                <div class="mb-3">
                                    <label for="job_title" class="form-label">Title:</label>
                                    <input type="text" class="form-control" required name="job_title" id="job_title"
                                        placeholder="job title...">
                                </div>
                                <div class="mb-3">
                                    <label for="job_description" class="form-label">Description:</label>
                                    <input type="text" class="form-control" name="job_description" id="job_description"
                                        placeholder="description...">
                                    <!-- <label for="task" class="task-valid d-none text-danger">This field is required!</label> -->
                                </div>
                                <div class="mb-3">
                                    <label for="requirements" class="form-label">Requirements:</label>
                                    <input type="text" class="form-control" name="requirements" id="requirements"
                                        placeholder="requirements...">

                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location:</label>
                                    <input type="text" class="form-control" required name="location" id="location"
                                        placeholder="Location">

                                </div>
                                <div class="mb-3">
                                    <label for="salary_range" class="form-label">Salary Range:</label>
                                    <input type="text" class="form-control" name="salary_range" id="salary_range">
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

        <!-- job_title
job_description
requirements
location
salary_range -->

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
                        <button id="AnalysisGenerateBtn" class="btn btn-outline-primary">Start Generating</button>
                        <button id="downloadBtn" class="btn btn-outline-info" style="display: none;">Download
                            Report</button>
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
            <div id="added" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-success text-light">
                    Added Successfully!
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