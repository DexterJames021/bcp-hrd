<?php
require "../../config/db_talent.php";
require '../../auth/mysqli_accesscontrol.php';

// Get the logged-in user data
$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

// Get the UserID of the logged-in user
$user_id = $_SESSION['user_id'];  // Assuming the user ID is stored in the session

// Step 1: Query to get the EmployeeID based on UserID
$query_employee_id = "
    SELECT e.EmployeeID 
    FROM employees e 
    JOIN users u ON e.UserID = u.id
    WHERE u.id = ?
";
$stmt_employee = $conn->prepare($query_employee_id);
$stmt_employee->bind_param("i", $user_id);  // Bind the logged-in UserID
$stmt_employee->execute();
$result_employee = $stmt_employee->get_result();
$employee_id = null;
if ($result_employee->num_rows > 0) {
    $row = $result_employee->fetch_assoc();
    $employee_id = $row['EmployeeID'];
}

// Step 2: If EmployeeID exists, fetch assigned training sessions with DepartmentName
if ($employee_id) {
    $query = "
    SELECT ta.assignment_id, ts.training_name, ts.training_description, ts.trainer, d.DepartmentName, ts.training_materials, ts.created_at,
           ta.status, ta.completion_date
    FROM training_assignments ta
    JOIN training_sessions ts ON ta.training_id = ts.training_id
    JOIN departments d ON ts.department = d.DepartmentID  -- Join with departments table
    WHERE ta.employee_id = ?
";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_id);  // Use the employee ID to filter the sessions
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = null;
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Icon -->
    <link rel="shortcut icon" href="../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- DataTable CSS -->
    <link rel="stylesheet" href="../../node_modules/datatables.net-dt/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="../../assets/libs/css/style.css">

    <!-- Vendor Fonts -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <!-- Main JS -->
    <script src="../../assets/libs/js/main-js.js"></script>

    <!-- Custom JS -->
    <script src="../../portal/includes/facility_employee.js"></script>

    <!-- Slimscroll JS -->
    <script src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

    <title>Employee Dashboard</title>
</head>

<body>
<div class="dashboard-main-wrapper">
    <?php include '../sideandnavbar.php'; ?>
    
    <div class="dashboard-wrapper">

        <div class="container-fluid dashboard-content">
        <?php
// Check if a success message is set
if (isset($_SESSION['message'])) {
    echo '
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        ' . $_SESSION['message'] . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    
    <script>
        // Auto-dismiss the alert after 5 seconds
        setTimeout(function() {
            $(".alert").alert("close");
        }, 3000);
    </script>
    ';

    // Unset the message after displaying it to prevent it from showing again on page reload
    unset($_SESSION['message']);
}
?>

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">

                        <div class="card-header">
                            <h2 class="pageheader-title">My Training Sessions</h2>
                        </div>
                        <div class="card-body">

        <table id="trainingTable" class="table table-hover" style="100%">
        <thead class="thead-light">
    <tr>
        <th>Training Name</th>
        <th>Description</th>
        <th>Trainer</th>
        <th>Department</th>
        <th>Materials</th>
        <th>Status</th>
        <th>Completion Date</th>
        <th>Rating 1-5</th> <!-- Added Action column -->
    </tr>
</thead>
<tbody>
<?php
// Check if there are any assigned training sessions
if ($result && $result->num_rows > 0) {
    // Display the training sessions
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['training_name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['training_description']) . '</td>';
        echo '<td>' . htmlspecialchars($row['trainer']) . '</td>';
        echo '<td>' . htmlspecialchars($row['DepartmentName']) . '</td>';
        echo '<td>' . htmlspecialchars($row['training_materials']) . '</td>';
        echo '<td>' . htmlspecialchars($row['status']) . '</td>';
        echo '<td>';
        if ($row['completion_date']) {
            echo date('F j, Y', strtotime($row['completion_date']));
        } else {
            echo 'Not Completed';
        }
        echo '</td>';

        // Add Action button (Start) if status is not In Progress or Completed
        if ($row['status'] == 'Not Started') {
            // Display the form with the 'Start' button and confirmation prompt
            echo '<td>
                    <form method="POST" action="start_training.php" id="startForm">
                        <input type="hidden" name="assignment_id" value="' . $row['assignment_id'] . '">
                        <button type="button" class="btn btn-primary btn-sm" onclick="confirmStart()">Start</button>
                    </form>
                  </td>';
        } elseif ($row['status'] == 'In Progress') {
            // Display nothing if it's in progress, or provide a "Complete" button depending on your logic
            echo '<td>In Progress</td>';
        } elseif ($row['status'] == 'Completed') {
            // If status is completed, display grade in Action column
            echo '<td>';
            // Query the grade for this training session
            $gradeQuery = "
                SELECT tg.grade 
                FROM training_grades tg
                JOIN training_assignments ta ON tg.assignment_id = ta.assignment_id
                WHERE ta.assignment_id = ?";
                
            if ($gradeStmt = $conn->prepare($gradeQuery)) {
                $gradeStmt->bind_param("i", $row['assignment_id']);
                $gradeStmt->execute();
                $gradeResult = $gradeStmt->get_result();
                if ($gradeResult->num_rows > 0) {
                    $gradeRow = $gradeResult->fetch_assoc();
                    echo '<span class="badge badge-success">Rating: ' . htmlspecialchars($gradeRow['grade']) . 'Stars</span>';
                } else {
                    echo 'No grade assigned yet';
                }
                $gradeStmt->close();
            }
            echo '</td>';
        } else {
            // For other statuses (e.g., 'Not Started', you could also display a default message)
            echo '<td></td>';
        }

        echo '</tr>';
    }
} else {
    // Display message in the table body when no sessions are found
    echo '<tr><td colspan="8" class="text-center">You have no assigned training sessions at the moment.</td></tr>';
}
?>
</tbody>

<script>
    function confirmStart() {
        // Ask for confirmation before starting the training
        if (confirm("Are you sure you want to start the training? This action cannot be undone.")) {
            // If user confirms, submit the form
            document.getElementById("startForm").submit();
        }
    }
</script>

        </table>
    </div>
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

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

</body>
</html>