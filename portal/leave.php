<?php
require "../config/Database.php";
require '../auth/accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

try {
    // Fetch all leave types
    $stmt = $conn->prepare("SELECT id, leave_type FROM leavetype");
    $stmt->execute();
    $leaveTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch user's leave credits
    $userId = $_SESSION['user_id'];
    $stmtCredits = $conn->prepare("
        SELECT lc.leave_type_id, lc.credits, lt.leave_type 
        FROM leave_credits lc 
        JOIN leavetype lt ON lc.leave_type_id = lt.id
        WHERE lc.user_id = :user_id
    ");
    $stmtCredits->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmtCredits->execute();
    $leaveCredits = $stmtCredits->fetchAll(PDO::FETCH_ASSOC);

    // Prepare credits as [leave_type => credits]
    $creditsMap = [];
    foreach ($leaveCredits as $credit) {
        $creditsMap[$credit['leave_type']] = $credit['credits'];
    }

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$messageFeedback = '';

// Handle leave application submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("User session data is incomplete.");
        }

        $userId = $_SESSION['user_id'];

        // Sanitize input
        $leaveType = htmlspecialchars(trim($_POST['leaveType']));
        $leaveDate = htmlspecialchars(trim($_POST['dateInput']));
        $message = htmlspecialchars(trim($_POST['message']));

        if (empty($leaveType) || empty($leaveDate) || empty($message)) {
            throw new Exception("All fields are required.");
        }

        // Check if user has enough credits for selected leave
        if (!isset($creditsMap[$leaveType]) || $creditsMap[$leaveType] <= 0) {
            throw new Exception("You have no available credits for $leaveType.");
        }

        // Fetch applicant name and department
        $stmtInfo = $conn->prepare("
            SELECT a.applicant_name, d.DepartmentName
            FROM users u
            LEFT JOIN applicants a ON u.applicant_id = a.id
            LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID
            WHERE u.id = :userId
        ");
        $stmtInfo->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmtInfo->execute();
        $result = $stmtInfo->fetch(PDO::FETCH_ASSOC);

        if (!$result || empty($result['applicant_name']) || empty($result['DepartmentName'])) {
            throw new Exception("Applicant or department information not found.");
        }

        $applicantName = $result['applicant_name'];
        $department = $result['DepartmentName'];

        // Insert into leaveapplication (no credit deduction yet)
        $stmt = $conn->prepare("
            INSERT INTO leaveapplication (employeeId, name, leave_type, date, department, message) 
            VALUES (:employeeId, :name, :leaveType, :leaveDate, :department, :message)
        ");
        $stmt->bindParam(':employeeId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $applicantName);
        $stmt->bindParam(':leaveType', $leaveType);
        $stmt->bindParam(':leaveDate', $leaveDate);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            $messageFeedback = "<p style='color:green;'>Leave request submitted successfully!</p>";
        } else {
            throw new Exception("Failed to submit leave request.");
        }

    } catch (Exception $e) {
        $messageFeedback = "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}

// Handle leave request approval/rejection by the manager
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['approve_leave'])) {
    $leaveRequestId = $_POST['leave_request_id'];
    $status = $_POST['status']; // 'approved' or 'rejected'

    // Check the current leave request
    $stmtCheck = $conn->prepare("SELECT leave_type, employeeId FROM leaveapplication WHERE id = :leave_request_id");
    $stmtCheck->bindParam(':leave_request_id', $leaveRequestId, PDO::PARAM_INT);
    $stmtCheck->execute();
    $leaveRequest = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($leaveRequest) {
        $leaveType = $leaveRequest['leave_type'];
        $employeeId = $leaveRequest['employeeId'];

        if ($status === 'approved') {
            // Move the record from leaveapplication to leave_requests
            $stmtMove = $conn->prepare("
                INSERT INTO leave_requests (employeeId, name, leave_type, date, department, message, status) 
                SELECT employeeId, name, leave_type, date, department, message, :status
                FROM leaveapplication
                WHERE id = :leave_request_id
            ");
            $stmtMove->bindParam(':status', $status);
            $stmtMove->bindParam(':leave_request_id', $leaveRequestId, PDO::PARAM_INT);
            $stmtMove->execute();

            // After moving, delete the record from leaveapplication
            $stmtDelete = $conn->prepare("DELETE FROM leaveapplication WHERE id = :leave_request_id");
            $stmtDelete->bindParam(':leave_request_id', $leaveRequestId, PDO::PARAM_INT);
            $stmtDelete->execute();

            // If the leave type is approved, deduct leave credits
            $stmtCheckCredits = $conn->prepare("SELECT credits FROM leave_credits WHERE user_id = :employeeId AND leave_type_id = (SELECT id FROM leavetype WHERE leave_type = :leaveType)");
            $stmtCheckCredits->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
            $stmtCheckCredits->bindParam(':leaveType', $leaveType);
            $stmtCheckCredits->execute();
            $creditData = $stmtCheckCredits->fetch(PDO::FETCH_ASSOC);

            if ($creditData && $creditData['credits'] > 0) {
                // Deduct 1 leave credit if enough credits are available
                $stmtUpdateCredit = $conn->prepare("
                    UPDATE leave_credits 
                    SET credits = credits - 1 
                    WHERE user_id = :employeeId AND leave_type_id = (SELECT id FROM leavetype WHERE leave_type = :leaveType)
                ");
                $stmtUpdateCredit->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
                $stmtUpdateCredit->bindParam(':leaveType', $leaveType);
                $stmtUpdateCredit->execute();
            }
        } else if ($status === 'rejected') {
            // Just delete the record from leaveapplication if rejected
            $stmtDelete = $conn->prepare("DELETE FROM leaveapplication WHERE id = :leave_request_id");
            $stmtDelete->bindParam(':leave_request_id', $leaveRequestId, PDO::PARAM_INT);
            $stmtDelete->execute();
        }
    }
}

// Pagination and Leave History Loading
$recordsPerPage = 5;
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($currentPage - 1) * $recordsPerPage;

try {
    $userId = $_SESSION['user_id'];

    $stmt1 = $conn->prepare("
        SELECT id, employeeId, name, leave_type, date, department, message, status
        FROM leaveapplication
        WHERE employeeId = :user_id
    ");
    $stmt1->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt1->execute();
    $leaveApplications = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $stmt2 = $conn->prepare("
        SELECT id, employeeId, name, leave_type, date, department, message, status
        FROM leave_requests
        WHERE employeeId = :user_id
    ");
    $stmt2->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt2->execute();
    $leaveRequests = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $allLeaveData = array_merge($leaveApplications, $leaveRequests);

    usort($allLeaveData, function ($a, $b) {
        return strtotime($b['date']) <=> strtotime($a['date']);
    });

    $totalRecords = count($allLeaveData);
    $totalPages = ceil($totalRecords / $recordsPerPage);
    $paginatedData = array_slice($allLeaveData, $offset, $recordsPerPage);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- icon -->
    <link rel="shortcut icon" href="../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- ajax -->
    <script defer src="../node_modules/jquery/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- global JavaScript -->
    <script defer type="module" src="../assets/libs/js/global-script.js"></script>

    <!-- main js -->
    <script defer type="module" src="../assets/libs/js/main-js.js"></script>
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="css/leave2.css">

    <!-- assts csss -->
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

    <!-- slimscroll js -->
    <script defer type="module" src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

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
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php include 'sideandnavbar.php'; ?>
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
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                        <div class="page-header">
                        </div>

                        <div class="page">
                            <div class="apply">
                                <h3>Apply for Leave</h3>
           <!-- Display Leave Application Form -->
           <?= $messageFeedback ?? '' ?>

<form method="POST" action="">
    <label for="leaveType">Leave Type</label><br>
    <select id="leaveType" name="leaveType" required>
        <option value="">Select Leave Type</option>
        <?php foreach ($leaveTypes as $leaveType): 
            $type = htmlspecialchars($leaveType['leave_type']);
            $credits = isset($creditsMap[$type]) ? (int)$creditsMap[$type] : 0;
            $disabled = $credits <= 0 ? 'disabled' : '';
        ?>
            <option value="<?= $type ?>" <?= $disabled ?>>
                <?= $type ?> (Credits: <?= $credits ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <label for="dateInput">Leave Date</label><br>
    <input type="date" id="dateInput" name="dateInput" required><br><br>

    <label for="message">Leave Message</label><br>
    <input type="text" id="message" name="message" required><br><br>

    <button type="submit" id="applyLeaveBtn" class="apply-btn">Apply for Leave</button>
</form>
                            </div>
                        </div>
</div>
</div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="leaves">
                                    <h3>My Leaves</h3>
                                    <table class="table table-hover">
    <thead>
        <tr>
            <?php if (!empty($allLeaveData)): ?>
                <?php foreach (array_keys($allLeaveData[0]) as $column): ?>
                    <th style="background-color: #3d405c; color: white; padding: 10px; text-align: left;">
                        <?= htmlspecialchars($column) ?>
                    </th>
                <?php endforeach; ?>
            <?php else: ?>
                <th colspan="8" style="padding: 10px; text-align: center;">No data available</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($allLeaveData)): ?>
            <?php foreach ($paginatedData as $application): ?>
                <tr>
                    <?php foreach ($application as $key => $value): ?>
                        <?php if ($key === 'status'): ?>
                            <td style="padding: 8px; border: 1px solid #ddd;">
                                <span style="
                                    display: inline-block;
                                    padding: 5px 10px;
                                    border-radius: 4px;
                                    font-weight: bold;
                                    border: 1px solid;
                                    color: <?php
                                        if ($value === 'pending')
                                            echo '#8a6d3b';
                                        elseif ($value === 'approved')
                                            echo 'white';
                                        elseif ($value === 'rejected')
                                            echo 'white';
                                        else
                                            echo 'black';
                                    ?>;
                                    background-color: <?php
                                        if ($value === 'pending')
                                            echo '#f0ad4e';
                                        elseif ($value === 'approved')
                                            echo '#5cb85c';
                                        elseif ($value === 'rejected')
                                            echo '#d9534f';
                                        else
                                            echo 'transparent';
                                    ?>;
                                    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
                                ">
                                    <?= htmlspecialchars($value) ?>
                                </span>
                            </td>
                        <?php else: ?>
                            <td style="padding: 8px; border: 1px solid #ddd;">
                                <?= htmlspecialchars($value) ?>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="padding: 10px; text-align: center;">
                    No records found.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Pagination Controls -->
<div style="margin-top: 20px; text-align: center;">
    <?php if ($totalPages > 1): ?>
        <!-- Previous Button -->
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1 ?>"
                style="padding: 8px 12px; border: 1px solid #3d405c; margin: 0 4px; text-decoration: none; color: #3d405c;">
                Previous
            </a>
        <?php endif; ?>

        <!-- Page Number Links -->
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>"
                style="padding: 8px 12px; border: 1px solid #3d405c; margin: 0 4px; text-decoration: none; color: <?= $currentPage === $i ? 'white' : '#3d405c'; ?>; background-color: <?= $currentPage === $i ? '#3d405c' : 'transparent'; ?>;">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <!-- Next Button -->
        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>"
                style="padding: 8px 12px; border: 1px solid #3d405c; margin: 0 4px; text-decoration: none; color: #3d405c;">
                Next
            </a>
        <?php endif; ?>
    <?php endif; ?>
</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <script>
document.getElementById('leaveType').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    if (selectedOption.disabled) {
        alert('You have no remaining credits for this leave type.');
        this.value = '';
    }
});
</script>
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