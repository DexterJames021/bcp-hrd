<?php
require '../../config/Database.php';
require '../../auth/accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- icon -->
    <link rel="shortcut icon" href="../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">
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

    <!-- main js -->
    <script src="../notif.js"></script>

    <!-- slimscroll js -->
    <script src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="./includes/resources_employee.js"></script>


    
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>



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
                        <!-- <div class="page-header d-flex justify-content-between">
                        <div class="btn-group" role="group" aria-label="Request a Boom or Cancel">
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#requestResourcesModal">
                                <i class="fas fa-fw fa-bell"></i>
                                <span>| Request a resources</span>
                            </button>
                        </div>
                    </div> -->

                        <div class="col-md-6">
                            <div class="col-lg-6 col-md-12">
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

                            <div class="col-lg-6 col-md-12">
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
                                                <?php if ($userData && in_array("CREATE", $userData['permissions'])): ?>
                                                    <button type="submit" class="submit-request btn btn-outline-primary">Submit
                                                        Request</button>
                                                <?php else: ?>
                                                    <button type="submit" disabled class="submit-request btn btn-outline-primary">Submit
                                                        Request</button>
                                                <?php endif; ?>
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
                <?php else: ?>
                    <?php include_once "../../403.php"; ?>
                <?php endif; ?>
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