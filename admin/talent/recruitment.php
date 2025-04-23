<?php
require "../../config/db_talent.php";
require '../../auth/mysqli_accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

// Fetch total applicants
$sql = "SELECT COUNT(*) AS pending_applicants FROM applicants WHERE status != 'Hired'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$pendingApplicants = $row['pending_applicants'];




// Fetch the total number of job postings
$job_posting_query = "SELECT COUNT(*) AS job_posting_count FROM job_postings";
$job_posting_result = mysqli_query($conn, $job_posting_query);
$job_posting_count = 0;

// If job postings exist, fetch the count
if ($job_posting_result) {
    $row = mysqli_fetch_assoc($job_posting_result);
    $job_posting_count = $row['job_posting_count'];
}

// Fetch the total number of open job postings
$open_job_posting_query = "SELECT COUNT(*) AS open_job_posting_count FROM job_postings WHERE status = 'Open'";
$open_job_posting_result = mysqli_query($conn, $open_job_posting_query);
$open_job_posting_count = 0;

// If open job postings exist, fetch the count
if ($open_job_posting_result) {
    $row = mysqli_fetch_assoc($open_job_posting_result);
    $open_job_posting_count = $row['open_job_posting_count'];
}

// Fetch the total number of departments
$department_query = "SELECT COUNT(*) AS department_count FROM departments";
$department_result = mysqli_query($conn, $department_query);
$department_count = 0;

// If departments exist, fetch the count
if ($department_result) {
    $row = mysqli_fetch_assoc($department_result);
    $department_count = $row['department_count'];
}

// Updated SQL query to include department names
$sql = "SELECT jp.*, d.DepartmentName AS department_name 
FROM job_postings jp 
JOIN departments d ON jp.DepartmentID = d.DepartmentID";
$result = $conn->query($sql);

// Fetch departments for the dropdown
$department_sql = "SELECT DepartmentID, DepartmentName FROM departments";
$department_result = $conn->query($department_sql);
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Recruitment</title>
    <link rel="shortcut icon" href="../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- ✅ Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- ✅ FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css">

    <!-- ✅ Custom Styles -->
    <link rel="stylesheet" href="styledash6.css">
    <link rel="stylesheet" href="../../assets/libs/css/style.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css">
 <!-- ✅ jQuery (Kailangan bago ang DataTables) -->

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- ✅ DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

   

    <!-- ✅ DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- ✅ Slimscroll (if needed) -->
    <script defer src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

    <!-- ✅ Custom JavaScript Files -->
    <script defer src="../../assets/libs/js/global-script.js"></script>
    <script defer src="../../assets/libs/js/main-js.js"></script>

    <!-- ✅ Auto-hide Alert (5s) -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 5000); // Hide alert after 5 seconds
            }

            // ✅ Initialize DataTables
            $('#yourTableID').DataTable(); // ⚠️ Palitan ng actual table ID mo
        });
    </script>

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
            <?php if ($userData && in_array("VIEW", $userData['permissions'])): ?>
            <div class="container-fluid dashboard-content ">
                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
        
                <!-- ============================================================== -->
                <!-- end pageheader  -->
                <!-- ============================================================== -->
                <!-- <div class="ecommerce-widget"> -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h1>Recruitment</h1>
                            <!-- Summary Cards -->
                                 <div class="row">
                                    <div class="col-md-3">
                                        <div class="card bg-light text-white">
                                            <div class="card-body">
                                                <h5>Total Jobs</h5>
                                                <h3><?php echo $job_posting_count; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-light text-white">
                                            <div class="card-body">
                                                <h5>Total Departments</h5>
                                                <h3><?php echo $department_count; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-light text-dark">
                                            <div class="card-body">
                                                <h5>Total Open Jobs</h5>
                                                <h3><?php echo $open_job_posting_count; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-light text-dark">
                                            <div class="card-body">
                                                <h5>Pending Applicants</h5>
                                                <h3><?php echo $pendingApplicants; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                <hr>
                               
                        
                                <?php if (isset($_SESSION['message'])): ?>
                                    <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                                        <?php 
                                        echo $_SESSION['message']; 
                                        unset($_SESSION['message']); // Clear the message after displaying
                                        ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>

                                <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
                                <li class="nav-item">
        <a class="nav-link active" id="applicants-tab" data-toggle="tab" href="#applicants" role="tab">Applicants</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " id="jobs-tab" data-toggle="tab" href="#jobs" role="tab">Jobs</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="departments-tab" data-toggle="tab" href="#departments" role="tab">Departments</a>
    </li>

    
</ul>


<div class="tab-content" id="dashboardTabContent">

    <!-- Jobs Tab -->
    <div class="tab-pane fade " id="jobs" role="tabpanel" aria-labelledby="jobs-tab">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h1 class="card-title">Jobs</h1>
                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addJobModal">Add Job</button>
            </div>
            <div class="card-body">
                <table class="table table-hover" id="myJobs" style="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Job Title</th>
                            <th>Status</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
$counter = 1; // Move the counter outside the loop

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Fetch the count of applicants for the specific job ID, excluding "Hired" status
        $jobId = $row['id'];
        $applicantCountSql = "SELECT COUNT(*) as totalApplicants FROM applicants WHERE job_id = ? AND status != 'Hired'";
        $stmt = $conn->prepare($applicantCountSql);
        $stmt->bind_param("i", $jobId);
        $stmt->execute();
        $resultApplicants = $stmt->get_result();
        $applicantCount = 0;

        if ($resultApplicants->num_rows > 0) {
            $countRow = $resultApplicants->fetch_assoc();
            $applicantCount = $countRow['totalApplicants'];
        }

        echo "<tr>";
        echo "<td>" . $counter . "</td>"; // Correct numbering
        echo "<td>" . htmlspecialchars($row['job_title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td>" . htmlspecialchars($row['department_name']) . "</td>";
        echo "<td>
        <button data-toggle='modal' 
                data-target='#editJobModal' 
                data-id='" . htmlspecialchars($row['id']) . "' 
                data-title='" . htmlspecialchars($row['job_title']) . "' 
                data-description='" . htmlspecialchars($row['job_description']) . "' 
                data-requirements='" . htmlspecialchars($row['requirements']) . "' 
                data-location='" . htmlspecialchars($row['location']) . "' 
                data-salary='" . htmlspecialchars($row['salary_range']) . "' 
                data-status='" . htmlspecialchars($row['status']) . "' 
                title='Edit Job' 
                style='border: none; background: none; cursor: pointer; margin-right: 10px;'>
            <i class='fas fa-edit text-warning' style='font-size: 16px;'></i> <!-- Edit Icon -->
        </button>

        <a href='recruitment/delete_job.php?id=" . htmlspecialchars($row['id']) . "' 
           onclick='return confirm(\"Are you sure you want to delete this job posting?\");' 
           title='Delete Job' 
           style='margin-right: 10px; text-decoration: none;'>
            <i class='fas fa-trash-alt text-danger' style='font-size: 16px;'></i> <!-- Trash Icon -->
        </a>

                <a href='recruitment.php?job_id=" . htmlspecialchars($row['id']) . "#applicant' 
                   title='View Applicants' 
                   style='text-decoration: none; color: inherit;'>
                    <i class='fas fa-users' style='font-size: 16px; color: #28a745;'></i> 
                    <span style='margin-left: 5px;'>" . $applicantCount . "</span>
                </a>
            </td>";
        echo "</tr>";

        $counter++; // Increment counter correctly
    }
} else {
    echo "<tr><td colspan='4'>No job postings found.</td></tr>"; // Adjusted colspan
}
?>
</tbody>




                </table>
            </div>
        </div>
    </div>

    <!-- Departments Tab -->
    <div class="tab-pane fade" id="departments" role="tabpanel" aria-labelledby="departments-tab">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h1 class="card-title">Departments</h1>
                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addDepartmentModal">Add Department</button>
            </div>
            <div class="card-body">
                <table class="table table-hover" id="myDepartments" style="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>Department Name</th>
                            <th>Manager</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                 <tbody>
    <?php
    // Query to fetch departments with managers
    $sql = "SELECT d.DepartmentID, d.DepartmentName, e.FirstName AS Manager 
            FROM departments d
            LEFT JOIN employees e ON d.ManagerID = e.EmployeeID";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['DepartmentName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Manager'] ?? 'No Manager') . "</td>"; // Show manager or 'No Manager'
            echo "<td>
            <button data-toggle='modal' 
                    data-target='#editDepartmentModal' 
                    data-id='" . htmlspecialchars($row['DepartmentID']) . "' 
                    data-name='" . htmlspecialchars($row['DepartmentName']) . "' 
                    data-manager='" . htmlspecialchars($row['Manager'] ?? '') . "' 
                    title='Edit Department' 
                    style='border: none; background: none; cursor: pointer; margin-right: 10px;'>
                <i class='fas fa-edit text-warning' style='font-size: 16px;'></i> <!-- Edit Icon -->
            </button>

            <a href='recruitment/delete_department.php?DepartmentID=" . htmlspecialchars($row['DepartmentID']) . "' 
               onclick='return confirm(\"Are you sure you want to delete this department?\");' 
               title='Delete Department' 
               style='text-decoration: none;'>
                <i class='fas fa-trash-alt text-danger' style='font-size: 16px;'></i> <!-- Trash Icon -->
            </a>
                </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No departments found.</td></tr>"; // Adjusted colspan
    }
    ?>
</tbody>

                </table>
            </div>
        </div>
    </div>

  

    <!-- Applicants Tab -->
    <div class="tab-pane fade show active" id="applicants" role="tabpanel" aria-labelledby="applicants-tab">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h1 class="card-title">Applicants</h1>
            </div>
            <div class="card-body">
                <table id="myApplicants" class="table table-hover" style="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Job Applied</th>
                            <th>Status</th>
                            <th>Department</th>
                            <th>Resume</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    // Get job_id from URL, default to 0 if not set
    $job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

    // SQL query to fetch applicants excluding those who are "Hired"
    $sql = $job_id > 0 
        ? "SELECT a.id, a.applicant_name, a.email, j.job_title, a.status, a.applied_at, a.interview_date, a.interview_time, a.resume_path, d.DepartmentName
            FROM applicants a
            LEFT JOIN job_postings j ON a.job_id = j.id
            LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID
            WHERE a.job_id = $job_id AND a.status != 'Hired'"
        : "SELECT a.id, a.applicant_name, a.email, j.job_title, a.status, a.applied_at, a.interview_date, a.interview_time, a.resume_path, d.DepartmentName
            FROM applicants a
            LEFT JOIN job_postings j ON a.job_id = j.id
            LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID
            WHERE a.status != 'Hired'"; // Exclude hired applicants

    $result = $conn->query($sql);
    $counter = 1; // Start numbering from 1
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $counter . "</td>"; // Row number
            echo "<td>" . htmlspecialchars($row['applicant_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['job_title']) . "</td>";
            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
            echo "<td>" . htmlspecialchars($row['DepartmentName']) . "</td>";

            // Resume Download Button
            echo "<td>";
            if (!empty($row['resume_path'])) {
                $file_path = htmlspecialchars($row['resume_path']);
                $file_name = basename($file_path); // Extract filename
            
                echo "<a href='/bcp-hrd/admin/talent/recruitment/" . $file_path . "' download='" . $file_name . "' class='btn btn-info btn-sm'>
                        <i class='fas fa-file-download'></i> Download Resume
                      </a>";
            } else {
                echo "No File";
            }
            echo "</td>";
            
            echo "<td class='action-buttons'>";

            // Form for status updates
            echo "<form action='recruitment/update_status.php?job_id=" . htmlspecialchars($job_id) . "' method='POST'>";
            echo "<input type='hidden' name='applicant_id' value='" . htmlspecialchars($row['id']) . "'>";

            if ($row['status'] === 'Pending') {
                echo "<button type='submit' name='status' value='Selected for Interview' class='btn btn-primary btn-sm' 
                        onclick='return confirm(\"Are you sure you want to select this applicant for an interview?\")'>
                        <i class='fas fa-calendar-check'></i> 
                      </button>"; 
                echo "<button type='submit' name='status' value='Rejected' class='btn btn-danger btn-sm' 
                        onclick='return confirm(\"Are you sure you want to reject this applicant?\")'>
                        <i class='fas fa-user-times'></i> 
                      </button>"; 
            } elseif ($row['status'] === 'Interviewed') {
                echo "<button type='submit' name='status' value='Shortlisted' class='btn btn-success btn-sm'>
                        <i class='fas fa-user-check'></i> 
                      </button>"; 
                echo "<button type='submit' name='status' value='Rejected' class='btn btn-danger btn-sm'>
                        <i class='fas fa-user-times'></i> 
                      </button>"; 
            } elseif ($row['status'] === 'Shortlisted') {
                echo "<button type='submit' name='status' value='Hired' class='btn btn-success btn-sm'>
                        <i class='fas fa-briefcase'></i> 
                      </button>"; 
                echo "<button type='submit' name='status' value='Rejected' class='btn btn-danger btn-sm'>
                        <i class='fas fa-user-times'></i> 
                      </button>"; 
            }

            echo "</form>";

            // Delete button for rejected applicants
            if ($row['status'] === 'Rejected') {
                echo "<a href='recruitment/delete_applicant.php?applicant_id=" . htmlspecialchars($row['id']) . "' 
                       class='btn btn-danger btn-sm' 
                       onclick='return confirm(\"Are you sure you want to delete this rejected applicant?\");'>
                        <i class='fas fa-trash'></i> 
                      </a>"; 
            }

            // Interview scheduling form
            if ($row['status'] === 'Selected for Interview') {
                echo "<form action='recruitment/schedule_interview.php?job_id=" . htmlspecialchars($job_id) . "' method='POST' class='schedule-form'>";
                echo "<input type='hidden' name='applicant_id' value='" . htmlspecialchars($row['id']) . "'>";

                echo "<label for='interview_date'></label>
                      <input type='date' name='interview_date' required>
                      
                      <label for='interview_time'></label>
                      <input type='time' name='interview_time' required>
                      
                      <button type='submit' class='btn btn-primary btn-sm'>
                        <i class='fas fa-clock'></i> 
                      </button>";
                echo "</form>";
            }

            echo "</td>";
            echo "</tr>";
            $counter++; // Increment counter
        }
    } else {
        echo "<tr><td colspan='7'>No applicants found.</td></tr>";
    }
    ?>
</tbody>



                </table>
            </div>
        </div>
    </div>

</div>

<script>
    // Check if the page is being reloaded
    if (performance.navigation.type === 1) { // 1 indicates a page reload
        window.location.href = 'recruitment.php'; // Redirect to default URL
    }
</script>

                                   
<!-- Edit Department Modal -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDepartmentModalLabel">Edit Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="recruitment/edit_department.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="editDepartmentId" name="department_id">

                    <div class="form-group">
                        <label for="editDepartmentName">Department Name</label>
                        <input type="text" class="form-control" id="editDepartmentName" name="department_name" required>
                    </div>

                    <div class="form-group">
                        <label for="editManager">Manager</label>
                        <select class="form-control" id="editManager" name="manager_id">
                            <option value="">No Manager</option>
                            <?php
                            // Assuming you have a query to fetch employee options for the manager selection
                            $managerSql = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) AS ManagerName FROM employees";
                            $managerResult = $conn->query($managerSql);

                            if ($managerResult->num_rows > 0) {
                                while ($managerRow = $managerResult->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($managerRow['EmployeeID']) . "'>" . htmlspecialchars($managerRow['ManagerName']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Select all edit buttons
    const editButtons = document.querySelectorAll('.btn-warning[data-target="#editDepartmentModal"]');
    
    // Add click event listener to each button
    editButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            // Get department data attributes
            const departmentId = button.getAttribute('data-id');
            const departmentName = button.getAttribute('data-name');
            const managerId = button.getAttribute('data-manager'); // Assuming manager ID is stored here, adjust if needed

            // Set modal form values
            document.getElementById('editDepartmentId').value = departmentId;
            document.getElementById('editDepartmentName').value = departmentName;
            document.getElementById('editManager').value = managerId || ''; // Set to empty if no manager
        });
    });
});

</script>






<!-- Add Department Modal (You need to implement this modal in your HTML) -->
<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDepartmentModalLabel">Add Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="recruitment/add_department.php" method="POST">
                    <div class="form-group">
                        <label for="department_name">Department Name:</label>
                        <input type="text" class="form-control" id="department_name" name="department_name" required>
                    </div>
                    <div class="form-group">
                        <label for="manager_id">Manager ID: (OPTIONAL)</label>
                        <input type="text" class="form-control" id="manager_id" name="manager_id"> <!-- Removed required attribute -->
                    </div>
                    <button type="submit" class="btn btn-primary">Add Department</button>
                </form>
            </div>
        </div>
    </div>
</div>



                        <!-- Modal for displaying messages -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if (isset($_SESSION['success_message'])) {
                        echo $_SESSION['success_message'];
                        unset($_SESSION['success_message']); // Clear the message after displaying
                    } elseif (isset($_SESSION['error_message'])) {
                        echo $_SESSION['error_message'];
                        unset($_SESSION['error_message']); // Clear the message after displaying
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show the modal if there's a message
        window.onload = function() {
            <?php if (isset($_SESSION['success_message']) || isset($_SESSION['error_message'])): ?>
                var modal = new bootstrap.Modal(document.getElementById('messageModal'));
                modal.show();
            <?php endif; ?>
        }
    </script>

<!-- Add Job Posting Modal -->
<!-- Add Job Posting Modal -->
<div class="modal fade" id="addJobModal" tabindex="-1" role="dialog" aria-labelledby="addJobModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJobModalLabel">Add Job Posting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="recruitment/add_job.php" method="POST">
                    <div class="form-group">
                        <label for="job_title">Job Title:</label>
                        <input type="text" class="form-control" id="job_title" name="job_title" required>
                    </div>
                    <div class="form-group">
                        <label for="job_description">Job Description:</label>
                        <textarea class="form-control" id="job_description" name="job_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="requirements">Job Requirements:</label>
                        <textarea class="form-control" id="requirements" name="requirements" placeholder="Enter each requirement on a new line" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="form-group">
                        <label for="salary_range">Salary Range:</label>
                        <input type="text" class="form-control" id="salary_range" name="salary_range" placeholder="e.g. ₱30,000 - ₱50,000" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Open">Open</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="department_id">Department:</label>
                        <select class="form-control" id="department_id" name="DepartmentID" required>
                            <option value="">Select Department</option>
                            <?php
                            // Fetch departments for the dropdown
                            if ($department_result->num_rows > 0) {
                                while ($row = $department_result->fetch_assoc()) {
                                    echo "<option value='" . $row['DepartmentID'] . "'>" . $row['DepartmentName'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No departments available</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Job Posting</button>
                </form>
            </div>
        </div>
    </div>
</div>





<!-- Edit Job Modal -->
<div class="modal fade" id="editJobModal" tabindex="-1" role="dialog" aria-labelledby="editJobModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJobModalLabel">Edit Job Posting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="recruitment/edit_job.php" method="POST" id="editJobForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_job_id" name="job_id">
                    <div class="form-group">
                        <label for="edit_job_title">Job Title:</label>
                        <input type="text" class="form-control" id="edit_job_title" name="job_title" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_job_description">Job Description:</label>
                        <textarea class="form-control" id="edit_job_description" name="job_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_requirements">Job Requirements:</label>
                        <textarea class="form-control" id="edit_requirements" name="requirements" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_location">Location:</label>
                        <input type="text" class="form-control" id="edit_location" name="location" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_salary_range">Salary Range:</label>
                        <input type="text" class="form-control" id="edit_salary_range" name="salary_range" placeholder="e.g. ₱30,000 - ₱50,000" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status:</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="Open">Open</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Job Posting</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Populate edit modal with job details
    $('#editJobModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var jobId = button.data('id');
        var jobTitle = button.data('title');
        var jobDescription = button.data('description');
        var jobRequirements = button.data('requirements');
        var jobLocation = button.data('location');
        var jobSalary = button.data('salary');
        var jobStatus = button.data('status');

        // Update the modal's content.
        var modal = $(this);
        modal.find('#edit_job_id').val(jobId);
        modal.find('#edit_job_title').val(jobTitle);
        modal.find('#edit_job_description').val(jobDescription);
        modal.find('#edit_requirements').val(jobRequirements);
        modal.find('#edit_location').val(jobLocation);
        modal.find('#edit_salary_range').val(jobSalary);
        modal.find('#edit_status').val(jobStatus);
    });
</script>
                            </div>
                            <div id="sparkline-revenue"></div>
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
            <?php else: ?>
                <?php include_once "../403.php"; ?>
            <?php endif; ?>
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
    $(document).ready(function() {
        if ($("#myJobs tbody tr").length > 1) { // Ensure at least one row exists
            $('#myJobs').DataTable({
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
        if ($("#myDepartments tbody tr").length > 1) { // Ensure at least one row exists
            $('#myDepartments').DataTable({
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
        if ($("#myOpens tbody tr").length > 1) { // Ensure at least one row exists
            $('#myOpens').DataTable({
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
        if ($("#myApplicants tbody tr").length > 1) { // Ensure at least one row exists
            $('#myApplicants').DataTable({
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