<?php

session_start();

require_once '../../config/Database.php';
require_once './includes/class/Task.php';
require_once './includes/class/Employee.php';

// if (isset($_SESSION['user_id'])) {
// } else {
//     header("Location: ../auth/index.php");
// }

$employee = new Employee($conn);
$emp = $employee->select_all();

$task = new Task($conn);
$alltasks = $task->select_all_task();

function filter($conn, $status){
    $q = "SELECT Status FROM tasks WHERE ". $status;
    $stmt = $conn->prepare($q);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- icon -->
    <link rel="shortcut icon" href="../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- assets -->
    <?php include_once('./includes/_assets.php') ?>

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
        <?php include('./includes/_header.php') ?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark ">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <!-- <a class="d-xl-none d-lg-none" href="#">Dashboard</a> -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Human Resource Dept.
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="index.php">
                                    <i class="fas fa-fw fa-home"></i> Dashboard
                                </a>
                            </li>
                            <!-- Selection and Recuitment -->
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fa fa-fw fa-user-circle"></i>Selection and Recuitment <span class="badge badge-success">6</span></a>
                                <div id="submenu-1" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1-2" aria-controls="submenu-1-2">Lorem, ipsum.</a>
                                            <div id="submenu-1-2" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="index.html">Lorem.</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">lorem1</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem.</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem.</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./records-management/Records.php">Lorem, ipsum dolor.</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="dashboard-sales.html">Lorem, ipsum dolor.</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1-1" aria-controls="submenu-1-1">Lorem, ipsum dolor.</a>
                                            <div id="submenu-1-1" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem, ipsum dolor.</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem, ipsum dolor.</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem, ipsum dolor.</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Talent Management -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fa fa-fw fa-rocket"></i>Talent Management</a>
                                <div id="submenu-2" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/cards.html">Cards <span class="badge badge-secondary">New</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/general.html">General</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/carousel.html">Carousel</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/listgroup.html">Group</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/typography.html">Typography</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/accordions.html">Accordions</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/tabs.html">Tabs</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Tech & Analytics -->
                            <li class="nav-item">
                                <a class="nav-link active" href="#" data-toggle="collapse" aria-expanded="true" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i> Tech & Analytics</a>
                                <div id="submenu-3" class="collapse submenu show" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="./index.php">Home Dashboard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="./tasks.php">Task management</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./records.php">Records</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3-1" aria-controls="submenu-3-1">Analytics</a>
                                            <div id="submenu-3-1" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="./analytics/engagement.php">Engagement insight</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="./analytics/performace.php">Performance metric</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="./analytics/effieciency.php">Efficiency analysis</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="./analytics/workforce.php">Workforce optimazition</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="./analytics/talent.php">Talent insight</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-sparkline.html">Sparkline</a>
                                        </li> -->
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-gauge.html">Guage</a>
                                        </li> -->
                                    </ul>
                                </div>
                            </li>
                            <!-- Document and Legal -->
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fab fa-fw fa-wpforms"></i>Document and Legal</a>
                                <div id="submenu-4" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/form-elements.html">Form Elements</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/form-validation.html">Parsely Validations</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/multiselect.html">Multiselect</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/datepicker.html">Date Picker</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/bootstrap-select.html">Bootstrap Select</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Performance -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-fw fa-table"></i>Performance</a>
                                <div id="submenu-5" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/general-table.html">General Tables</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/data-tables.html">Data Tables</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Talent management -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-fw fa-columns"></i>Talent management</a>
                                <div id="submenu-6" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/general-table.html">General Tables</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/data-tables.html">Data Tables</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Compensation & benefits -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-f fa-folder"></i>Compensation & benefits</a>
                                <div id="submenu-7" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/general-table.html">General Tables</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/data-tables.html">Data Tables</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-divider">
                                Features
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./task-management/index.php" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8">
                                    <i class="fas fa-fw fa-file"></i> Task-management </a>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>


    <!-- main content -->
    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h2 class="card-title">Task Management</h2>
                            <button type="button" class="btn btn-primary float-right"
                                data-toggle="modal" data-target="#myModal">Add Task</button>
                        </div>
                        <div class="card-body">
                            <!-- filter btn -->
                            <select name="filterTask" id="" class="form-select ">
                                <option value="all">all</option>
                                <option value="complete">complete</option>
                                <option value="active">active</option>
                            </select>

                            <ul class="list-group mb-0">
                                <?php if (is_array($alltasks) && count($alltasks) > 0): ?>
                                    <?php foreach ($alltasks as $alltask): ?>
                                        <li id="task-list"
                                            class=" text-center list-group-item d-flex justify-content-between align-items-center border-start-0 border-top-0 border-end-0 border-bottom rounded-0 mb-2">
                                            <div class="d-flex align-items-center">
                                                <input type="checkbox" id="task-check" class="form-check-input me-2" value="<?= $alltask['Status'] ?>" aria-label="..." />
                                                <div class="">
                                                    <span class="d-block "><?= $alltask['Title'] ?>
                                                        <span class="text-muted">
                                                            <?= $alltask['Description'] === '' ? '' : '<i class="bi bi-dot"></i>' ?>
                                                            <?= htmlspecialchars($alltask['Description']) ?>
                                                        </span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li><a class="dropdown-item" href="./path/id=". <?= $alltask['TaskID'] ?>>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#">Delete</a></li>
                                                    <li><a class="dropdown-item" href="#">Mark as Complete</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class=" m-3">No Task Today.</div>
                                <?php endif; ?>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="row">
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Task</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <form id="task_form">
                            <div class="mb-3">
                                <label for="creator" class="form-label">Creator:</label>
                                <input type="text" name="Creator" class="form-control" id="creator" value="<?= $_SESSION['username'] ?>" disabled>

                            </div>
                            <div class="mb-3">
                                <label for="task" class="form-label">Task:</label>
                                <input type="text" name="Title" class="form-control" id="task" required='required'>
                                <label for="task" class="task-valid d-none text-danger">This field is required!</label>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea name="Description" class="form-control" id="description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="assign">Assign to:</label>
                                <select name="UserID" class="form-control form-select" id="assign" aria-label="Default select example" required='required'>
                                    <?php if (is_array($emp) && count($emp) > 0): ?>
                                        <option value="" selected disabled>Select a user</option>
                                        <?php foreach ($emp as $user): ?>
                                            <option value="<?= $user['UserID']; ?>"><?= $user['FirstName']; ?></option>
                                        <?php endforeach; ?>
                                        <option>Everyone</option> //TODO: select *
                                    <?php endif; ?>
                                </select>
                                <label for="assign" class="assign-valid d-none text-danger">This field is required!</label>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary">Submit</button>
                                <button type="button" id="close-btn" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- end wrapper  -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <script>
        $(document).ready(function() {
            $('.row .modal .modal-content .modal-body #task_form').on('submit', (e) => {
                e.preventDefault();

                $formdata = {
                    Creator: $('#creator').val(),
                    Title: $('#task').val(),
                    Description: $('#description').val(),
                    UserID: $('#assign').val()
                };


                $.ajax({
                    url: './includes/class/Task.php',
                    method: 'POST',
                    data: $formdata,
                    dataType: 'json',
                    success: (response) => {

                        // console.log(response)
                        if (response && response.message === "Task created successfully!") {
                            $('#task_form')[0].reset();
                            $('#myModal').closest('.modal').modal('hide');

                            Toastify({
                                text: "Task Added successfully",
                                className: "info",
                                style: {
                                    background: " #2ec551",
                                    border: "solid #f9f9f 1px"
                                }
                            }).showToast();
                        }

                    },
                    error: function(xhr, status, error) {
                        // Swal.fire('Error', 'An unexpected error occurred.', 'error');
                        console.log('Error', 'An unexpected error occurred.', 'error');
                    }
                })

            });

            $(document).on('click', '#task-check', () => {
                // console.log('e')
                $.ajax({
                    url: '',
                    method: 'PUT'
                })
            })
        });
    </script>
</body>

</html>