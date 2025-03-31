<!-- training main dashboard -->
<?php
require "../../config/db_talent.php";
require '../../auth/mysqli_accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

// Fetch the count of training assignments
$assignment_count = 0;
$sql = "SELECT COUNT(*) AS count FROM training_assignments";
if ($result = $conn->query($sql)) {
    $row = $result->fetch_assoc();
    $assignment_count = $row['count'];
}
// Assuming you have an active database connection $conn
$query = "SELECT COUNT(*) AS total_users FROM users";
$result = mysqli_query($conn, $query);

if ($result) {
    $user_count = mysqli_fetch_assoc($result)['total_users'];
} else {
    // Handle the error if the query fails
    $user_count = 0;
}

// Assuming you have a connection to your database already set up

// Fetch the count of training sessions from the database
$sql = "SELECT COUNT(*) AS training_count FROM training_sessions";
$result = $conn->query($sql);

// Get the count value
$trainingCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $trainingCount = $row['training_count'];
}
// Fetch applicants with status 'Hired'
$hiredApplicants = [];
$query = "SELECT id, applicant_name FROM applicants WHERE status = 'Hired'";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $hiredApplicants[] = $row; // Add hired applicants to the array
    }
} else {
    $_SESSION['error_message'] = "Error fetching applicants: " . mysqli_error($conn);
}

// Fetch applicants who already have accounts
$existingApplicants = [];
$query = "SELECT applicant_id FROM users WHERE applicant_id IS NOT NULL";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $existingApplicants[] = $row['applicant_id']; // Store applicant_id of users who have accounts
    }
} else {
    $_SESSION['error_message'] = "Error fetching existing applicants: " . mysqli_error($conn);
}

$pending_hired_count = 0;

$query = "SELECT COUNT(a.id) AS pending_count
          FROM applicants a
          LEFT JOIN users u ON a.id = u.applicant_id
          WHERE u.applicant_id IS NULL AND a.status = 'Hired'"; 

$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $pending_hired_count = $row['pending_count']; // Count of hired applicants without accounts
} else {
    $_SESSION['error_message'] = "Error fetching pending applicants: " . mysqli_error($conn);
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Onboarding</title>
    <link rel="shortcut icon" href="../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styledash6.css">
    <link rel="stylesheet" href="../../assets/libs/css/style.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery (Required for Bootstrap & DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle JS (Includes Popper.js) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Custom JS (Loaded last with defer to prevent blocking) -->
    <script defer src="../../assets/libs/js/global-script.js"></script>
    <script defer src="../../assets/libs/js/main-js.js"></script>
    <script defer src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
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
        
                <!-- ============================================================== -->
                <!-- end pageheader  -->
                <!-- ============================================================== -->
                <!-- <div class="ecommerce-widget"> -->
                    <!-- Button to Open the Modal -->
<!-- Display messages -->
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['error_message']); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php unset($_SESSION['error_message']); // Clear the message after displaying it ?>
    </div>
<?php elseif (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['success_message']); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php unset($_SESSION['success_message']); // Clear the message after displaying it ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body"> 
                <h1>Onboarding</h1>

                <!-- Display error messages if any -->
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($_SESSION['error_message']); ?>
                        <?php unset($_SESSION['error_message']); // Clear the message after displaying ?>
                    </div>
                <?php endif; ?>

                <!-- Summary Cards -->
                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card bg-light text-white">
                                            <div class="card-body">
                                                <h5>Total Users</h5>
                                                <h3><?php echo $user_count; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-light text-white">
                                            <div class="card-body">
                                                <h5>Total Trainings</h5>
                                                <h3><?php echo $trainingCount; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-light text-dark">
                                            <div class="card-body">
                                                <h5>Total Assign</h5>
                                                <h3><?php echo $assignment_count; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-light text-dark">
                                            <div class="card-body">
                                                <h5>Pending Onboarding</h5>
                                                <h3><?php echo $pending_hired_count; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                <hr>

<!-- Bootstrap Modal -->
<div class="modal fade" id="assignTrainingModal" tabindex="-1" role="dialog" aria-labelledby="assignTrainingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assignTrainingModalLabel">Assign Training</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="onboarding/assign_training.php" method="POST"> <!-- Adjust action URL as needed -->
        <div class="modal-body">
          <div class="form-group">
            <label for="training_id">Training ID</label>
            <select class="form-control" id="training_id" name="training_id" required>
              <option value="" disabled selected>Select Training</option>
              <?php
              // Fetch available trainings from the database
              $trainingSql = "SELECT training_id, training_name FROM training_sessions";
              $trainingResult = $conn->query($trainingSql);
              if ($trainingResult->num_rows > 0) {
                  while ($trainingRow = $trainingResult->fetch_assoc()) {
                      echo "<option value='" . $trainingRow['training_id'] . "'>" . htmlspecialchars($trainingRow['training_name']) . " </option>";
                  }
              } else {
                  echo "<option value='' disabled>No trainings available</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="employee_id">Employee Name</label>
            <select class="form-control" id="employee_id" name="employee_id" required>
              <option value="" disabled selected>Select Employee</option>
              <?php
              // Fetch available employees from the database
              $employeeSql = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) AS employee_name FROM employees";
              $employeeResult = $conn->query($employeeSql);
              if ($employeeResult->num_rows > 0) {
                  while ($employeeRow = $employeeResult->fetch_assoc()) {
                      echo "<option value='" . $employeeRow['EmployeeID'] . "'>" . htmlspecialchars($employeeRow['employee_name']) . " </option>";
                  }
              } else {
                  echo "<option value='' disabled>No employees available</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="completion_date">Completion Date</label>
            <input type="date" class="form-control" id="completion_date" name="completion_date">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Assign Training</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Training Modal -->
<div class="modal fade" id="addTrainingModal" tabindex="-1" role="dialog" aria-labelledby="addTrainingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTrainingModalLabel">Add Training</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="onboarding/add_training.php">
                <div class="modal-body">
                    <!-- Training Title -->
                    <div class="form-group">
                        <label for="training_title">Training Title</label>
                        <input type="text" name="training_title" id="training_title" class="form-control" required>
                    </div>
                    <!-- Training Description -->
                    <div class="form-group">
                        <label for="training_description">Description</label>
                        <textarea name="training_description" id="training_description" class="form-control" rows="4" required></textarea>
                    </div>
                    <!-- Trainer -->
                    <div class="form-group">
                        <label for="trainer">Trainer</label>
                        <input type="text" name="trainer" id="trainer" class="form-control" required>
                    </div>
                    <!-- Department (Optional or Required based on your use case) -->
                    <div class="form-group">
                        <label for="department">Department</label>
                        <select name="department" id="department" class="form-control" required>
                            <option value="">Select Department</option>
                            <!-- You can fetch departments from your DB -->
                            <?php
                            // Assuming you have a departments table
                            $result = $conn->query("SELECT DepartmentID, DepartmentName FROM departments");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['DepartmentID']}'>{$row['DepartmentName']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Optional: Training Materials -->
                    <div class="form-group">
                        <label for="training_materials">Training Materials (Optional)</label>
                        <textarea name="training_materials" id="training_materials" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Training</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- Bootstrap JS -->


<script>
// Script to populate the modal fields with the employee data
$('#editEmployeeModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var EmployeeID = button.data('employeeid');
    var FirstName = button.data('firstname');
    var LastName = button.data('lastname');
    var Email = button.data('email');
    var Phone = button.data('phone');
    var Status = button.data('status');

    // Fill in the modal fields with the corresponding data
    var modal = $(this);
    modal.find('#editEmployeeID').val(EmployeeID);
    modal.find('#editFirstName').val(FirstName);
    modal.find('#editLastName').val(LastName);
    modal.find('#editEmail').val(Email);
    modal.find('#editPhone').val(Phone);
    modal.find('#editStatus').val(Status);
});
</script>

<ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="true">Users</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " id="training-sessions-tab" data-toggle="tab" href="#training-sessions" role="tab" aria-controls="training-sessions" aria-selected="false">Training Sessions</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="training-assignments-tab" data-toggle="tab" href="#training-assignments" role="tab" aria-controls="training-assignments" aria-selected="false">Training Assignments</a>
    </li>
    
</ul>

<div class="tab-content" id="dashboardTabContent">
    <!-- Training Sessions Tab -->
    <div class="tab-pane fade " id="training-sessions" role="tabpanel" aria-labelledby="training-sessions-tab">
    <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card">
    <div class="card-header d-flex justify-content-between">
        <h1 class="card-title">Training Sessions</h1>
        <div class="btn-group">
            <?php if ($userData && in_array("CREATE", $userData['permissions'])): ?>
                <button type="button" class="btn btn-outline-primary float-right"
                    data-toggle="modal" data-target="#addTrainingModal">Add Training</button>
            <?php else: ?>
                <button type="button" class="btn btn-outline-primary float-right"
                    data-toggle="modal" data-target="#addTrainingModal" disabled>Add Training</button>
            <?php endif; ?>
        </div>
    </div>
                                        <div class="card-body">
                                        <table id="myTable" class="table table-hover" style="width:100%">
    <thead class="thead-light">
        <tr>
            <th>Training</th>
            <th>Trainer</th> 
            <th>Department</th> 
            <th>Description</th> 
            <th>Materials</th> 
            <th>Actions</th> 
        </tr>
    </thead>
    <tbody>
        <?php
        // SQL query to fetch training sessions with department name
        $sql = "SELECT ts.training_id, ts.training_name, ts.training_description, ts.trainer, 
                d.DepartmentID AS department, d.DepartmentName AS department_name, 
                ts.training_materials, ts.created_at
                FROM training_sessions ts
                LEFT JOIN departments d ON ts.department = d.DepartmentID"; 

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['training_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['trainer']) . "</td>"; 
                echo "<td>" . htmlspecialchars($row['department_name']) . "</td>"; 
                echo "<td>" . htmlspecialchars($row['training_description']) . "</td>"; 
                echo "<td>" . htmlspecialchars($row['training_materials']) . "</td>"; 
                
                // Action Icons (Edit & Delete)
                echo "<td>
                        <a href='#' 
                            data-toggle='modal' 
                            data-target='#editTrainingModal' 
                            data-id='" . $row['training_id'] . "' 
                            data-training_name='" . htmlspecialchars($row['training_name']) . "' 
                            data-trainer='" . htmlspecialchars($row['trainer']) . "' 
                            data-department='" . htmlspecialchars($row['department']) . "' 
                            data-training_description='" . htmlspecialchars($row['training_description']) . "' 
                            data-training_materials='" . htmlspecialchars($row['training_materials']) . "' 
                            class='text-warning mx-2'>
                            <i class='fas fa-edit'></i> <!-- Edit Icon -->
                        </a>

                        <a href='onboarding/delete_training.php?id=" . htmlspecialchars($row['training_id']) . "' 
                            class='text-danger mx-2' 
                            onclick='return confirm(\"Are you sure you want to delete this training?\");'>
                            <i class='fas fa-trash'></i> <!-- Delete Icon -->
                        </a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center'>No training sessions found.</td></tr>"; 
        }
        ?>
    </tbody>
</table>

                                        </div>
    </div>
    </div>
                </div>
            </div>
    <!-- Training Assignments Tab -->
    <div class="tab-pane fade" id="training-assignments" role="tabpanel" aria-labelledby="training-assignments-tab">
    <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">    
    <div class="card">
        <div class="card-header d-flex justify-content-between">
                                            <h1 class="card-title">Training Assignments </h1>
                                            <div class="btn-group">
            <?php if ($userData && in_array("CREATE", $userData['permissions'])): ?>
                <button type="button" class="btn btn-outline-primary float-right"
                    data-toggle="modal" data-target="#assignTrainingModal">Assign</button>
            <?php else: ?>
                <button type="button" class="btn btn-outline-primary float-right"
                    data-toggle="modal" data-target="#assignTrainingModal" disabled>Assign</button>
            <?php endif; ?>
        </div>
                                        </div>
            <div class="card-body">
            <table id="myTable1" class="table table-hover" style="width:100%">
    <thead class="thead-light">
        <tr>
            <th>Employee</th>
            <th>Training</th>
            <th>Status</th>
            <th>Completion Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Query to fetch training assignment data from the database
        $sql = "SELECT ta.assignment_id, e.FirstName, e.LastName, tr.training_name, ta.status, ta.completion_date
                FROM training_assignments ta
                JOIN employees e ON ta.employee_id = e.EmployeeID
                JOIN training_sessions tr ON ta.training_id = tr.training_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['FirstName']) . " " . htmlspecialchars($row['LastName']) . "</td>"; // Employee Name
                echo "<td>" . htmlspecialchars($row['training_name']) . "</td>"; // Training Title
                echo "<td>" . htmlspecialchars($row['status']) . "</td>"; // Status
                $completion_date = $row['completion_date'] ? date('M d, Y', strtotime($row['completion_date'])) : 'N/A'; // Format: Nov 31, 2020
                echo "<td>" . htmlspecialchars($completion_date) . "</td>"; // Completion Date formatted
                
                // Action Buttons (Icons Only)
                echo "<td>
                        <a href='#' 
                            data-toggle='modal' 
                            data-target='#editAssignmentModal' 
                            data-id='" . $row['assignment_id'] . "' 
                            data-status='" . $row['status'] . "' 
                            class='text-warning mx-2'>
                            <i class='fas fa-edit'></i> <!-- Edit Icon -->
                        </a>

                        <a href='onboarding/delete_assignment.php?id=" . $row['assignment_id'] . "' 
                            class='text-danger mx-2' 
                            onclick='return confirm(\"Are you sure you want to delete this assignment?\");'>
                            <i class='fas fa-trash'></i> <!-- Delete Icon -->
                        </a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-center'>No training assignments found.</td></tr>"; // Adjusted colspan
        }
        ?>
    </tbody>
</table>

            </div>
        </div>
    </div>
          </div></div>      
    <!-- Users Tab -->
    <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
        <div class="card">
        <div class="card-header d-flex justify-content-between">
                                            <h1>Users </h1>
                                            <div class="btn-group">
    <?php if ($userData && in_array("CREATE", $userData['permissions'])): ?>
        <button type="button" class="btn btn-outline-primary float-right"
            data-toggle="modal" data-target="#createAccountModal">Add User</button>
    <?php else: ?>
        <button type="button" class="btn btn-outline-primary float-right"
            data-toggle="modal" data-target="#createAccountModal" disabled>Add User</button>
    <?php endif; ?>
</div>
                                        </div>
            <div class="card-body">
            <table id="myTable2" class="table table-hover" style="width:100%">
            <thead class="thead-light">
    <tr>
        <th>No.</th>
        <th>Username</th>
        <th>Usertype</th>
        <th>Name</th>
        <th>Onboarding Step</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php
    // Fetch users and their onboarding steps
    $sql = "SELECT u.id, u.username, u.usertype, a.applicant_name, u.onboarding_step 
            FROM users u
            LEFT JOIN applicants a ON u.applicant_id = a.id"; // Fetching onboarding_step from users table
    $result = $conn->query($sql);
    $counter = 1; // Start numbering from 1

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $counter . "</td>"; // Row number
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . htmlspecialchars($row['usertype']) . "</td>"; // User type (admin, employee, new hire)
            echo "<td>" . htmlspecialchars($row['applicant_name'] ?? 'N/A') . "</td>"; // Show applicant name or 'N/A'
            
            // Onboarding Step - Display "Completed" if step 4
            if (isset($row['onboarding_step'])) {
                if ($row['onboarding_step'] == 4) {
                    echo "<td>Completed</td>";
                } else {
                    echo "<td>Step " . htmlspecialchars($row['onboarding_step']) . "</td>";
                }
            } else {
                echo "<td>N/A</td>"; // If no onboarding step available
            }

            // Action Buttons (Icons Only)
            echo "<td>
                    <a href='#' 
                        data-toggle='modal' 
                        data-target='#editUserModal' 
                        data-id='" . $row['id'] . "' 
                        data-username='" . $row['username'] . "' 
                        data-usertype='" . $row['usertype'] . "' 
                        class='text-warning mx-2'>
                        <i class='fas fa-edit'></i> <!-- Edit Icon -->
                    </a>

                    <a href='onboarding/delete_user.php?id=" . $row['id'] . "' 
                        class='text-danger mx-2' 
                        onclick='return confirm(\"Are you sure you want to delete this user?\");'>
                        <i class='fas fa-trash'></i> <!-- Delete Icon -->
                    </a>
                </td>";
            echo "</tr>";
            $counter++; // Increment counter
        }
    } else {
        echo "<tr><td colspan='6' class='text-center'>No users found.</td></tr>"; // Adjusted colspan for 6 columns
    }
    ?>
</tbody>

</table>

            </div>
        </div>
    </div>
</div>


<hr><br>
<!-- Edit Training Modal -->
<div class="modal fade" id="editTrainingModal" tabindex="-1" role="dialog" aria-labelledby="editTrainingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTrainingModalLabel">Edit Training</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="onboarding/edit_training.php">
                <div class="modal-body">
                    <!-- Hidden Field for Training ID -->
                    <input type="hidden" name="training_id" id="edit_training_id">

                    <!-- Training Title -->
                    <div class="form-group">
                        <label for="edit_training_name">Training Title</label>
                        <input type="text" name="training_name" id="edit_training_name" class="form-control" required>
                    </div>

                    <!-- Trainer -->
                    <div class="form-group">
                        <label for="edit_trainer">Trainer</label>
                        <input type="text" name="trainer" id="edit_trainer" class="form-control" required>
                    </div>

                    <!-- Department -->
                    <div class="form-group">
                        <label for="edit_department">Department</label>
                        <select name="department" id="edit_department" class="form-control" required>
                            <option value="">Select Department</option>
                            <?php
                            // Fetch departments for the dropdown
                            $result = $conn->query("SELECT DepartmentID, DepartmentName FROM departments");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['DepartmentID']}'>{$row['DepartmentName']}</option>";
                            }
                            ?>
                        </select>

                    </div>

                    <!-- Training Description -->
                    <div class="form-group">
                        <label for="edit_training_description">Description</label>
                        <textarea name="training_description" id="edit_training_description" class="form-control" rows="4" required></textarea>
                    </div>

                    <!-- Training Materials -->
                    <div class="form-group">
                        <label for="edit_training_materials">Training Materials</label>
                        <textarea name="training_materials" id="edit_training_materials" class="form-control" rows="3"></textarea>
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
<!-- Include jQuery -->



<script>
$(document).ready(function () {
    $('#editTrainingModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var training_id = button.data('id');
        var training_name = button.data('training_name');
        var trainer = button.data('trainer');
        var department = button.data('department');  // This is now DepartmentID
        var training_description = button.data('training_description');
        var training_materials = button.data('training_materials');

        // Populate the modal fields with the data
        var modal = $(this);
        modal.find('#edit_training_id').val(training_id);
        modal.find('#edit_training_name').val(training_name);
        modal.find('#edit_trainer').val(trainer);
        
        // Set the correct department ID in the dropdown
        modal.find('#edit_department').val(department);  // Set the department by ID
        
        modal.find('#edit_training_description').val(training_description);
        modal.find('#edit_training_materials').val(training_materials);
    });
});

</script>


                <!-- The Modal -->
<div class="modal fade" id="createAccountModal" tabindex="-1" role="dialog" aria-labelledby="createAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAccountModalLabel">Create Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="onboarding/create_account.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="applicant_id">Select Applicant</label>
                        <select class="form-control" id="applicant_id" name="applicant_id" required>
                            <option value="">Select an Applicant</option>
                            <?php foreach ($hiredApplicants as $applicant): ?>
                                <?php 
                                    // Check if the applicant already has an account
                                    if (in_array($applicant['id'], $existingApplicants)) {
                                        continue; // Skip applicants who already have an account
                                    }
                                ?>
                                <option value="<?php echo $applicant['id']; ?>">
                                    <?php echo htmlspecialchars($applicant['applicant_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="usertype">User Type</label>
                        <select class="form-control" id="usertype" name="usertype" required>
                            <option value="">Select User Type</option>
                            <option value="New Hire">New Account</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Include Bootstrap JS and jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
        <!-- jQuery (Kailangan para gumana ang DataTables) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables CSS (Kung wala pa) -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "lengthMenu": [10, 25, 50, 100], 
            "paging": true,
            "searching": true,
            "ordering": true
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#myTable1').DataTable({
            "lengthMenu": [10, 25, 50, 100], 
            "paging": true,
            "searching": true,
            "ordering": true
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#myTable2').DataTable({
            "lengthMenu": [10, 25, 50, 100], 
            "paging": true,
            "searching": true,
            "ordering": true
        });
    });
</script>
</body>

</html>