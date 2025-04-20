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

// Fetch the count of succession candidates
$candidate_count = 0;
$sql = "SELECT COUNT(*) AS count FROM succession_candidates";
if ($result = $conn->query($sql)) {
    $row = $result->fetch_assoc();
    $candidate_count = $row['count'];
}
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
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Succession Planning</title>
    <link rel="shortcut icon" href="../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- Bootstrap CSS (latest version) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- ✅ Bootstrap CSS -->
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

    <!-- Bootstrap 5 (Optional, remove if you only need Bootstrap 4) -->
    <!-- Custom JS (Loaded last with defer to prevent blocking) -->
    <script defer src="../../assets/libs/js/global-script.js"></script>
    <script defer src="../../assets/libs/js/main-js.js"></script>
    <script defer src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
</head>




<body>
    <div class="dashboard-main-wrapper">
    <?php include '../sideandnavbar.php'; ?>
        <div class="dashboard-wrapper">
               
                <div class="container-fluid dashboard-content ">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body"> 
                                    <h1>Succession Planning</h1>
                                    <div class="row">
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
                                                    <h5>Total Candidates</h5>
                                                    <h3><?php echo $candidate_count; ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                    <hr>

<?php
// Check if an error message is set
if (isset($_SESSION['error_message'])) {
    echo '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $_SESSION['error_message'] . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <script>
        // Auto-dismiss the alert after 5 seconds
        setTimeout(function() {
            var alert = document.querySelector(".alert");
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000); // 5000 ms = 5 seconds
    </script>
    ';

    // Unset the message after displaying it to prevent it from showing again on page reload
    unset($_SESSION['error_message']);
}
?>

<?php
// Check if a success message is set
if (isset($_SESSION['success_message'])) {
    echo '
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        ' . $_SESSION['success_message'] . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <script>
        // Auto-dismiss the alert after 5 seconds
        setTimeout(function() {
            var alert = document.querySelector(".alert");
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000); // 5000 ms = 5 seconds
    </script>
    ';

    // Unset the message after displaying it to prevent it from showing again on page reload
    unset($_SESSION['success_message']);
}
?>




                    
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
            <form action="onboarding/assign_training.php" method="POST">
                <div class="modal-body">
                    <!-- Training Name Dropdown -->
                    <div class="form-group">
                        <label for="training_id">Training Name</label>
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

                    <!-- Employee Name Dropdown -->
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

                    <!-- Completion Date -->
                    <div class="form-group">
                        <label for="completion_date">Completion Date</label>
                        <input type="date" class="form-control" id="completion_date" name="completion_date" required>
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
        <a class="nav-link active" id="succession-candidates-tab" data-toggle="tab" href="#succession-candidates" role="tab" aria-controls="succession-candidates" aria-selected="false">Succession Candidates</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="training-sessions-tab" data-toggle="tab" href="#training-sessions" role="tab" aria-controls="training-sessions" aria-selected="true">Training Sessions</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="training-assignments-tab" data-toggle="tab" href="#training-assignments" role="tab" aria-controls="training-assignments" aria-selected="false">Training Assignments</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="training-applicants-tab" data-toggle="tab" href="#training-applicants" role="tab" aria-controls="training-applicants" aria-selected="false">Training Applicants</a>
    </li>
    
</ul>

                                        <div class="tab-content" id="dashboardTabContent">
                                            <!-- Training Sessions Tab -->
                                            <div class="tab-pane fade" id="training-sessions" role="tabpanel" aria-labelledby="training-sessions-tab">
                                            <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <h1 class="card-title">Training Sessions</h1>
                                                <div class="btn-group">
                                                
                                                        <button type="button" class="btn btn-outline-primary float-right"
                                                            data-toggle="modal" data-target="#addTrainingModal">Add Training</button>
                                                
                                                 
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
                        
                                                    <button type="button" class="btn btn-outline-primary float-right"
                                                        data-toggle="modal" data-target="#assignTrainingModal">Assign</button>
                                                
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
                                                <th>Rating 1-5</th>
                                            </tr>
                                        </thead>
                                        <tbody>
    <?php
    // Query to fetch training assignment data from the database, including grade if available
    $sql = "SELECT ta.assignment_id, e.FirstName, e.LastName, tr.training_name, ta.status, ta.completion_date, tg.grade
            FROM training_assignments ta
            JOIN employees e ON ta.employee_id = e.EmployeeID
            JOIN training_sessions tr ON ta.training_id = tr.training_id
            LEFT JOIN training_grades tg ON ta.assignment_id = tg.assignment_id"; // LEFT JOIN to get grade info
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
            echo "<td>";

            if ($row['status'] == 'Not Started') {
                // Show delete icon for "Not Started" status
                echo "<a href='onboarding/delete_assignment.php?id=" . $row['assignment_id'] . "' 
                        class='text-danger mx-2' 
                        onclick='return confirm(\"Are you sure you want to delete this assignment?\");'>
                        <i class='fas fa-trash'></i> <!-- Delete Icon -->
                      </a>";
            } elseif ($row['status'] == 'In Progress') {
                // Show complete button for "In Progress" status
                echo "<a href='#' 
                        class='text-success mx-2' 
                        onclick='completeWithGrade(" . $row['assignment_id'] . ")'>
                        <i class='fas fa-check'></i> <!-- Complete Icon -->
                    </a>";

                // Show delete icon for "In Progress" status
                echo "<a href='onboarding/delete_assignment.php?id=" . $row['assignment_id'] . "' 
                        class='text-danger mx-2' 
                        onclick='return confirm(\"Are you sure you want to delete this assignment?\");'>
                        <i class='fas fa-trash'></i> <!-- Delete Icon -->
                      </a>";
            } elseif ($row['status'] == 'Completed') {
                // Show the grade for "Completed" status
                if (isset($row['grade'])) {
                    echo "<span> " . htmlspecialchars($row['grade']) . " Stars</span>";
                } else {
                    echo "<span>No grade assigned</span>";
                }
            }
            
            echo "</td>";

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5' class='text-center'>No training assignments found.</td></tr>"; // Adjusted colspan
    }
    ?>
</tbody>





                                    </table>

<!-- Modal for Grade Input -->
<!-- Modal for grade input -->
<div class="modal fade" id="gradeModal" tabindex="-1" aria-labelledby="gradeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gradeModalLabel">Assign Grade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="grade">Select Rating:</label>
        <select id="grade" class="form-control">
          <option value="1">1 Star (Needs Improvement)</option>
          <option value="2">2 Stars (Developing)</option>
          <option value="3">3 Stars (Proficient)</option>
          <option value="4">4 Stars (Advanced)</option>
          <option value="5">5 Stars (Expert)</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveGradeBtn">Save Grade</button>
      </div>
    </div>
  </div>
</div>


<script>
function completeWithGrade(assignmentId) {
    // Store the assignmentId globally to use when the user saves the grade
    window.assignmentId = assignmentId;

    // Show the modal
    $('#gradeModal').modal('show');
}

// Handle the saving of the grade from the modal
$('#saveGradeBtn').on('click', function() {
    const grade = $('#grade').val(); // Get the selected grade

    if (grade) {
        // Redirect with assignment ID and selected grade
        window.location.href = `onboarding/complete_assignment.php?id=${window.assignmentId}&grade=${encodeURIComponent(grade)}`;
    } else {
        alert("Please select a grade.");
    }
});
</script>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                     
                                        <div class="tab-pane fade" id="training-applicants" role="tabpanel" aria-labelledby="training-applicants-tab">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h1 class="card-title">Training Applicants</h1>
                </div>
                <div class="card-body">
                    <table id="myTable2" class="table table-hover" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Applicant Name</th>
                                <th>Training</th>
                                <th>Applied Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
// Query to fetch training applicants data from the database
$sql = "SELECT 
            ta.application_id, 
            e.EmployeeID AS employee_id, 
            e.FirstName, 
            e.LastName, 
            tr.training_name, 
            ta.training_id, 
            ta.applied_at,
            tas.status AS assignment_status
        FROM training_applications ta
        JOIN employees e ON ta.employee_id = e.EmployeeID
        JOIN training_sessions tr ON ta.training_id = tr.training_id
        LEFT JOIN training_assignments tas 
            ON ta.employee_id = tas.employee_id 
            AND ta.training_id = tas.training_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['FirstName']) . " " . htmlspecialchars($row['LastName']) . "</td>"; // Applicant Name
        echo "<td>" . htmlspecialchars($row['training_name']) . "</td>"; // Training Title
        $applied_date = $row['applied_at'] ? date('M d, Y', strtotime($row['applied_at'])) : 'N/A'; // Format: Nov 31, 2020
        echo "<td>" . htmlspecialchars($applied_date) . "</td>"; // Applied Date formatted

        // Action Buttons
        echo "<td>";

        if (!empty($row['assignment_status'])) {
            // Kung may assignment na
            echo "<button class='btn btn-success mx-2' disabled>
                    Assigned (" . htmlspecialchars($row['assignment_status']) . ")
                  </button>";
        } else {
            // Kung hindi pa assigned
            echo "<a href='#' class='btn btn-outline-primary mx-2' 
                    data-toggle='modal' 
                    data-target='#assignTrainingModal' 
                    data-employee-id='" . $row['employee_id'] . "' 
                    data-employee-name='" . htmlspecialchars($row['FirstName']) . " " . htmlspecialchars($row['LastName']) . "' 
                    data-training-id='" . $row['training_id'] . "' 
                    data-training-name='" . htmlspecialchars($row['training_name']) . "'>
                    Assign Training
                  </a>";
        }

        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4' class='text-center'>No training applicants found.</td></tr>"; // Adjusted colspan
}
?>
</tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade show active" id="succession-candidates" role="tabpanel" aria-labelledby="succession-candidates-tab">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h1 class="card-title">Succession Candidates</h1>
                    <div class="btn-group">
                                                
                                                        <button type="button" class="btn btn-outline-primary float-right"
                                                            data-toggle="modal" data-target="#addCandidateModal">Add Candidates</button>
                                                
                                                 
                                                </div>
                
                </div>
                <div class="card-body">
                    <table id="myTableSuccession" class="table table-hover" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Employee Name</th>
                                <th>Target Position</th>
                                <th>Status</th>
                                <th>Assigned Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
// Query to fetch succession candidates data
$sql = "SELECT 
            sc.candidate_id, 
            e.EmployeeID AS employee_id, 
            e.FirstName, 
            e.LastName, 
            sc.target_position, 
            sc.status, 
            sc.assigned_at
        FROM succession_candidates sc
        JOIN employees e ON sc.employee_id = e.EmployeeID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['FirstName']) . " " . htmlspecialchars($row['LastName']) . "</td>"; // Employee Name
        echo "<td>" . htmlspecialchars($row['target_position']) . "</td>"; // Target Position
        echo "<td>" . htmlspecialchars($row['status']) . "</td>"; // Status
        $assigned_date = $row['assigned_at'] ? date('M d, Y', strtotime($row['assigned_at'])) : 'N/A';
        echo "<td>" . htmlspecialchars($assigned_date) . "</td>"; // Assigned Date

        // Action Buttons
        echo "<td>";

        // Example: Edit or Remove Candidate
        echo "<a href='#' 
        data-toggle='modal' 
        data-target='#updateCandidateModal' 
        data-candidate-id='" . $row['candidate_id'] . "'
        data-employee-name='" . htmlspecialchars($row['FirstName']) . " " . htmlspecialchars($row['LastName']) . "'
        data-target-position='" . htmlspecialchars($row['target_position']) . "'
        data-status='" . htmlspecialchars($row['status']) . "'
        class='text-warning mx-2'>
        <i class='fas fa-edit'></i> <!-- Edit Icon -->
      </a>";

echo "<a href='delete_candidate.php?id=" . $row['candidate_id'] . "' 
        class='text-danger mx-2' 
        onclick=\"return confirm('Are you sure you want to delete this candidate?');\">
        <i class='fas fa-trash'></i> <!-- Trash Icon -->
      </a>";

        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>No succession candidates found.</td></tr>";
}
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Update Candidate Modal -->
<div class="modal fade" id="updateCandidateModal" tabindex="-1" role="dialog" aria-labelledby="updateCandidateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="succession/update_candidate.php" method="POST"> <!-- Palitan mo yung action -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateCandidateModalLabel">Update Candidate</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- Hidden field for candidate_id -->
          <input type="hidden" name="candidate_id" id="updateCandidateId">

          <!-- Employee Name (readonly) -->
          <div class="form-group">
            <label for="updateEmployeeName">Employee Name</label>
            <input type="text" class="form-control" id="updateEmployeeName" name="employee_name" readonly>
          </div>

          <!-- Target Position -->
          <div class="form-group">
            <label for="updateTargetPosition">Target Position</label>
            <input type="text" class="form-control" id="updateTargetPosition" name="target_position" required>
          </div>

          <!-- Status -->
          <div class="form-group">
            <label for="updateStatus">Status</label>
            <select class="form-control" id="updateStatus" name="status" required>
              <option value="Ready for Promotion">Ready Now</option>
              <option value="Not Ready">Not Ready</option>
              <option value="In Development">Needs Development</option>
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
$(document).ready(function(){
    $('#updateCandidateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button na nag-trigger ng modal

        // Kunin yung data attributes
        var candidateId = button.data('candidate-id');
        var employeeName = button.data('employee-name');
        var targetPosition = button.data('target-position');
        var status = button.data('status');

        // Set mo yung values sa modal inputs
        var modal = $(this);
        modal.find('#updateCandidateId').val(candidateId);
        modal.find('#updateEmployeeName').val(employeeName);
        modal.find('#updateTargetPosition').val(targetPosition);
        modal.find('#updateStatus').val(status);
    });
});
</script>

<!-- Add Candidate Modal -->
<div class="modal fade" id="addCandidateModal" tabindex="-1" role="dialog" aria-labelledby="addCandidateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="succession/add_candidate.php" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCandidateModalLabel">Add Succession Candidate</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">

          <div class="form-group">
            <label for="employee">Select Employee</label>
            <select class="form-control" name="employee_id" id="employee" required>
              <option value="">-- Select Employee --</option>
              <?php
              $emp_query = "SELECT EmployeeID, FirstName, LastName FROM employees WHERE Status = 'Active'";
              $emp_result = $conn->query($emp_query);
              if ($emp_result->num_rows > 0) {
                  while ($emp = $emp_result->fetch_assoc()) {
                      echo "<option value='" . $emp['EmployeeID'] . "'>" . htmlspecialchars($emp['FirstName'] . ' ' . $emp['LastName']) . "</option>";
                  }
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="target_position">Target Position</label>
            <input type="text" class="form-control" id="target_position" name="target_position" required>
          </div>

          <div class="form-group">
            <label for="status">Candidate Status</label>
            <select class="form-control" id="status" name="status" required>
              <option value="">-- Select Status --</option>
              <option value="In Development">In Development</option>
              <option value="Ready for Promotion">Ready for Promotion</option>
            </select>
          </div>

        </div>

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add Candidate</button>
          
        </div>

      </div>
    </form>
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
$('#assignTrainingModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var employeeId = button.data('employee-id');
    var employeeName = button.data('employee-name');
    var trainingId = button.data('training-id');
    var trainingName = button.data('training-name');
    
    var modal = $(this);

    // If employee and training are passed (from Apply section), pre-fill them
    if (employeeId && trainingId) {
        modal.find('#employee_id').val(employeeId); // Set the employee ID in the dropdown
        modal.find('#training_id').val(trainingId); // Set the training ID in the dropdown
        modal.find('#completion_date').val(""); // Optionally, reset the completion date field
        modal.find('.modal-title').text('Assign Training to ' + employeeName); // Change the modal title
    } else {
        // If no employee or training is passed (general case), keep selections as empty/default
        modal.find('.modal-title').text('Assign Training'); // Default title
        modal.find('#employee_id').val(""); // Leave employee dropdown empty
        modal.find('#training_id').val(""); // Leave training dropdown empty
        modal.find('#completion_date').val(""); // Reset completion date field
    }
});

</script>

<script>
    $(document).ready(function() {
        if ($("#myTable tbody tr").length > 1) { // Ensure at least one row exists
            $('#myTable').DataTable({
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
        if ($("#myTable1 tbody tr").length > 1) { // Ensure at least one row exists
            $('#myTable1').DataTable({
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
        if ($("#myTable2 tbody tr").length > 1) { // Ensure at least one row exists
            $('#myTable2').DataTable({
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
        if ($("#myTableSuccession tbody tr").length > 1) { // Ensure at least one row exists
            $('#myTableSuccession').DataTable({
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