<?php
require "../../config/Database.php";
require '../../auth/accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);
$recordsPerPage = 10;

// Get the current page number from URL parameter, default is 1
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// Calculate the starting record for the SQL query
$startFrom = ($page - 1) * $recordsPerPage;

// Handle form submission to update status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_status']) && isset($_POST['leave_id'])) {
        $leaveId = $_POST['leave_id'];
        $newStatus = $_POST['update_status'];

        // Prepare the SQL query to update the status
        $stmt = $conn->prepare("UPDATE leave_requests SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $newStatus);
        $stmt->bindParam(':id', $leaveId);

        try {
            $stmt->execute();
            echo "<script>alert('Status updated successfully');</script>"; // Optional: Alert for success
        } catch (PDOException $e) {
            echo "<script>alert('Error updating status: " . $e->getMessage() . "');</script>";
        }
    }
}

// Fetch data from the database (pagination and sorting already applied)
try {
    $stmt = $conn->prepare("SELECT id, employeeId, name, leave_type, date, department, message, head, status FROM leave_requests ORDER BY FIELD(status, 'pending') DESC, id ASC LIMIT :startFrom, :recordsPerPage");
    $stmt->bindParam(':startFrom', $startFrom, PDO::PARAM_INT);
    $stmt->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $benefitData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of records to calculate the number of pages
    $totalStmt = $conn->prepare("SELECT COUNT(*) FROM leave_requests");
    $totalStmt->execute();
    $totalRecords = $totalStmt->fetchColumn();
    $totalPages = ceil($totalRecords / $recordsPerPage);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Delete functionality
if (isset($_POST['delete_leave'])) {
    $leaveId = $_POST['leave_id'];  // Get the leave ID to be deleted

    try {
        // Prepare and execute the DELETE query
        $deleteStmt = $conn->prepare("DELETE FROM leave_requests WHERE id = :leaveId");
        $deleteStmt->bindParam(':leaveId', $leaveId, PDO::PARAM_INT);
        $deleteStmt->execute();

        // Redirect back to the same page (or show a success message)
        header("Location: leave.php");  // Replace 'your_page.php' with the actual page URL
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

    <script defer src="../../node_modules/jquery/dist/jquery.min.js"></script>

    <!-- bs -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- jquery -->
    <script defer src="../../node_modules/jquery/dist/jquery.js"></script>

    <!-- global JavaScript -->
    <script defer type="module" src="../../assets/libs/js/global-script.js"></script>

    <!-- main js -->
    <script defer type="module" src="../../assets/libs/js/main-js.js"></script>
    <link rel="stylesheet" href="../../assets/libs/css/style.css">

    <!-- assts csss -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <!-- slimscroll js -->
    <script defer type="module" src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <link rel="stylesheet" href="css/leave.css">
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
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <!-- <h2 class="pageheader-title">Dashboard</h2> -->

                            <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel
                                mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                        </li>
                                        <!-- <li class="breadcrumb-item active" aria-current="page">Dashboard</li> -->
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader  -->
                <!-- ============================================================== -->
                <!-- <div class="ecommerce-widget"> -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h1>Leave Applications</h1>
                                <div class="table-responsive">
                                    <!-- Start of Table -->
                                    <table class="table table-hover">
    <thead>
        <tr>
            <th style="color:black">ID</th>
            <th style="color:black">Employee ID</th>
            <th style="color:black">Name</th>
            <th style="color:black">Leave</th>
            <th style="color:black">Date</th>
            <th style="color:black">Department</th>
            <th style="color:black">Message</th>
            <th style="color:black">Head</th>
            <th style="color:black">Status</th>
            <th style="color:black">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($benefitData)) {
            foreach ($benefitData as $row) {
                // Apply status class for styling
                $statusClass = '';
                if ($row['status'] == 'pending') {
                    $statusClass = 'status-pending';
                } elseif ($row['status'] == 'approved') {
                    $statusClass = 'status-approved';
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
                    <td>" . htmlspecialchars($row['head']) . "</td>
                    <td><span class='status-text $statusClass'>" . htmlspecialchars($row['status']) . "</span></td>
                    <td>";

                // Only show buttons if the status is 'pending'
                if ($row['status'] == 'pending') {
                    echo "<form method='POST' action='' style='display:inline-block;'>
                            <input type='hidden' name='leave_id' value='" . htmlspecialchars($row['id']) . "' />
                            <button type='submit' name='update_status' value='approved' class='btn btn-secondary btn-sm' style='background-color:#169976;'>Approve</button>
                          </form>
                          <form method='POST' action='' style='display:inline-block;'>
                            <input type='hidden' name='leave_id' value='" . htmlspecialchars($row['id']) . "' />
                            <button type='submit' name='update_status' value='rejected' class='btn btn-danger btn-sm'>Decline</button>
                          </form>";
                } else {
                    // Show delete button for non-pending
                    echo "<form method='POST' action=''>
                            <input type='hidden' name='leave_id' value='" . htmlspecialchars($row['id']) . "' />
                            <a href='benefits.php?deleteId=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
                                <button type='submit' name='delete_leave' value='delete' class='btn btn-danger btn-sm'>Delete</button>
                            </a>
                          </form>";
                }

                echo "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>
                                    
                                </div>

                                <!-- End of Table -->



                                <!-- Pagination Links -->
                                <div style="text-align: center; margin-top: 20px;">
                                    <ul style="list-style-type: none; padding: 0;">
                                        <?php if ($page > 1): ?>
                                            <li style="display: inline; margin-right: 10px;">
                                                <a href="?page=<?= $page - 1 ?>"
                                                    style="text-decoration: none; background-color: #3d405c; color: white; padding: 8px 16px; border-radius: 4px;">Previous</a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li style="display: inline; margin-right: 5px;">
                                                <a href="?page=<?= $i ?>"
                                                    style="text-decoration: none; background-color: <?= $i == $page ? '#3d405c' : '#f4f4f4'; ?>; color: <?= $i == $page ? 'white' : '#333'; ?>; padding: 8px 16px; border-radius: 4px;"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($page < $totalPages): ?>
                                            <li style="display: inline; margin-left: 10px;">
                                                <a href="?page=<?= $page + 1 ?>"
                                                    style="text-decoration: none; background-color: #3d405c; color: white; padding: 8px 16px; border-radius: 4px;">Next</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <!-- End of Pagination -->
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

    <script>
        // Function to open the modal and set the leave ID to be deleted
        function openModal(leaveId) {
            // Set the value of the hidden input in the form to the leave ID
            document.getElementById('leave_id_to_delete').value = leaveId;

            // Open the modal
            $('#confirmationModal').modal('show');
        }
    </script>
</body>

</html>