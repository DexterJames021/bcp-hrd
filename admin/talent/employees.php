<!-- training main dashboard -->
<?php
require "../../config/db_talent.php";
require '../../auth/mysqli_accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

// Assuming you have a connection to your database already set up
$sql = "SELECT COUNT(*) AS count FROM employees";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$employee_count = $row['count'];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Employees</title>
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

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body"> 
                                        <h1>Employee Profiles</h1>
                                        <div class="row">
                                    <div class="col-md-3">
                                        <div class="card bg-light text-white">
                                            <div class="card-body">
                                                <h5>Total Employees</h5>
                                                <h3><?php echo $employee_count; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            

<hr>
<div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                              
                                        <table id="RecordsTable" class="table table-hover" style="100%">
                                        <thead class="thead-light">
    <tr class="border-0">
        <th class="border-0">No.</th>
        <th class="border-0">First Name</th>
        <th class="border-0">Last Name</th>
        <th class="border-0">Job Position</th>
        <th class="border-0">Department</th>
        <th class="border-0">Status</th>
        <th class="border-0">Action</th>
    </tr>
</thead>

<tbody>
    <?php
    // Query to fetch employee data along with job position and department using joins
    $sql = "SELECT e.EmployeeID, e.FirstName, e.LastName, jp.job_title, d.DepartmentName, e.Status 
            FROM employees e
            JOIN users u ON e.UserID = u.id 
            JOIN applicants a ON u.applicant_id = a.id 
            JOIN job_postings jp ON a.job_id = jp.id  -- Job posting and applicant job link
            JOIN departments d ON a.DepartmentID = d.DepartmentID"; // Department and applicant department link
    
    $result = $conn->query($sql);

    $counter = 1; // Initialize counter for numbering

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $counter . "</td>"; // Display row number
            echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['job_title']) . "</td>"; // Display Job Position
            echo "<td>" . htmlspecialchars($row['DepartmentName']) . "</td>"; // Display Department Name
            echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
            echo "<td>
                    <button class='btn btn-info btn-sm btn-action' 
                        data-toggle='modal' 
                        data-target='#viewEmployeeModal' 
                        data-employeeid='" . htmlspecialchars($row['EmployeeID']) . "' 
                        data-firstname='" . htmlspecialchars($row['FirstName']) . "' 
                        data-lastname='" . htmlspecialchars($row['LastName']) . "' 
                        data-jobtitle='" . htmlspecialchars($row['job_title']) . "' 
                        data-department='" . htmlspecialchars($row['DepartmentName']) . "' 
                        data-status='" . htmlspecialchars($row['Status']) . "'>View Info</button>
                </td>";
            echo "</tr>";

            $counter++; // Increment counter
        }
    } else {
        echo "<tr><td colspan='7'>No employees found.</td></tr>";
    }
    ?>
</tbody>





                                        </table>
                                    
                                </div>
                            </div>
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

         <!-- jQuery (Kailangan para gumana ang DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables CSS (Kung wala pa) -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script>
    $(document).ready(function() {
        $('#RecordsTable').DataTable({
            "lengthMenu": [10, 25, 50, 100], 
            "paging": true,
            "searching": true,
            "ordering": true
        });
    });
</script>
</body>

</html>