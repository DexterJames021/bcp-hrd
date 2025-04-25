<?php
require "../../config/Database.php";
require '../../auth/accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);
$recordsPerPage = 10;

// Get the current page number from URL parameter, default is 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting record for the SQL query
$startFrom = ($page - 1) * $recordsPerPage;

// Handle form submission to update status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_status']) && isset($_POST['leave_id'])) {
        $leaveId = $_POST['leave_id'];
        $newStatus = $_POST['update_status'];

        try {
            // Ensure session is valid
            if (!isset($_SESSION['user_id'])) {
                throw new Exception("Session expired or user not logged in.");
            }

            $sessionUserId = $_SESSION['user_id'];

            // Get the session user's applicant_name to use as 'head'
            $headStmt = $conn->prepare("
                SELECT a.applicant_name
                FROM users u
                LEFT JOIN applicants a ON u.applicant_id = a.id
                WHERE u.id = :sessionUserId
            ");
            $headStmt->bindParam(':sessionUserId', $sessionUserId, PDO::PARAM_INT);
            $headStmt->execute();
            $headData = $headStmt->fetch(PDO::FETCH_ASSOC);

            if (!$headData || empty($headData['applicant_name'])) {
                throw new Exception("Could not fetch session user name to use as head.");
            }

            $head = $headData['applicant_name']; // ✅ this will go into the head column

            if ($newStatus === 'accepted') {
                // Fetch the leave application data
                $selectStmt = $conn->prepare("
                    SELECT 
                        l.*, 
                        d.DepartmentName
                    FROM leaveapplication l
                    LEFT JOIN users u ON l.employeeId = u.id
                    LEFT JOIN applicants a ON u.applicant_id = a.id
                    LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID
                    WHERE l.id = :id
                ");
                $selectStmt->bindParam(':id', $leaveId, PDO::PARAM_INT);
                $selectStmt->execute();
                $leaveData = $selectStmt->fetch(PDO::FETCH_ASSOC);

                if ($leaveData) {
                    // Insert into leave_requests table using session user's name as head
                    $insertStmt = $conn->prepare("
                        INSERT INTO leave_requests (employeeId, name, leave_type, date, department, message, head) 
                        VALUES (:employeeId, :name, :leaveType, :date, :department, :message, :head)
                    ");
                    $insertStmt->bindParam(':employeeId', $leaveData['employeeId']);
                    $insertStmt->bindParam(':name', $leaveData['name']);
                    $insertStmt->bindParam(':leaveType', $leaveData['leave_type']);
                    $insertStmt->bindParam(':date', $leaveData['date']);
                    $insertStmt->bindParam(':department', $leaveData['DepartmentName']);
                    $insertStmt->bindParam(':message', $leaveData['message']);
                    $insertStmt->bindParam(':head', $head); // ✅ session user's applicant_name
                    $insertStmt->execute();

                    // Delete from leaveapplication
                    $deleteStmt = $conn->prepare("DELETE FROM leaveapplication WHERE id = :id");
                    $deleteStmt->bindParam(':id', $leaveId, PDO::PARAM_INT);
                    $deleteStmt->execute();

                    echo "<script>alert('Leave accepted and moved HR');</script>";
                } else {
                    echo "<script>alert('Leave request not found.');</script>";
                }

            } elseif ($newStatus === 'rejected') {
                // Update status to denied
                $updateStmt = $conn->prepare("UPDATE leaveapplication SET status = 'rejected' WHERE id = :id");
                $updateStmt->bindParam(':id', $leaveId, PDO::PARAM_INT);
                $updateStmt->execute();

                echo "<script>alert('Leave request denied');</script>";
            }

        } catch (PDOException $e) {
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}
// Fetch data from the database (pagination and sorting already applied)
try {
    $userId = $_SESSION['user_id'];

    // Step 1: Get the department name of the logged-in user
    $stmtDept = $conn->prepare("
        SELECT d.DepartmentName 
        FROM users u
        LEFT JOIN applicants a ON u.applicant_id = a.id
        LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID
        WHERE u.id = :userId
    ");
    $stmtDept->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmtDept->execute();
    $result = $stmtDept->fetch(PDO::FETCH_ASSOC);

    if (!$result || empty($result['DepartmentName'])) {
        throw new Exception("Unable to find department for this user.");
    }

    $department = $result['DepartmentName'];

    // Step 2: Fetch leave applications for users in the same department
    $stmt = $conn->prepare("
        SELECT 
            l.id, 
            l.employeeId, 
            l.name, 
            l.leave_type, 
            l.date, 
            l.department, 
            l.message, 
            l.status 
        FROM leaveapplication l
        WHERE l.department = :department
        ORDER BY FIELD(l.status, 'pending') DESC, l.id ASC
        LIMIT :startFrom, :recordsPerPage
    ");


$stmt->bindParam(':department', $department, PDO::PARAM_STR);
    $stmt->bindParam(':startFrom', $startFrom, PDO::PARAM_INT);
    $stmt->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $benefitData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of records to calculate the number of pages
    $totalStmt = $conn->prepare("SELECT COUNT(*) FROM leaveapplication");
    $totalStmt->execute();
    $totalRecords = $totalStmt->fetchColumn();
    $totalPages = ceil($totalRecords / $recordsPerPage);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

//delete button
// Check if the delete request is made
if (isset($_POST['delete_leave'])) {
    $leaveId = $_POST['leave_id'];  // Get the leave ID to be deleted

    try {
        // Prepare and execute the DELETE query
        $deleteStmt = $conn->prepare("DELETE FROM leaveapplication WHERE id = :leaveId");
        $deleteStmt->bindParam(':leaveId', $leaveId, PDO::PARAM_INT);
        $deleteStmt->execute();

        // Redirect back to the same page (or show a success message)
        header("Location: requests.php");  // Replace 'your_page.php' with the actual page URL
        exit();

    } catch (PDOException $e) {
        // Handle any errors
        die("Error deleting record: " . $e->getMessage());
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

    <!-- ajax -->
    <script defer src="../../node_modules/jquery/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- global JavaScript -->
    <script defer type="module" src="../../assets/libs/js/global-script.js"></script>

    <!-- main js -->
    <script defer type="module" src="../../assets/libs/js/main-js.js"></script>
    <link rel="stylesheet" href="../../assets/libs/css/style.css">
    <!-- <link rel="stylesheet" href="css/leave2.css"> -->

    <!-- assts csss -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Bootstrap Example</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- slimscroll js -->
    <script defer type="module" src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

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
        <?php include '../sideandnavbar.php'; ?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        
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
                
                <div class="row">
                   <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        <div class="page">
                            <div class="table-responsive">
                            <h1>Leave Requests</h1>

<!-- Start of Table -->
<table class="table table-hover">
<thead>
<tr>
<th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">ID</th>
<th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Employee ID</th>
<th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Name</th>
<th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Leave</th>
<th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Date</th>
<th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Department</th>
<th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Message</th>
<th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Status</th>
<th style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">Action</th>
</tr>
</thead>
<tbody>
<?php
// Check if we have any records
if (!empty($benefitData)) {
// Loop through the data and display each row
foreach ($benefitData as $row) {
// Determine the status and its corresponding CSS class
$statusClass = '';
if ($row['status'] == 'pending') {
$statusClass = 'status-pending';
} elseif ($row['status'] == 'accepted') {
$statusClass = 'status-accepted';
} elseif ($row['status'] == 'rejected') {
$statusClass = 'status-rejected';
}

echo "<tr>
<td>" . htmlspecialchars($row['id']) . "</td>
<td>" . htmlspecialchars($row['employeeId']) . "</td>
<td>" . htmlspecialchars($row['name']) . "</td>
<td>" . htmlspecialchars($row['leave_type']) . "</td>
<td>" . htmlspecialchars($row['date']) . "</td>
<td>" . htmlspecialchars($row['department']) . "</td>
<td>" . htmlspecialchars($row['message']) . "</td>
<td><span class='status-text $statusClass'>" . htmlspecialchars($row['status']) . "</span></td>
<td>";

// Only show buttons if the status is 'pending'
if ($row['status'] == 'pending') {
echo "<form method='POST' action=''>
<input type='hidden' name='leave_id' value='" . htmlspecialchars($row['id']) . "' />
<button type='submit' name='update_status' value='accepted' style='background-color: #3d405c; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; margin-right: 5px;'>Accept</button>
</form>
<form method='POST' action=''>
<input type='hidden' name='leave_id' value='" . htmlspecialchars($row['id']) . "' />
<button type='submit' name='update_status' value='rejected' style='background-color: #d9534f; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;'>Decline</button>
</form>";
} else {
// Show delete button for accepted or denied statuses
echo "<form method='POST' action=''>
<input type='hidden' name='leave_id' value='" . htmlspecialchars($row['id']) . "' />
<a href='benefits.php?deleteId=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
<button type='submit' name='delete_leave' value='delete' style='background-color:rgb(167, 78, 75); color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;'>Delete</button>
</form>";
}

echo "</td></tr>";
}
} else {
echo "<tr><td colspan='8'>No records found</td></tr>";
}
?>
</tbody>
</table>

<!-- End of Table -->



<!-- Pagination Links -->
<div style="text-align: center; margin-top: 20px;">
<ul style="list-style-type: none; padding: 0;">
<?php if ($page > 1): ?>
<li style="display: inline; margin-right: 10px;">
<a href="?page=<?= $page - 1 ?>" style="text-decoration: none; background-color: #3d405c; color: white; padding: 8px 16px; border-radius: 4px;">Previous</a>
</li>
<?php endif; ?>

<?php for ($i = 1; $i <= $totalPages; $i++): ?>
<li style="display: inline; margin-right: 5px;">
<a href="?page=<?= $i ?>" style="text-decoration: none; background-color: <?= $i == $page ? '#3d405c' : '#f4f4f4'; ?>; color: <?= $i == $page ? 'white' : '#333'; ?>; padding: 8px 16px; border-radius: 4px;"><?= $i ?></a>
</li>
<?php endfor; ?>

<?php if ($page < $totalPages): ?>
<li style="display: inline; margin-left: 10px;">
<a href="?page=<?= $page + 1 ?>" style="text-decoration: none; background-color: #3d405c; color: white; padding: 8px 16px; border-radius: 4px;">Next</a>
</li>
<?php endif; ?>
</ul>
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