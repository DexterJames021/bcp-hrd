<?php
require "../../config/db_talent.php";
require '../../auth/mysqli_accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);
// 1. Get total number of training_sessions (lahat ng trainings)
$trainingSessionsQuery = "SELECT COUNT(*) AS total_sessions FROM training_sessions";
$trainingSessionsResult = $conn->query($trainingSessionsQuery);
$trainingSessionsCount = 0;

if ($trainingSessionsResult && $row = $trainingSessionsResult->fetch_assoc()) {
    $trainingSessionsCount = $row['total_sessions'];
}

// 2. Get total number of assigned training_assignments for the logged-in employee
$userID = $_SESSION['user_id'];

// Get EmployeeID linked to user
$getEmployee = "SELECT EmployeeID FROM employees WHERE UserID = ?";
$stmt = $conn->prepare($getEmployee);
$stmt->bind_param("i", $userID);
$stmt->execute();
$employeeResult = $stmt->get_result();

$trainingAssignmentsCount = 0;

if ($employeeResult && $empRow = $employeeResult->fetch_assoc()) {
    $employeeID = $empRow['EmployeeID'];

    // Count assigned trainings
    $assignedQuery = "SELECT COUNT(*) AS total_assignments FROM training_assignments WHERE employee_id = ?";
    $stmt2 = $conn->prepare($assignedQuery);
    $stmt2->bind_param("i", $employeeID);
    $stmt2->execute();
    $assignedResult = $stmt2->get_result();

    if ($assignedResult && $assignedRow = $assignedResult->fetch_assoc()) {
        $trainingAssignmentsCount = $assignedRow['total_assignments'];
    }
}

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

    <!-- datatable: cs -->
    <link rel="stylesheet" href="../../node_modules/datatables.net-dt/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- main js -->
    <link rel="stylesheet" href="../../assets/libs/css/style.css">

    <!-- assts csss -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style1.css" rel="stylesheet">

    <!-- icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTable JS -->
    <script src="../../node_modules/datatables.net/js/dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- calendar js -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <!-- main js -->
    <script src="../../assets/libs/js/main-js.js"></script>

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
            <!-- <div class="dashboard-ecommerce"> -->
            <div class="container-fluid dashboard-content ">
                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
                <?php
if (isset($_SESSION['success_message'])) {
    echo '
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        ' . $_SESSION['success_message'] . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        setTimeout(function() {
            var alert = document.querySelector(".alert");
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    </script>
    ';
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $_SESSION['error_message'] . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        setTimeout(function() {
            var alert = document.querySelector(".alert");
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    </script>
    ';
    unset($_SESSION['error_message']);
}
?>
               <div class="row">
                        <div class="col-12">
                            <div class="card">
                                    <div class="card-body"> 
                                        <h1>My Succession</h1>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card bg-light text-white">
                                                    <div class="card-body">
                                                        <h5>Available Training</h5> 
                                                        <h3><?php echo $trainingSessionsCount ; ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card bg-light text-white">
                                                    <div class="card-body">
                                                        <h5>My Training</h5>
                                                        <h3><?php echo $trainingAssignmentsCount ; ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                        <hr>
                                        <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="available-training-tab" data-toggle="tab" href="#available-training" role="tab" aria-controls="available-training" aria-selected="false">Available Training</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="myTraining-tab" data-toggle="tab" href="#myTraining" role="tab" aria-controls="myTraining" aria-selected="true">My Training</a>
                                            </li>
                                    
                                            
                                        </ul>
                                        <div class="tab-content" id="dashboardTabsContent">
                                            <div class="tab-pane fade show active" id="available-training" role="tabpanel" aria-labelledby="available-training-tab">
                                                <!-- Content for Employee Retained goes here -->
                                                <div class="card">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <h1 class="card-title">Available Training</h1>
                                                    </div>
                                                    <div class="card-body">
    <!-- Table for Training Sessions -->
    <table id="trainingTable" class="table table-hover" style="width: 100%;">
        <thead class="thead-light">
            <tr>
                <th>Training Name</th>
                <th>Description</th>
                <th>Trainer</th>
                <th>Department</th>
                <th>Training Materials</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query to fetch training sessions and join with departments table
            $query = "SELECT ts.training_id, ts.training_name, ts.training_description, ts.trainer, d.DepartmentName, ts.training_materials, ts.created_at
                      FROM training_sessions ts
                      INNER JOIN departments d ON ts.department = d.DepartmentID"; // Assuming department field is DepartmentID
            $result = mysqli_query($conn, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['training_name'] . "</td>";
                    echo "<td>" . $row['training_description'] . "</td>";
                    echo "<td>" . $row['trainer'] . "</td>";
                    echo "<td>" . $row['DepartmentName'] . "</td>"; // Displaying DepartmentName
                    echo "<td>" . $row['training_materials'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>
                            <a href='apply_training.php?id=" . $row['training_id'] . "' class='btn btn-success btn-sm'>Apply</a>
                          </td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="myTraining" role="tabpanel" aria-labelledby="myTraining-tab">
    <!-- Content for My Training goes here -->
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h1 class="card-title">My Training</h1>
        </div>
        <div class="card-body">
            <!-- Table for Training Sessions -->
            <table id="myTrainingTable" class="table table-hover" style="width: 100%;">
                <thead class="thead-light">
                <tr>
                    <th>Training Name</th>
                    <th>Description</th>
                    <th>Trainer</th>
                    <th>Department</th>
                    <th>Materials</th>
                    <th>Status</th>
                    <th>Completion Date</th>
                    <th>Rating 1-5</th> <!-- Corrected: Rating column -->
                </tr>
                </thead>
                <tbody>
<?php
// 1. Get User ID from session
$userID = $_SESSION['user_id']; 

// 2. Get EmployeeID linked to the logged-in user
$getEmployee = "SELECT EmployeeID FROM employees WHERE UserID = ?";
$stmt = $conn->prepare($getEmployee);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $empRow = $result->fetch_assoc()) {
    $employeeID = $empRow['EmployeeID'];

    // 3. Query training assignments + session + department + grade
    $query = "
        SELECT 
            ta.assignment_id, 
            ta.status, 
            ta.completion_date,
            ts.training_name, 
            ts.training_description, 
            ts.trainer, 
            d.DepartmentName, 
            ts.training_materials,
            tg.grade
        FROM training_assignments ta
        INNER JOIN training_sessions ts ON ta.training_id = ts.training_id
        INNER JOIN departments d ON ts.department = d.DepartmentID
        LEFT JOIN training_grades tg ON ta.assignment_id = tg.assignment_id
        WHERE ta.employee_id = ?
    ";
    $stmt2 = $conn->prepare($query);
    $stmt2->bind_param("i", $employeeID);
    $stmt2->execute();
    $trainings = $stmt2->get_result();

    if ($trainings->num_rows > 0) {
        while ($row = $trainings->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['training_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['training_description']) . '</td>';
            echo '<td>' . htmlspecialchars($row['trainer']) . '</td>';
            echo '<td>' . htmlspecialchars($row['DepartmentName']) . '</td>';
            echo '<td>' . htmlspecialchars($row['training_materials']) . '</td>';
            echo '<td>' . htmlspecialchars($row['status']) . '</td>';

            // Completion Date
            if (!empty($row['completion_date'])) {
                echo '<td>' . date('F j, Y', strtotime($row['completion_date'])) . '</td>';
            } else {
                echo '<td>Not Completed</td>';
            }

            // Rating 1-5 / Start / In Progress column
            echo '<td>';
            if ($row['status'] === 'Not Started') {
                $formId = 'startForm_' . htmlspecialchars($row['assignment_id']);
                echo '<form method="POST" action="start_training.php" id="' . $formId . '">';
                echo '<input type="hidden" name="assignment_id" value="' . htmlspecialchars($row['assignment_id']) . '">';
                echo '<button type="button" class="btn btn-primary btn-sm" onclick="if(confirm(\'Start this training? This action cannot be undone.\')) document.getElementById(\'' . $formId . '\').submit();">Start</button>';
                echo '</form>';
            }
            elseif ($row['status'] === 'In Progress') {
                echo '<span class="badge badge-warning">In Progress</span>';
            }
            elseif ($row['status'] === 'Completed') {
                if (!is_null($row['grade'])) {
                    $grade = (int)$row['grade'];
                    if ($grade <= 2) {
                        $badgeClass = 'badge badge-danger';
                    } elseif ($grade === 3) {
                        $badgeClass = 'badge badge-warning';
                    } else {
                        $badgeClass = 'badge badge-success';
                    }
                    echo '<span class="' . $badgeClass . '">Rating: ' . htmlspecialchars($grade) . ' Stars</span>';
                } else {
                    echo '<span class="badge badge-secondary">No Rating Yet</span>';
                }
            }
            else {
                echo '-';
            }
            echo '</td>';

            echo '</tr>';
        }
    } else {
        // No training assigned
        echo '<tr><td colspan="8" class="text-center">You have no assigned training sessions at the moment.</td></tr>';
    }
} else {
    // No employee record
    echo '<tr><td colspan="8" class="text-center">Employee record not found.</td></tr>';
}
?>
</tbody>



              
            </table>
        </div>
    </div>
</div>

                                            </div>
                                        </div>

                                        
                                            
                                       

                            </div>
                        </div>
                    </div>
                </div>


                <!-- </div> -->
            </div>
            <!-- </div> -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <!-- <div class="footer mx-2">
                <div class="container-fluid mx-2">
                    <div class="row">
                        <div class="col-xl-7 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-righ    t footer-links d-none d-sm-block">
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
    <script>
        console.log('EMPLOYEE PORTAL');
        $(document).ready(function () {
            var calendarEl = document.getElementById('employeeCalendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: function (fetchInfo, successCallback, failureCallback) {
                    $.ajax({
                        url: 'https://date.nager.at/api/v3/PublicHolidays/2024/PH', // Replace with your country's API
                        method: 'GET',
                        success: function (response) {
                            var events = response.map(function (holiday) {
                                return {
                                    title: holiday.localName,
                                    start: holiday.date,
                                    textColor: 'white'
                                };
                            });
                            successCallback(events);
                        },
                        error: function () {
                            failureCallback();
                        }
                    });
                }
            });
            calendar.render();
        });
    </script>

<script>
    $(document).ready(function() {
        if ($("#trainingTable tbody tr").length > 1) { // Ensure at least one row exists
            $('#trainingTable').DataTable({
                "lengthMenu": [10, 25, 50, 100], 
                "paging": true,
                "searching": true,
                "ordering": true
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        if ($("#myTrainingTable tbody tr").length > 1) { // Ensure at least one row exists
            $('#myTrainingTable').DataTable({
                "lengthMenu": [10, 25, 50, 100], 
                "paging": true,
                "searching": true,
                "ordering": true
            });
        }
    });
</script>

</body>

</html>
