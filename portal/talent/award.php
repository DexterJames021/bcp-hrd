<?php
require "../../config/db_talent.php";
require '../../auth/mysqli_accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);
// 1. Count awards ng current employee
$userID = $_SESSION['user_id'] ?? null;
$employeeID = null;

if ($userID) {
    $getEmployee = "SELECT EmployeeID FROM employees WHERE UserID = ?";
    $stmt = $conn->prepare($getEmployee);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        $employeeID = $row['EmployeeID'];
    }
    $stmt->close();
}

$myAwardsCount = 0;
if ($employeeID) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM employee_awards WHERE employee_id = ?");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $countRow = $res->fetch_assoc()) {
        $myAwardsCount = $countRow['total'];
    }
    $stmt->close();
}

// 2. Count lahat ng awardees
$allAwardeesCount = 0;
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM employee_awards");
$stmt->execute();
$res = $stmt->get_result();
if ($res && $countRow = $res->fetch_assoc()) {
    $allAwardeesCount = $countRow['total'];
}
$stmt->close();
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
                <div class="row">
                        <div class="col-12">
                            <div class="card">
                                    <div class="card-body"> 
                                    <h1>My Awards</h1>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card bg-light text-white">
                                                    <div class="card-body">
                                                        <h5>My Awards</h5> 
                                                        <h3><?php echo $myAwardsCount ; ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card bg-light text-white">
                                                    <div class="card-body">
                                                        <h5>All Awardees</h5>
                                                        <h3><?php echo $allAwardeesCount ; ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                        <hr>
                                            <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="myAward-tab" data-toggle="tab" href="#myAward" role="tab" aria-controls="myAward" aria-selected="false">My Award</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="Awardees-tab" data-toggle="tab" href="#Awardees" role="tab" aria-controls="Awardees" aria-selected="true">All Awardees</a>
                                                </li>
                                        
                                                
                                            </ul>
                                    <div class="tab-content" id="dashboardTabsContent">
                                            <div class="tab-pane fade show active" id="myAward" role="tabpanel" aria-labelledby="myAward-tab">
                                                <!-- Content for Employee Retained goes here -->
                                                <div class="card">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <h1 class="card-title">My Awards</h1>
                                                    </div>
                                                    <div class="card-body">
                                                        <table id="myAwardTable" class="table table-hover" style="width: 100%;">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>Award Name</th>
                                                                    <th>Award Description</th>
                                                                    <th>My Note</th>
                                                                    <th>Reward</th>
                                                                    <th>Date Awarded</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                // 1. Lookup EmployeeID
                                                                $userID = $_SESSION['user_id'];
                                                                $empQ = "SELECT EmployeeID FROM employees WHERE UserID = ?";
                                                                $s = $conn->prepare($empQ);
                                                                $s->bind_param("i", $userID);
                                                                $s->execute();
                                                                $res = $s->get_result();

                                                                if ($res && $er = $res->fetch_assoc()) {
                                                                $eid = $er['EmployeeID'];

                                                                // 2. Join employee_awards with retention_programs
                                                                $awQ = "
                                                                    SELECT 
                                                                    rp.program_name,
                                                                    rp.description   AS program_desc,
                                                                    rp.reward,
                                                                    ea.description   AS my_note,
                                                                    ea.award_date,
                                                                    ea.status        AS award_status
                                                                    FROM employee_awards ea
                                                                    INNER JOIN retention_programs rp 
                                                                    ON ea.program_id = rp.id
                                                                    WHERE ea.employee_id = ?
                                                                    ORDER BY ea.award_date DESC
                                                                ";
                                                                $s2 = $conn->prepare($awQ);
                                                                $s2->bind_param("i", $eid);
                                                                $s2->execute();
                                                                $aw = $s2->get_result();

                                                                if ($aw->num_rows > 0) {
                                                                    while ($row = $aw->fetch_assoc()) {
                                                                    echo '<tr>';
                                                                    echo '<td>' . htmlspecialchars($row['program_name']) . '</td>';
                                                                    echo '<td>' . htmlspecialchars($row['program_desc']) . '</td>';
                                                                    echo '<td>' . htmlspecialchars($row['my_note']) . '</td>';
                                                                    echo '<td>' . htmlspecialchars($row['reward']) . '</td>';
                                                                    echo '<td>' . date('F j, Y', strtotime($row['award_date'])) . '</td>';

                                                                    // status badge
                                                                    $status = $row['award_status'];
                                                                    $badge = ($status === 'Active' || $status === 'Completed')
                                                                            ? 'success' : 'secondary';
                                                                    echo '<td><span class="badge badge-' 
                                                                        . $badge . '">' 
                                                                        . htmlspecialchars($status) 
                                                                        . '</span></td>';

                                                                    echo '</tr>';
                                                                    }
                                                                } else {
                                                                    echo '<tr><td colspan="6" class="text-center">You have no awards yet.</td></tr>';
                                                                }
                                                                } else {
                                                                echo '<tr><td colspan="6" class="text-center">Employee record not found.</td></tr>';
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="tab-pane fade" id="Awardees" role="tabpanel" aria-labelledby="Awardees-tab">
                                                <!-- Content for Employee Retained goes here -->
                                                <div class="card">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <h1 class="card-title">All Awardees</h1>
                                                    </div>
                                                    <div class="card-body">  
                                                        <table id="awardeesTable" class="table table-hover" style="width: 100%;">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Employee Name</th>
                                                                <th>Program Name</th>
                                                                <th>Program Description</th>
                                                                <th>My Note</th>
                                                                <th>Reward</th>
                                                                <th>Date Awarded</th>
                                                                <th>Status</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            // Fetch all awardees
                                                            $query = "
                                                            SELECT 
                                                                ea.id,
                                                                e.FirstName,
                                                                e.LastName,
                                                                rp.program_name,
                                                                rp.description    AS program_desc,
                                                                ea.description    AS my_note,
                                                                rp.reward,
                                                                ea.award_date,
                                                                ea.status         AS award_status
                                                            FROM employee_awards ea
                                                            INNER JOIN employees e   ON ea.employee_id  = e.EmployeeID
                                                            INNER JOIN retention_programs rp ON ea.program_id = rp.id
                                                            ORDER BY ea.award_date DESC
                                                            ";
                                                            if ($stmt = $conn->prepare($query)) {
                                                            $stmt->execute();
                                                            $res = $stmt->get_result();

                                                            if ($res->num_rows > 0) {
                                                                while ($row = $res->fetch_assoc()) {
                                                                $fullName = htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']);
                                                                $progName = htmlspecialchars($row['program_name']);
                                                                $progDesc = htmlspecialchars($row['program_desc']);
                                                                $note     = htmlspecialchars($row['my_note']);
                                                                $reward   = htmlspecialchars($row['reward']);
                                                                $date     = date('F j, Y', strtotime($row['award_date']));
                                                                $status   = htmlspecialchars($row['award_status']);
                                                                // badge color: green for Active/Completed, grey otherwise
                                                                $badge    = in_array($status, ['Active','Completed']) ? 'success' : 'secondary';

                                                                echo '<tr>';
                                                                    echo "<td>{$fullName}</td>";
                                                                    echo "<td>{$progName}</td>";
                                                                    echo "<td>{$progDesc}</td>";
                                                                    echo "<td>{$note}</td>";
                                                                    echo "<td>{$reward}</td>";
                                                                    echo "<td>{$date}</td>";
                                                                    echo '<td><span class="badge badge-' . $badge . '">' . $status . '</span></td>';
                                                                echo '</tr>';
                                                                }
                                                            } else {
                                                                echo '<tr><td colspan="7" class="text-center">No awardees found.</td></tr>';
                                                            }
                                                            $stmt->close();
                                                            } else {
                                                            echo '<tr><td colspan="7" class="text-center">Error fetching awardees.</td></tr>';
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
    </div>
<script>
    $(document).ready(function() {
        if ($("#myAwardTable tbody tr").length > 1) { // Ensure at least one row exists
            $('#myAwardTable').DataTable({
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
        if ($("#awardeesTable tbody tr").length > 1) { // Ensure at least one row exists
            $('#awardeesTable').DataTable({
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