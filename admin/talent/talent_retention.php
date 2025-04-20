<?php
require "../../config/db_talent.php";
require '../../auth/mysqli_accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

$sql = "SELECT COUNT(*) AS total_retained
            FROM employees
            WHERE TIMESTAMPDIFF(YEAR, HireDate, CURDATE()) >= 1";
    
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_retained = $row['total_retained'];

    $sql = "SELECT COUNT(*) AS total_programs FROM retention_programs";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_programs = $row['total_programs'];

    $sql = "SELECT COUNT(*) AS total_awards FROM employee_awards";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_awards = $row['total_awards'];

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
                                        <h1>Talent Retention</h1>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card bg-light text-white">
                                                    <div class="card-body">
                                                        <h5>Employee Retained</h5>
                                                        <h3><?php echo $total_retained; ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card bg-light text-white">
                                                    <div class="card-body">
                                                        <h5>Achievement Programs</h5>
                                                        <h3><?php echo $total_programs; ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card bg-light text-white">
                                                    <div class="card-body">
                                                        <h5>Total Award</h5>
                                                        <h3><?php echo $total_awards; ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    <hr>
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
                                    <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="employee-retained-tab" data-toggle="tab" href="#employee-retained" role="tab" aria-controls="employee-retained" aria-selected="false">Employee Retained</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="retention-programs-tab" data-toggle="tab" href="#retention-programs" role="tab" aria-controls="retention-programs" aria-selected="true">Retention Programs</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="employee-awards-tab" data-toggle="tab" href="#employee-awards" role="tab" aria-controls="employee-awards" aria-selected="false">Employee Award</a>
                                        </li>
                                        
                                        
                                    </ul>
                                    <div class="tab-content" id="dashboardTabsContent">
                                        <div class="tab-pane fade show active" id="employee-retained" role="tabpanel" aria-labelledby="employee-retained-tab">
                                            <!-- Content for Employee Retained goes here -->
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between">
                                                    <h1 class="card-title">Employee Retained</h1>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-hover" id="myEmployeeRetained" style="100%">
                                                        <thead class="thead-light">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Employee Name</th>
                                                            <th>Job Title</th>
                                                            <th>Department</th>
                                                            <th>Status</th>
                                                            <th>Years of Service</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $sql = "SELECT 
                                                                            e.EmployeeID,
                                                                            e.FirstName,
                                                                            e.LastName,
                                                                            e.HireDate,
                                                                            e.Status,
                                                                            jp.job_title,
                                                                            d.DepartmentName
                                                                        FROM 
                                                                            employees e
                                                                        INNER JOIN users u ON e.UserID = u.id
                                                                        INNER JOIN applicants a ON u.applicant_id = a.id
                                                                        INNER JOIN job_postings jp ON a.job_id = jp.id
                                                                        INNER JOIN departments d ON a.DepartmentID = d.DepartmentID
                                                                        WHERE 
                                                                            TIMESTAMPDIFF(YEAR, e.HireDate, CURDATE()) >= 1"; 
                                                                $result = mysqli_query($conn, $sql);

                                                                $no = 1;
                                                                while($row = mysqli_fetch_assoc($result)) {
                                                                    $employeeName = htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']);
                                                                    $hireDate = new DateTime($row['HireDate']);
                                                                    $today = new DateTime();
                                                                    $diff = $today->diff($hireDate);
                                                                    
                                                                    // Calculate the years and months
                                                                    $years_of_service = $diff->y . " year(s)";
                                                                    if ($diff->m > 0) {
                                                                        $years_of_service .= " and " . $diff->m . " month(s)";
                                                                    }

                                                                    echo "<tr>";
                                                                    echo "<td>" . $no++ . "</td>";
                                                                    echo "<td>" . $employeeName . "</td>";
                                                                    echo "<td>" . htmlspecialchars($row['job_title']) . "</td>";
                                                                    echo "<td>" . htmlspecialchars($row['DepartmentName']) . "</td>";
                                                                    echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                                                                    echo "<td>" . $years_of_service . "</td>";
                                                                    echo "</tr>";
                                                                }
                                                            ?>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
<!-- Modal for Add Program -->
<div class="modal fade" id="addPrograms" tabindex="-1" role="dialog" aria-labelledby="addProgramsLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
 
    <form method="POST" action="talentretention/add_programs.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProgramsLabel">Add New Program</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Program Name</label>
            <input type="text" class="form-control" name="program_name" required>
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="description" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label>Frequency</label>
            <select class="form-control" name="frequency" required>
              <option value="Monthly">Monthly</option>
              <option value="Yearly">Yearly</option>
              <option value="Ongoing">Ongoing</option>
            </select>
          </div>

          <div class="form-group">
            <label>Start Date</label>
            <input type="date" class="form-control" name="start_date" required>
          </div>

          <div class="form-group">
            <label>End Date (Optional)</label>
            <input type="date" class="form-control" name="end_date">
          </div>

          <div class="form-group">
            <label>Eligibility (Optional)</label>
            <input type="text" class="form-control" name="eligibility">
          </div>

          <div class="form-group">
            <label>Reward (Optional)</label>
            <input type="text" class="form-control" name="reward">
          </div>

          <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="status" required>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Program</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Edit Program Modal -->
<div class="modal fade" id="editProgramModal" tabindex="-1" role="dialog" aria-labelledby="editProgramModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProgramModalLabel">Edit Retention Program</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editProgramForm" action="talentretention/edit_programs.php" method="POST">
          <input type="hidden" id="program_id" name="program_id">
          <div class="form-group">
            <label for="program_name">Program Name</label>
            <input type="text" class="form-control" id="program_name" name="program_name" required>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
          </div>
          <div class="form-group">
            <label for="frequency">Frequency</label>
            <input type="text" class="form-control" id="frequency" name="frequency" required>
          </div>
          <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
          </div>
          <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date">
          </div>
          <div class="form-group">
            <label for="eligibility">Eligibility</label>
            <input type="text" class="form-control" id="eligibility" name="eligibility">
          </div>
          <div class="form-group">
            <label for="reward">Reward</label>
            <input type="text" class="form-control" id="reward" name="reward">
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
          <button type="submit" name="update_program" class="btn btn-primary">Update Program</button>
        </form>
      </div>
    </div>
  </div>
</div>

                                        <div class="tab-pane fade" id="retention-programs" role="tabpanel" aria-labelledby="retention-programs-tab">
                                            <!-- Content for Retention Programs goes here -->
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between">
                                                    <h1 class="card-title">Employee Achievement Programs</h1>
                                                    <div class="btn-group">
                                                
                                                        <button type="button" class="btn btn-outline-primary float-right"
                                                            data-toggle="modal" data-target="#addPrograms">
                                                            Add Programs
                                                        </button>
                                                
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-hover" id="myPrograms" style="100%">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Program Name</th>
                                                            <th>Description</th>
                                                            <th>Frequency</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Eligibility</th>
                                                            <th>Reward</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
    <?php
    $sql = "SELECT * FROM retention_programs ORDER BY start_date ASC";
    $result = mysqli_query($conn, $sql);
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $eligibility = !empty($row['eligibility']) ? htmlspecialchars($row['eligibility']) : 'N/A';
        $reward = !empty($row['reward']) ? htmlspecialchars($row['reward']) : 'N/A';

        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . htmlspecialchars($row['program_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
        echo "<td>" . htmlspecialchars($row['frequency']) . "</td>";
        echo "<td>" . htmlspecialchars($row['start_date']) . "</td>";
        echo "<td>" . (!empty($row['end_date']) ? htmlspecialchars($row['end_date']) : 'N/A') . "</td>";
        echo "<td>" . $eligibility . "</td>";
        echo "<td>" . $reward . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td>
            <button class='btn btn-sm btn-warning edit-btn' data-id='" . $row['id'] . "' 
        data-name='" . htmlspecialchars($row['program_name']) . "'
        data-description='" . htmlspecialchars($row['description']) . "'
        data-frequency='" . htmlspecialchars($row['frequency']) . "'
        data-start_date='" . htmlspecialchars($row['start_date']) . "'
        data-end_date='" . htmlspecialchars($row['end_date']) . "'
        data-eligibility='" . $eligibility . "'
        data-reward='" . $reward . "'
        data-status='" . htmlspecialchars($row['status']) . "'
        style='border: none; background: transparent;'>
        <i class='fas fa-edit' style='font-size: 16px; color: #ffc107;'></i>
    </button>
            <button class='btn btn-sm btn-danger delete-btn' 
                data-id='" . $row['id'] . "' 
                style='border: none; background: transparent; display: inline-block;'>
                <i class='fas fa-trash-alt' style='font-size: 16px; color: #dc3545;'></i>
            </button>
        </td>";
        echo "</tr>";
    }
    ?>
</tbody>



                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteProgramModal" tabindex="-1" aria-labelledby="deleteProgramModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="deleteProgramForm" method="POST" action="talentretention/delete_program.php">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteProgramModalLabel">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this program?
          <input type="hidden" name="program_id" id="delete_program_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Pag click ng delete button
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function () {
        var programId = this.getAttribute('data-id');
        document.getElementById('delete_program_id').value = programId;
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteProgramModal'));
        deleteModal.show();
    });
});
</script>

<script>
    // JavaScript to populate the modal form when "Edit" button is clicked
document.addEventListener('DOMContentLoaded', function () {
  // Edit button click event
  document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function () {
      const programId = this.getAttribute('data-id');
      const programName = this.getAttribute('data-name');
      const description = this.getAttribute('data-description');
      const frequency = this.getAttribute('data-frequency');
      const startDate = this.getAttribute('data-start_date');
      const endDate = this.getAttribute('data-end_date');
      const eligibility = this.getAttribute('data-eligibility');
      const reward = this.getAttribute('data-reward');
      const status = this.getAttribute('data-status');

      // Populate the modal form with the existing values
      document.getElementById('program_id').value = programId;
      document.getElementById('program_name').value = programName;
      document.getElementById('description').value = description;
      document.getElementById('frequency').value = frequency;
      document.getElementById('start_date').value = startDate;
      document.getElementById('end_date').value = endDate;
      document.getElementById('eligibility').value = eligibility;
      document.getElementById('reward').value = reward;
      document.getElementById('status').value = status;

      // Show the modal
      $('#editProgramModal').modal('show');
    });
  });
});

</script>
                                        <div class="tab-pane fade" id="employee-awards" role="tabpanel" aria-labelledby="employee-awards-tab">
                                            <!-- Content for Employee Awards goes here -->
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between">
                                                    <h1 class="card-title">Recognized Employees</h1>
                                                    <div class="btn-group">
                                                
                                                        <button type="button" class="btn btn-outline-primary float-right"
                                                            data-toggle="modal" data-target="#assignAward">
                                                            Assign Award
                                                        </button>
                                                
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                <table class="table table-hover" id="myAward">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Employee Name</th>
                                                            <th>Award Name (Program)</th>
                                                            <th>Description</th>
                                                            <th>Award Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
<?php
// Fetch assigned awards
$sql = "SELECT ea.*, e.FirstName, e.LastName, rp.program_name
        FROM employee_awards ea
        JOIN employees e ON ea.employee_id = e.EmployeeID
        JOIN retention_programs rp ON ea.program_id = rp.id
        ORDER BY ea.award_date DESC";

$result = mysqli_query($conn, $sql);
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $employee_name = $row['FirstName'] . ' ' . $row['LastName'];
    $award_name = htmlspecialchars($row['program_name']);  // Award name is the program_name
    $description = htmlspecialchars($row['description']);
    $award_date_raw = $row['award_date'];
    $award_date = date('F d Y', strtotime($award_date_raw)); // Format date to "Month Day Year"
    $status = htmlspecialchars($row['status']);
    $award_id = $row['id']; // Get the award ID for the action links

    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . $employee_name . "</td>";
    echo "<td>" . $award_name . "</td>";  // Display the program name as the award name
    echo "<td>" . $description . "</td>";
    echo "<td>" . $award_date . "</td>"; // Formatted date
    echo "<td>" . $status . "</td>";
    
    // Action column
    if ($status != 'Awarded') {
        // Show the check icon if the status is not "Awarded"
        echo "<td>
            <a href='talentretention/update_award_status.php?award_id=$award_id&status=Awarded' class='btn btn-sm btn-success' style='border: none; background: transparent;'>
                <i class='fas fa-check' style='font-size: 16px; color: #28a745;'></i>
            </a>
        </td>";
    } else {
        // Display a badge if already awarded
        echo "<td>
            <span class='badge badge-success'>Awarded</span>
        </td>";
    }
    
    echo "</tr>";
}
?>
</tbody>



                                                </table>


                                                </div>
                                            </div>
                                        </div>
                                 <!-- Assign Award Modal -->
<div class="modal fade" id="assignAward" tabindex="-1" role="dialog" aria-labelledby="assignAwardLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignAwardLabel">Assign Award to Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="talentretention/assign_award.php">
                    <!-- Select Employee -->
                    <div class="form-group">
                        <label for="employee_id">Select Employee</label>
                        <select class="form-control" id="employee_id" name="employee_id" required>
                            <option value="">Select an Employee</option>
                            <?php
                            // Fetch employees for selection
                            $emp_sql = "SELECT EmployeeID, FirstName, LastName FROM employees";
                            $emp_result = mysqli_query($conn, $emp_sql);
                            while ($emp_row = mysqli_fetch_assoc($emp_result)) {
                                echo "<option value='" . $emp_row['EmployeeID'] . "'>" . $emp_row['FirstName'] . " " . $emp_row['LastName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Select Retention Program -->
                    <div class="form-group">
                        <label for="program_id">Select Achievement Program</label>
                        <select class="form-control" id="program_id" name="program_id" required>
                            <option value="">Select a Program</option>
                            <?php
                            // Fetch retention programs for selection
                            $program_sql = "SELECT id, program_name FROM retention_programs";
                            $program_result = mysqli_query($conn, $program_sql);
                            while ($program_row = mysqli_fetch_assoc($program_result)) {
                                echo "<option value='" . $program_row['id'] . "'>" . $program_row['program_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Award Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <!-- Award Date -->
                    <div class="form-group">
                        <label for="award_date">Award Date</label>
                        <input type="date" class="form-control" id="award_date" name="award_date" required>
                    </div>

                    <!-- Award Status -->
                    <div class="form-group">
                        <label for="status">Award Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Pending">Pending</option>
                            <option value="Awarded">Awarded</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" name="assign_award">Assign Award</button>
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
                             
                </div>
        </div>
</div>
<script>
    $(document).ready(function(){
        $('.toast').toast('show');
    });
</script>

<script>
    $(document).ready(function() {
        if ($("#myEmployeeRetained tbody tr").length > 1) { // Ensure at least one row exists
            $('#myEmployeeRetained').DataTable({
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
        if ($("#myPrograms tbody tr").length > 1) { // Ensure at least one row exists
            $('#myPrograms').DataTable({
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
        if ($("#myAward tbody tr").length > 1) { // Ensure at least one row exists
            $('#myAward').DataTable({
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