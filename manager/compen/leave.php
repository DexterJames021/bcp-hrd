<?php
require "../../config/Database.php";
require '../../auth/accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);
try {
    // Query the leave types from the database
    $stmt = $conn->prepare("SELECT leave_type FROM leavetype");
    $stmt->execute();

    // Fetch all leave types
    $leaveTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
// Apply Leave Logic
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Validate session
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
            throw new Exception("User not logged in. Please log in to apply for leave.");
        }

        // Retrieve session variables
        $userId = $_SESSION['user_id'];
        $username = $_SESSION['username'];

        // Sanitize form inputs
        $leaveType = htmlspecialchars($_POST['leaveType']);
        $leaveDate = htmlspecialchars($_POST['dateInput']);
        $message = htmlspecialchars($_POST['message']);

        // Validate form data
        if (empty($leaveType) || empty($leaveDate) || empty($message)) {
            throw new Exception("All fields are required. Please fill out the form completely.");
        }

        // Fetch employeeId and department based on the logged-in user
        $fetchStmt = $conn->prepare("
            SELECT a.id AS employeeId, a.applicant_name AS name, d.DepartmentName AS department
            FROM users u
            LEFT JOIN applicants a ON u.applicant_id = a.id
            LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID
            WHERE u.id = :userId
        ");
        $fetchStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $fetchStmt->execute();

        $userData = $fetchStmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            throw new Exception("User data not found. Cannot apply for leave.");
        }

        // Now insert using SELECT and JOIN logic
        $insertStmt = $conn->prepare("
            INSERT INTO leave_requests (employeeId, name, leave_type, date, department, message, head)
            SELECT 
                :employeeId, :name, :leaveType, :leaveDate, :department, :message, a.applicant_name
            FROM users u
            LEFT JOIN applicants a ON u.applicant_id = a.id
            WHERE u.id = :userId
        ");

        // Bind parameters
        $insertStmt->bindParam(':employeeId', $userData['employeeId'], PDO::PARAM_INT);
        $insertStmt->bindParam(':name', $userData['name'], PDO::PARAM_STR);
        $insertStmt->bindParam(':leaveType', $leaveType, PDO::PARAM_STR);
        $insertStmt->bindParam(':leaveDate', $leaveDate, PDO::PARAM_STR);
        $insertStmt->bindParam(':department', $userData['department'], PDO::PARAM_STR);
        $insertStmt->bindParam(':message', $message, PDO::PARAM_STR);
        $insertStmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        if ($insertStmt->execute()) {
            echo "<script>alert('Leave request submitted successfully!');</script>";
            echo "<p style='color:green;'>Leave request submitted successfully!</p>";
        } else {
            throw new Exception("Failed to submit leave request. Please try again.");
        }

    } catch (Exception $e) {
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}

// try {
//     // Query to get all records from the leaveapplication table for the specific user
//     $stmt = $conn->prepare("SELECT * FROM leaveapplication WHERE employeeId = :user_id");
//     $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
//     $stmt->execute();

//     // Fetch all results
//     $leaveApplications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// } catch (PDOException $e) {
//     die("Connection failed: " . $e->getMessage());
// }

try {
    // Define the number of records per page
    $recordsPerPage = 5;

    // Get the current page from the URL, if not set default to 1
    $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    // Calculate the starting record index
    $offset = ($currentPage - 1) * $recordsPerPage;

    // First, get the total number of records for pagination
    $countStmt = $conn->prepare("SELECT COUNT(*) FROM leave_requests WHERE employeeId = :user_id");
    $countStmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $countStmt->execute();
    $totalRecords = $countStmt->fetchColumn();

    // Calculate the total number of pages
    $totalPages = ceil($totalRecords / $recordsPerPage);

    // Now, query to get the records for the current page
    $stmt = $conn->prepare("SELECT * FROM leave_requests WHERE employeeId = :user_id ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindValue(':limit', $recordsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch all results
    $leaveApplications = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <!-- <h2 class="pageheader-title"> </h2> -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="page">
                                    <div class="apply">
                                        <h3>Apply for Leave</h3>

                                        <!-- Add a form tag with method="post" -->
                                        <form method="POST" action="">
                                            <label for="leaveType">Leave Type</label><br>
                                            <select class="form-select form-select-lg mb-6"
                                                aria-label="Default select example" id="leaveType" name="leaveType"
                                                required>
                                                <option value="">Select Leave Type</option>
                                                <?php foreach ($leaveTypes as $leaveType): ?>
                                                    <option value="<?= htmlspecialchars($leaveType['leave_type']) ?>">
                                                        <?= htmlspecialchars($leaveType['leave_type']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>

                                            <label for="dateInput">Leave Date</label><br>
                                            <input class="form-control" type="date" id="dateInput" name="dateInput"
                                                required>
                                            <div class="mb-3">
                                                <label for="message" class="form-label">Leave Message</label><br>
                                                <textarea class="form-control" id="message" name="message" rows="3"
                                                    required></textarea>
                                            </div>
                                            <!-- Change the button type to "submit" to submit the form -->
                                            <button type="submit" id="applyLeaveBtn"
                                                class="btn btn-primary apply-btn">Apply for Leave</button>
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
                                <div class="page">
                                    <div class="leaves">
                                        <h3>My Leaves</h3>
                                        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                                            <thead>
                                                <tr>
                                                    <?php if (!empty($leaveApplications)): ?>
                                                        <?php foreach (array_keys($leaveApplications[0]) as $column): ?>
                                                            <th
                                                                style="background-color: #3d405c; color: white; padding: 10px; text-align: left;">
                                                                <?= htmlspecialchars($column) ?>
                                                            </th>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <th style="padding: 10px;">No data available</th>
                                                    <?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($leaveApplications)): ?>
                                                    <?php foreach ($leaveApplications as $application): ?>
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
                                    elseif ($value === 'accepted')
                                        echo 'white';
                                    elseif ($value === 'denied')
                                        echo 'white';
                                    else
                                        echo 'black';
                                    ?>;
                                    background-color: <?php
                                    if ($value === 'pending')
                                        echo '#f0ad4e'; // Yellowish color
                                    elseif ($value === 'accepted')
                                        echo '#5cb85c'; // Green
                                    elseif ($value === 'denied')
                                        echo '#d9534f'; // Red
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
                                                        <td colspan="<?= count($leaveApplications[0]) ?>"
                                                            style="padding: 10px; text-align: center;">
                                                            No records found.
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>

                                        <!-- Pagination Links -->
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