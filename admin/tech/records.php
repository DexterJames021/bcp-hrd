<!-- tech record  -->
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

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <!-- <script  src="../../node_modules/jquery/dist/jquery.min.js"></script> -->

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

    <!-- custom js -->
    <script src="./includes/resource/records_admin.js"></script>

    <!-- slimscroll js -->
    <script src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

    <!-- charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @media print {
            .base-salary-print {
                display: none;
            }
        }
    </style>

    <title>Admin Dashboard</title>
</head>

<body>
    <script>
        var userPermissions = <?= json_encode($userData['permissions']); ?>;
        var userRole = <?= json_encode($_SESSION["usertype"]); ?>;
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
        <div class="dashboard-wrapper" id="dashboardWrapper">
            <?php if ($userData && in_array("VIEW", $userData['permissions'])): ?>
                <!-- Employee list Records Section -->
                <div class="container-fluid dashboard-content" id="employeeListView">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h2 class="card-title ">Employees Personnel Records</h2>
                                </div>
                                <div class="card-body p-2">
                                    <div class="table-responsive">
                                        <table id="RecordsTable" class="table table-hover">
                                            <thead class="thead-light">
                                                <tr class="border-0">
                                                    <th class="border-0">Employee ID</th>
                                                    <th class="border-0">Name</th>
                                                    <th class="border-0">Email</th>
                                                    <th class="border-0">Phone</th>
                                                    <th class="border-0">Address</th>
                                                    <th class="border-0">Birthday</th>
                                                    <th class="border-0">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Employee rows will be populated by JS -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employee Details Tab-->
                <div class="container-fluid dashboard-content" id="employeeDetailView" style="display: none;">
                    <div class="row p-2">

                        <!-- overview -->
                        <div class="card">
                            <div class="card-title p-3 m-0 d-flex justify-content-between">
                                <h2>Overview</h2>
                                <div>
                                    <button id="backButton" class="btn btn-outline-light d-inline">Back to
                                        List</button>
                                    <button type="button" onclick="window.print()" class="btn btn-outline-primary">Download
                                        as PDF</button>
                                </div>
                            </div>
                            <div class="row p-0">
                                <div class="row align-items-center">
                                    <!-- Employee Details -->
                                    <div class="col-md-8">
                                        <div class="card">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <span class="fw-bold">Full Name:</span>
                                                    <span id="employeeFullname" class="float-end text-dark">---</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-bold">Job Role:</span>
                                                    <span id="employeeJobRole" class="float-end text-dark">---</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-bold">Department:</span>
                                                    <span id="employeeDepartment" class="float-end text-dark">---</span>
                                                </li>
                                                <li class="list-group-item base-salary-print" >
                                                    <span class="fw-bold">Base Salary:</span>
                                                    <span id="employeeBaseSalary" class="float-end text-dark">---</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-bold">Hired Date:</span>
                                                    <span id="employeeHiredDate" class="float-end text-dark">---</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-bold">Address:</span>
                                                    <span id="employeeAddress" class="float-end text-dark">---</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-bold">Employment Status:</span>
                                                    <span id="employeeStatus" class="float-end text-dark">---</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Performance Score Chart -->
                                    <div class="col-md-4 text-center">
                                        <div class="card px-2">
                                            <canvas id="performanceChart" width="100" height="100"></canvas>
                                            <h3 id="performanceScore" class="">89%</h3>
                                            <i class="fas fa-chart-line"></i> Performance Score
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Training Attended list -->
                        <div class="card ">
                            <div class="card-title p-3 d-flex justify-content-between">
                                <h3><span id="trainingAttendee"></span> Training Attended</h3>
                                <!-- <div>
                                    <button id="backButton" class="btn btn-outline-light d-inline">Back to List</button>
                                </div> -->
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Training Name</th>
                                            <th>Description</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Instructor</th>
                                            <th>Training Status</th>
                                            <th>Completion Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="trainingList"></tbody>
                                </table>
                            </div>

                        </div>

                        <!-- Compensation  list -->
                        <!-- <div class="card ">
                            <div class="card-title p-3 d-flex justify-content-between">
                                <h3><span id="compensationName"></span>Compensation and Benefits</h3>
                               
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Base Salary</th>
                                            <th>Bonus</th>
                                            <th>Benefit Value</th>
                                        </tr>
                                    </thead>
                                    <tbody id="compensationList"></tbody>
                                </table>
                            </div>

                        </div> -->

                        <!-- employee info -->
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h2 class="card-title ">Employees Records</h2>
                            </div>
                            <div class="card-body">
                                <div id="editEmployeeForm">

                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col">
                                                <span class="fw-bold text-dark" for="edit_name">First Name:</span>
                                                <div id="edit_name" class=""></div>
                                            </div>
                                            <div class="col">
                                                <span class="fw-bold text-dark" for="edit_LastName">Last Name:</span>
                                                <div type="text" name="edit_LastName" id="edit_LastName"
                                                    class=""></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col">
                                                <span class="fw-bold text-dark" for="edit_email">Email:</span>
                                                <div type="email" name="edit_email" id="edit_email" class=""
                                                    ></div>
                                            </div>
                                            <div class="col">
                                                <span class="fw-bold text-dark" for="edit_phone">Phone:</span>
                                                <div type="text" name="edit_phone" id="edit_phone" class=""
                                                    ></div>
                                            </div>
                                            <div class="col">
                                                <span class="fw-bold text-dark" for="edit_birthday">Birthday:</span>
                                                <div type="date" name="edit_birthday" id="edit_birthday"
                                                    class="" ></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <span class="fw-bold text-dark" for="edit_address">Address:</span>
                                        <div type="text" name="edit_address" id="edit_address" class=""
                                            ></div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- <div>JOB description:
                                            overview: employee records, department ;<br>
                                            Performance: trainings attended, Chart evaluation rate<br>
                                            Compensation: salary payrolls <br>
                                            user acccounts (optional) <br>
                                            ATTACHMENTS:</div> -->
                    </div>
                </div>

                <!-- promotion -->
                <div id="add-modal" class="row">
                    <div class="modal fade" id="promotionModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Assign job/Promotion</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                                </div>
                                <div class="modal-body">
                                    <form id="promotion_form">
                                        <input type="hidden" class="form-control" required name="employee_id"
                                            id="employee_id" placeholder="Asset Name">
                                        <div class="mb-3">
                                            <label for="status">Job Title:</label>
                                            <select name="job_id" id="job_titles" class="form-control  required form-select"
                                                aria-label="Default select example" required='required'>
                                            </select>
                                        </div>
                                        <div class="job-details">
                                            <!-- mga content ng job -->
                                        </div>
                                        <div class="">
                                            <button type="submit" id="submit-btn" class="btn btn-primary">Save</button>
                                            <button type="button" id="close" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- salary -->
                <div id="add-modal" class="row">
                    <div class="modal fade" id="salaryModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Saraly</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                                </div>
                                <div class="modal-body">
                                    <form id="salary">
                                        <input type="hidden" class="form-control" required name="employee_id"
                                            id="employee_id" placeholder="Asset Name">
                                        <div class="mb-3">
                                            <label for="status">Salary:</label>
                                            <input type="number" class="form-control" required name="salary"
                                            id="salary" placeholder="">
                                        </div>
                                        <div class="job-details">
                                            <!-- mga content ng job -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="submit-btn" class="btn btn-primary">Save</button>
                                            <button type="button" id="close-btn" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
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
                    <div id="required" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body bg-success text-light">
                            All fields are required
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <?php include_once "../403.php"; ?>
            <?php endif; ?>
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