<!-- training main dashboard -->
<?php
require "../../config/db_talent.php";

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
$sql = "SELECT COUNT(*) AS count FROM employees";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$employee_count = $row['count'];

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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styledash6.css">
    <link rel="stylesheet" href="../../assets/libs/css/style.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js (required for Bootstrap 4 for tooltips, popovers, modals, etc.) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

    <!-- Bootstrap JS (needed for Bootstrap components like modals, tooltips) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Bootstrap Bundle (includes Popper.js and Bootstrap JS) [Optional: Use this instead of both the previous JS scripts] -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> -->

    <!-- Custom JS -->
    <script defer type="module" src="../../assets/libs/js/global-script.js"></script>
    <script defer type="module" src="../../assets/libs/js/main-js.js"></script>

    <!-- Slimscroll JS (if needed) -->
    <script defer type="module" src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

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
                <div class="d-flex justify-content-start gap-3">
                <div class="box p-3 rounded shadow-sm text-center" style="width: 200px;">
                    <!-- Icon inside the box -->
                    <div class="icon-box">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center w-100 mb-2" data-toggle="modal" data-target="#createAccountModal">
                        <i class="fas fa-plus mr-2"></i> Account
                    </button>
                    <div class="count">
                    <strong><?php echo $user_count; ?></strong> Users
                    </div>
                </div>

                <div class="box p-3 rounded shadow-sm text-center" style="width: 200px;">
                    <!-- Icon inside the box -->
                    <div class="icon-box">
                        <i class="fas fa-users"></i>
                    </div>
                    <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center w-100 mb-2" data-toggle="modal" data-target="#viewEmployeesModal">
                        <i class="fas fa-eye mr-2"></i> Employees
                    </button>
                    <div class="count">
                        <strong><?php echo $employee_count; ?></strong> Employees
                    </div>
                </div>
                <!-- Add Training Button -->
                <div class="box p-3 rounded shadow-sm text-center" style="width: 200px;">
                    <!-- Icon inside the box -->
                    <div class="icon-box">
                    <i class="fas fa-graduation-cap"></i>

                    </div>
                    <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center w-100 mb-2" data-toggle="modal" data-target="#addTrainingModal">
                        <i class="fas fa-plus mr-2"></i> Add Training
                    </button>
                    <div class="count">
                        <strong><?php echo $trainingCount; ?></strong> Trainings
                    </div>
                </div>
                 <!-- Assign Training Box -->
                <div class="box p-3 rounded shadow-sm text-center" style="width: 200px;">
                    <div class="icon-box">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center w-100 mb-2" data-toggle="modal" data-target="#assignTrainingModal">
                        <i class="fas fa-plus mr-2"></i> Assign Training
                    </button>
                    <div class="count">
                        <!-- You can add a dynamic count here for the number of training assignments if needed -->
                        <strong><?php echo $assignment_count; ?></strong> Assignments
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

<h3>Employees</h3>
<div class="custom-table-container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="sticky-header">First Name</th>
                    <th class="sticky-header">Last Name</th>
                    <th class="sticky-header">Email</th>
                    <th class="sticky-header">Phone</th>
                    <th class="sticky-header">Status</th>
                    <th class="sticky-header">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to fetch employee data from the database
                $sql = "SELECT e.EmployeeID, e.FirstName, e.LastName, e.Email, e.Phone, e.Status 
                        FROM employees e";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                        
                        echo "<td>
                                <button class='btn btn-warning btn-sm btn-action' 
                                    data-toggle='modal' 
                                    data-target='#editEmployeeModal' 
                                    data-EmployeeID='" . $row['EmployeeID'] . "' 
                                    data-FirstName='" . htmlspecialchars($row['FirstName']) . "' 
                                    data-LastName='" . htmlspecialchars($row['LastName']) . "' 
                                    data-Email='" . htmlspecialchars($row['Email'])  . "' 
                                    data-Phone='" . htmlspecialchars($row['Phone']) . "' 
                                    data-Status='" . htmlspecialchars($row['Status']) . "'>Edit</button>
                                
                                <a href='onboarding/delete_employee.php?id=" . $row['EmployeeID'] . "' class='btn btn-danger btn-sm btn-action' onclick='return confirm(\"Are you sure you want to delete this employee?\");'>Delete</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No employees found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="onboarding/edit_employee.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editFirstName">First Name</label>
                        <input type="text" class="form-control" id="editFirstName" name="FirstName" required>
                    </div>
                    <div class="form-group">
                        <label for="editLastName">Last Name</label>
                        <input type="text" class="form-control" id="editLastName" name="LastName" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="editPhone">Phone</label>
                        <input type="text" class="form-control" id="editPhone" name="Phone" required>
                    </div>
                    <div class="form-group">
                        <label for="editStatus">Status</label>
                        <select class="form-control" id="editStatus" name="Status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Terminated">Terminated</option>
                        </select>
                    </div>
                    <input type="hidden" id="editEmployeeID" name="EmployeeID">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
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

<hr><br>
<h3>Training Sessions</h3>
<div class="custom-table-container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="sticky-header">Training Title</th>
                    <th class="sticky-header">Trainer</th> <!-- Added trainer column -->
                    <th class="sticky-header">Department</th> <!-- Added department column -->
                    <th class="sticky-header">Description</th> <!-- Added description column -->
                    <th class="sticky-header">Materials</th> <!-- Added materials column -->
                    <th class="sticky-header">Actions</th> <!-- Actions column -->
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
                        // Displaying the data in table rows
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['training_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['trainer']) . "</td>"; // Show trainer
                        echo "<td>" . htmlspecialchars($row['department_name']) . "</td>"; // Show department name instead of department ID
                        echo "<td>" . htmlspecialchars($row['training_description']) . "</td>"; // Show description
                        echo "<td>" . htmlspecialchars($row['training_materials']) . "</td>"; // Show materials
                        echo "<td>
                                <button class='btn btn-warning btn-sm btn-action' 
                                data-toggle='modal' 
                                data-target='#editTrainingModal' 
                                data-id='" . $row['training_id'] . "' 
                                data-training_name='" . htmlspecialchars($row['training_name']) . "' 
                                data-trainer='" . htmlspecialchars($row['trainer']) . "' 
                                data-department='" . htmlspecialchars($row['department']) . "' 
                                data-training_description='" . htmlspecialchars($row['training_description']) . "' 
                                data-training_materials='" . htmlspecialchars($row['training_materials']) . "'>Edit</button>
                                
                                <a href='onboarding/delete_training.php?id=" . htmlspecialchars($row['training_id']) . "' class='btn btn-danger btn-sm btn-action' onclick='return confirm(\"Are you sure you want to delete this training?\");'>Delete</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No training sessions found.</td></tr>"; // Adjusted colspan
                }
            ?>
            </tbody>
        </table>
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

<h3>Training Assignments</h3>
<div class="custom-table-container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="sticky-header">Employee Name</th>
                    <th class="sticky-header">Training Title</th>
                    <th class="sticky-header">Status</th>
                    <th class="sticky-header">Completion Date</th>
                    <th class="sticky-header">Actions</th>
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
                        echo "<td>
                                <button class='btn btn-warning btn-sm btn-action' 
                                        data-toggle='modal' 
                                        data-target='#editAssignmentModal' 
                                        data-id='" . $row['assignment_id'] . "' 
                                        data-status='" . $row['status'] . "'>Edit</button>
                                <a href='onboarding/delete_assignment.php?id=" . $row['assignment_id'] . "' class='btn btn-danger btn-sm btn-action' onclick='return confirm(\"Are you sure you want to delete this assignment?\");'>Delete</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No training assignments found.</td></tr>"; // Adjusted colspan for 5 columns
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<hr><br>

<h3>Users</h3>
                    <div class="custom-table-container">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="sticky-header">Username</th>
                                        <th class="sticky-header">User Type</th> <!-- Added user type column -->
                                        <th class="sticky-header">Applicant Name</th> <!-- Added applicant column -->
                                        <th class="sticky-header">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Assuming you have a query to fetch users from the database
                                    $sql = "SELECT u.id, u.username, u.usertype, a.applicant_name 
                                            FROM users u
                                            LEFT JOIN applicants a ON u.applicant_id = a.id";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['usertype']) . "</td>"; // Show user type (admin, employee, New Hire)
                                            echo "<td>" . htmlspecialchars($row['applicant_name'] ?? 'N/A') . "</td>"; // Show applicant name or 'N/A' if not linked
                                            echo "<td>
                                                    <button class='btn btn-warning btn-sm btn-action' 
                                                            data-toggle='modal' 
                                                            data-target='#editUserModal' 
                                                            data-id='" . $row['id'] . "' 
                                                            data-username='" . $row['username'] . "' 
                                                            data-usertype='" . $row['usertype'] . "'>Edit</button>
                                                    
                                                    <a href='onboarding/delete_user.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm btn-action' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
                                                </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No users found.</td></tr>"; // Adjusted colspan
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
<hr><br>



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
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                            <option value="staff">Staff</option>
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
     
</body>

</html>