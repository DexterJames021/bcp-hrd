<!-- tech record  -->
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

    <!-- slimscroll js -->
    <script src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

    <script src="./includes/resource/usercontrol.js"></script>

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
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content ">
                <!-- tab navigation -->
                <!-- <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="role-permission-tab" data-toggle="tab" href="#role-permission"
                            role="tab" aria-controls="role-permission" aria-selected="true">Roles & Permission</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="roles-tab" data-toggle="tab" href="#roles" role="tab"
                            aria-controls="roles" aria-selected="false">Roles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="permissions-tab" data-toggle="tab" href="#permissions" role="tab"
                            aria-controls="permissions" aria-selected="false">Permissions</a>
                    </li>
                </ul> -->

                <!-- Tab Content -->
                <!-- <div class="tab-content" id="dashboardTabContent"> -->
                <!-- role spermission Tab -->
                <!-- <div class="tab-pane fade show active" id="role-permission" role="tabpanel"
                        aria-labelledby="role-permission-tab"> -->
                <!-- table user role -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-text-center">
                                <h2 class="card-title ">Roles and Permissions</h2>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary float-right"
                                        data-toggle="modal" data-target="#NewRole">+ Roles</button>
                                    <!-- <button type="button" class="btn btn-outline-primary float-right"
                                                data-toggle="modal" data-target="#NewPermission">+ Permission</button>  -->
                                    <button type="button" class="btn btn-outline-primary float-right"
                                        data-toggle="modal" data-target="#AsignAccess">+ Assign</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="usercontrolTable" class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Role/th>
                                                <th>Permission</th>
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
            </div>

            <!-- roles Tab -->
            <!-- <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-text-center">
                                        <h2 class="card-title ">Roles</h2>
                                        <div>
                                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                                data-target="#NewRole">+</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="rolesTable" class="table table-hover" style="width:100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                         <th>Role ID</th> 
                                                        <th>Role Name</th>
                                                        <th>Description</th>
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
                    </div> -->

            <!-- permision Tab -->
            <!-- <div class="tab-pane fade" id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-text-center">
                                        <h2 class="card-title ">Permission</h2>
                                        <div>
                                             <button type="button" class="btn btn-outline-primary"
                                            data-toggle="modal" data-target="#NewPermission">+</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="permissionTable" class="table table-hover" style="width:100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Permission</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

            <!-- </div> -->

            <!-- modaladd roles -->
            <div id="add-modal" class="row">
                <div class="modal fade" id="NewRole" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New Role</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">
                                <form id="new_role_form">

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Role Name:</label>
                                        <input type="text" class="form-control" required name="RoleName" id="RoleName"
                                            placeholder="Role title">
                                    </div>
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Description:</label>
                                        <input type="text" class="form-control" name="Description" id="Description"
                                            placeholder="description...">
                                        <!-- <label for="task" class="task-valid d-none text-danger">This field is required!</label> -->
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

            <!-- modal add permision -->
            <div id="add-modal" class="row">
                <div class="modal fade" id="NewPermission" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New Permission</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">
                                <form id="new_permission_form">

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name:</label>
                                        <input type="text" class="form-control" required name="name" id="name"
                                            placeholder="Asset Name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Description:</label>
                                        <input type="text" class="form-control" name="description" id="description"
                                            placeholder="description">
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

            <!-- Assign Role & Permission Modal -->
            <div class="modal fade" id="AsignAccess" role="dialog" aria-labelledby="editPermissionModalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign Permissions</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editPermissionForm">
                                <!-- Select Role -->
                                <div class="form-group">
                                    <label for="roleSelect">Select Role:</label>
                                    <select id="roleSelect" class="form-control">
                                        <!-- Roles will be populated here dynamically -->
                                    </select>
                                </div>

                                <!-- Select Permissions -->
                                <div class="form-group">
                                    <label for="permissionSelect">Select Permissions:</label>
                                    <select id="permissionSelect" class="form-control" multiple>
                                        <!-- Permissions will be populated here dynamically -->
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="savePermissionsBtn">Save
                                Changes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- update roles and permission -->
            <div class="modal fade" id="editAccess" role="dialog" aria-labelledby="editPermissionModalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPermissionModalLabel">Edit Permissions</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editPermissionForm">
                                <input type="hidden" id="modalRoleId">
                                <div id="permissionList">
                                    <!-- Checkboxes will be populated dynamically here -->
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="EditedRolesPerm">Save
                                Changes</button>
                            <button type="button" id="close-btn" class="btn btn-default"
                                data-dismiss="modal">Close</button>
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
                <div id="edited" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Updated, Successfully.
                    </div>
                </div>
                <div id="deleted" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Deleted, Successfully.
                    </div>
                </div>
                <div id="error" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success text-light">
                        Something went wrong.
                    </div>
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
<script>

</script>

</html>