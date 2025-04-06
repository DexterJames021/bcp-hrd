<?php
session_start();
require "../../../../config/db_talent.php"; // Adjust the path as needed

$user_id = $_SESSION['user_id'];

// Kunin ang onboarding_step at applicant_id ng user
$query = "SELECT onboarding_step, applicant_id FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($onboarding_step, $applicant_id);
$stmt->fetch();
$stmt->close();

if (!$applicant_id) {
    die("Error: No applicant information found for this user.");
}

// Retrieve job title and department details using applicant_id
$query = "
    SELECT 
        jp.job_title, 
        d.DepartmentName 
    FROM 
        applicants a
    INNER JOIN 
        job_postings jp ON a.job_id = jp.id
    INNER JOIN 
        departments d ON a.DepartmentID = d.DepartmentID
    WHERE 
        a.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $applicant_id);
$stmt->execute();
$result = $stmt->get_result();
$applicant_info = $result->fetch_assoc();
$stmt->close();

$job_title = $applicant_info['job_title'] ?? 'Unknown';
$department_name = $applicant_info['DepartmentName'] ?? 'Unknown';

// Check if the employee record already exists
$check_employee_query = "SELECT COUNT(*) FROM employees WHERE UserID = ?";
$check_employee_stmt = $conn->prepare($check_employee_query);
$check_employee_stmt->bind_param("i", $user_id);
$check_employee_stmt->execute();
$check_employee_stmt->bind_result($employee_count);
$check_employee_stmt->fetch();
$check_employee_stmt->close();

$form_submitted = $employee_count > 0;

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Hired</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../../../../node_modules/datatables.net-dt/css/dataTables.dataTables.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../../../assets/libs/css/style.css">
    <link rel="stylesheet" href="../../../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../../../assets/vendor/fonts/circular-std/style.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

    <!-- jQuery (needed for Bootstrap and DataTables) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="../../../../node_modules/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="../../../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="../../../../node_modules/datatables.net/js/dataTables.min.js"></script>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <!-- Additional JS -->
    <script src="../../../../assets/libs/js/main-js.js"></script>
    <script src="../../../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script>
$(document).ready(function(){
    var onboardingStep = <?php echo $onboarding_step; ?>; 

    // I-disable lahat ng future steps
    $("#step2-tab, #step3-tab, #step4-tab").addClass("disabled").attr("onclick", "return false;");

    // Activate the correct step based on database
    if (onboardingStep >= 2) {
        $("#step1-tab").addClass("disabled").attr("onclick", "return false;");
        $("#step2-tab").removeClass("disabled");
    }
    if (onboardingStep >= 3) {
        $("#step2-tab").addClass("disabled").attr("onclick", "return false;");
        $("#step3-tab").removeClass("disabled");
    }
    if (onboardingStep >= 4) {
        $("#step3-tab").addClass("disabled").attr("onclick", "return false;");
        $("#step4-tab").removeClass("disabled");
    }

    // Show the correct step
    $("#step" + onboardingStep).addClass("show active");
    $("#step" + onboardingStep + "-tab").addClass("active");
});
</script>
</head>

<body>
<div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header ">
            <nav class="navbar navbar-expand-lg bg-white fixed-top  ">
                <a class="navbar-brand" href="index.php">
                    <img src="../assets/images/bcp-hrd-logo.jpg" alt="" class="" style="height: 3rem;width: auto;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search..">
                            </div>
                        </li>
                        <li class="nav-item dropdown notification">
                            <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span
                                    class="indicator"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                    <div class="notification-title"> Notification</div>
                                    <div class="notification-list">
                                        <div class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action active">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">Jeremy
                                                            Rakestraw</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">John Abraham </span>is
                                                        now following you
                                                        <div class="notification-date">2 days ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">Monaan Pechi</span> is
                                                        watching your main repository
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="#" alt=""
                                                            class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span
                                                            class="notification-list-user-name">Jessica
                                                            Caruso</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-footer"> <a href="#">View all notifications</a></div>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- <li class="nav-item dropdown connection">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-fw fa-th"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                                <li class="connection-list">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/github.png" alt="" > <span>Github</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/dribbble.png" alt="" > <span>Dribbble</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/dropbox.png" alt="" > <span>Dropbox</span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/bitbucket.png" alt=""> <span>Bitbucket</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/mail_chimp.png" alt="" ><span>Mail chimp</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/slack.png" alt="" > <span>Slack</span></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="conntection-footer"><a href="#">More</a></div>
                                </li>
                            </ul>
                        </li> -->
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="#" alt=""
                                    class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                                aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name"> <?= $_SESSION['username'] ?> </h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="../../../../auth/logout.php"><i
                                        class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="nav-left-sidebar sidebar-white ">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg cc">
                    <a class="d-xl-none d-lg-none" href="#"><?= strtoupper($_SESSION['usertype']) ?> PANEL</a>
                    <button class="navbar-toggler btn-light" type="button" data-toggle="collapse"
                        data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav  flex-column">
                            <li class="nav-divider">
                                <?= strtoupper($_SESSION['usertype']) ?> PANEL
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="index.php">
                                    <i class="fas fa-fw fa-home"></i> Dashboard
                                </a>
                            </li>
                            <!-- temp -->
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-1" aria-controls="submenu-1"><i
                                        class="fa fa-fw fa-user-circle"></i>employee <span
                                        class="badge badge-success">6</span></a>
                                <div id="submenu-1" class="collapse submenu bg-light">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                                data-target="#submenu-1-2" aria-controls="submenu-1-2">Lorem, ipsum.</a>
                                            <div id="submenu-1-2" class="collapse submenu bg-light">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="index.html">Lorem.</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">lorem1</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem.</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem.</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./records-management/Records.php">Lorem, ipsum
                                                dolor.</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="dashboard-sales.html">Lorem, ipsum dolor.</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                                data-target="#submenu-1-1" aria-controls="submenu-1-1">Lorem, ipsum
                                                dolor.</a>
                                            <div id="submenu-1-1" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem, ipsum dolor.</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem, ipsum dolor.</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Lorem, ipsum dolor.</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- facilities -->
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-2" aria-controls="submenu-2">
                                    <i class="fa fa-fw fa-user-circle"></i>Facilites and Resources
                                    <!-- <span class="badge badge-success">6</span> -->
                                </a>
                                <div id="submenu-2" class="collapse submenu bg-light">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="./tech/facilities/book_facility.php">Book
                                                Facility</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./tech/facilities/request_resources.php">Request
                                                Resources</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="./tech/facilities/survey.php">Survey</a>
                                        </li> -->
                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="dashboard-wrapper">
            <!-- <div class="dashboard-ecommerce"> -->
            <div class="container-fluid dashboard-content ">
                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="pageheader-title">Welcome, <?= $_SESSION["username"] ?>! You are assigned as a <br><?php echo $job_title; ?> in the <?php echo $department_name; ?></h2>
                            </div>
                            <div class="card-body">
                            <ul class="nav nav-tabs" id="onboardingTabs">
                                <li class="nav-item">
                                    <a class="nav-link" id="step1-tab" data-toggle="tab" href="#step1">Step 1: Personal Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2">Step 2: Change Password</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="step3-tab" data-toggle="tab" href="#step3">Step 3: Upload Documents</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="step4-tab" data-toggle="tab" href="#step4">Step 4: Agree to Policies</a>
                                </li>
                                
                            </ul><hr>
                            <div class="tab-content">
                            <div class="tab-pane fade" id="step1">
    <h3>Personal Information</h3>
    <form id="onboardingForm">
    <input type="hidden" name="UserID" value="<?= $_SESSION['user_id']; ?>">
    <input type="hidden" name="hire_date" value="<?= date('Y-m-d'); ?>"> <!-- Default to today's date -->
    <input type="hidden" name="salary" value="0"> <!-- Default salary value -->

    <div class="row">
        <div class="col-md-6">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" name="first_name" required>
        </div>
        <div class="col-md-6">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" name="last_name" required>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="col-md-6">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" name="phone" required>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" required>
        </div>
        <div class="col-md-6">
            <label for="dob">Date of Birth</label>
            <input type="date" class="form-control" name="dob" required>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Save & Proceed</button>
    </div>
</form>

</div>


<div class="tab-pane fade" id="step2">
    <h3>Change Password</h3>
    <form id="changePasswordForm" method="POST" action="change_password.php">
        <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <input type="password" class="form-control" id="currentPassword" name="current_password" required>
        </div>

        <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" class="form-control" id="newPassword" name="new_password" required minlength="6">
        </div>

        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>

<script>
document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
    let newPassword = document.getElementById('newPassword').value;
    let confirmPassword = document.getElementById('confirmPassword').value;

    if (newPassword !== confirmPassword) {
        event.preventDefault();
        alert("Passwords do not match. Please try again.");
    }
});
</script>
<?php if (isset($_GET['upload']) && $_GET['upload'] == 'success') : ?>
    <div id="upload-success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        Upload successful!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        setTimeout(function() {
            var alertBox = document.getElementById("upload-success-alert");
            if (alertBox) {
                alertBox.style.display = "none";
            }
        }, 5000); // 5 seconds
    </script>
<?php endif; ?>
<?php if (isset($_GET['delete']) && $_GET['delete'] == 'success') : ?>
    <div id="delete-success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        Document deleted successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        setTimeout(function() {
            var alertBox = document.getElementById("delete-success-alert");
            if (alertBox) {
                alertBox.style.display = "none";
            }
        }, 5000); // 5 seconds
    </script>
<?php endif; ?>


<div class="tab-pane fade" id="step3">
    <h3>Upload Documents</h3>
    <form id="step3Form" action="upload_documents.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <input type="file" class="form-control" name="documents[]" id="documents" multiple required>
    </div>

    <button type="submit" class="btn btn-primary">Upload</button>
    <button type="button" id="nextToStep4" class="btn btn-success">Next</button>
</form>


    <!-- Uploaded Documents Table -->
    <h4 class="mt-4">Uploaded Documents</h4>
    <table class="table table-bordered mt-3">
    <thead class="table-dark">
    <tr>
        <th>Document Name</th>
        <th>File Path</th>
        <th>Action</th>
    </tr>
</thead>


<tbody id="uploaded-documents">
    <?php
    require "../../../../config/db_talent.php"; // Adjust path as needed

    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID

    // Fetch uploaded documents
    $query = "SELECT id, document_name, file_path FROM documents WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['document_name']) . "</td>";
            echo "<td><a href='" . htmlspecialchars($row['file_path']) . "' target='_blank'>View File</a></td>";
            echo "<td>
                    <form method='POST' action='delete_document.php' onsubmit='return confirmDelete()'>
                        <input type='hidden' name='document_id' value='" . $row['id'] . "'>
                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3' class='text-center'>No uploaded documents found.</td></tr>";
    }

    $stmt->close();
    $conn->close();
    ?>
</tbody>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this document?");
    }
</script>


    </table>
</div>




<div class="tab-pane fade" id="step4">
    <h3>Agree to Policies</h3>
    <form id="policyAgreementForm" method="POST">
        <!-- Checkbox for agreement -->
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="agree" id="agree" required>
            <label class="form-check-label" for="agree">
                I agree to the <a href="policy_document.pdf" target="_blank">terms and conditions</a>.
            </label>
        </div>
        
        <!-- Finish Button -->
        <button type="submit" class="btn btn-success mt-3" id="finishBtn" disabled>Finish</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        // Enable the Finish button when the checkbox is checked
        $("#agree").change(function() {
            if ($(this).is(":checked")) {
                $("#finishBtn").prop("disabled", false);
            } else {
                $("#finishBtn").prop("disabled", true);
            }
        });

        // Handle form submission
        $("#policyAgreementForm").submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            $.ajax({
                url: "finalize_onboarding.php", // PHP script to finalize onboarding
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.trim() === "success") {
                        alert("You have successfully completed your onboarding! You are now an employee.");
                        // Redirect user or load the employee portal
                        window.location.href = "../../../../portal/index.php"; // Redirect to employee portal
                    } else {
                        alert("Error: " + response);
                    }
                }
            });
        });
    });
</script>

                                
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    // ❌ I-disable lahat ng steps maliban sa Step 1
    $("#step2-tab, #step3-tab, #step4-tab").addClass("disabled").attr("onclick", "return false;");

    // ✅ STEP 1 FORM: Save Personal Info
    $("#onboardingForm").submit(function(event){
        event.preventDefault(); // ❌ Wag mag-refresh ang page

        $.ajax({
            url: "save_form.php", // PHP script para sa Step 1
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.trim() === "success") {
                    alert("Step 1 completed! Proceeding to Step 2...");

                    // ❌ I-disable Step 1 tab
                    $("#step1-tab").addClass("disabled").attr("onclick", "return false;");
                    $("#step1").removeClass("show active");

                    // ✅ Activate si Step 2
                    $("#step2-tab").removeClass("disabled");
                    $("#step2").addClass("show active");
                    $("#step2-tab").trigger("click"); // Auto-click para lumipat
                } else {
                    alert("Error: " + response);
                }
            }
        });
    });

    // ✅ STEP 2 FORM: Change Password
    $("#changePasswordForm").submit(function(event){
        event.preventDefault();

        $.ajax({
            url: "change_password.php",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.trim() === "success") {
                    alert("Step 2 completed! Proceeding to Step 3...");

                    // ❌ I-disable Step 2
                    $("#step2-tab").addClass("disabled").attr("onclick", "return false;");
                    $("#step2").removeClass("show active");

                    // ✅ Activate si Step 3
                    $("#step3-tab").removeClass("disabled");
                    $("#step3").addClass("show active");
                    $("#step3-tab").trigger("click"); // Auto-click para lumipat
                } else {
                    alert("Error: " + response);
                }
            }
        });
    });

    // ✅ STEP 3 BUTTON: "Next" to Step 4
    $("#nextToStep4").click(function(){
        $.ajax({
            url: "update_onboarding_step.php", // PHP file to update step
            type: "POST",
            success: function(response) {
                if (response.trim() === "success") {
                    alert("Step 3 completed! Proceeding to Step 4...");

                    // ❌ Disable Step 3
                    $("#step3-tab").addClass("disabled").attr("onclick", "return false;");
                    $("#step3").removeClass("show active");

                    // ✅ Enable & Open Step 4
                    $("#step4-tab").removeClass("disabled");
                    $("#step4").addClass("show active");
                    $("#step4-tab").trigger("click");
                } else {
                    alert("Error updating onboarding step. Please try again.");
                }
            }
        });
    });
});
</script>




</body>
</html>
