<!-- training main dashboard -->
<?php
require "../../config/Database.php";
require '../../auth/accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);
//benefit deduction
try {
    $stmt = $conn->prepare("SELECT id, type, amount FROM deduction");
    $stmt->execute();
    $benefitData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}

// Fetch existing benefits from the database
try {
    $stmt = $conn->prepare("SELECT id, type, amount FROM deduction");
    $stmt->execute();
    $benefitData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}

// Handle form submission for adding a new benefit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addBenefit'])) {
    try {
        // Add new benefit
        $benefitType = $_POST['benefitType'];
        $amount = $_POST['amount'];

        $stmt = $conn->prepare("INSERT INTO deduction (type, amount) VALUES (:type, :amount)");
        $stmt->bindParam(':type', $benefitType, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<script>alert('Benefit added successfully!'); window.location.href = 'benefits.php';</script>";
        } else {
            echo "<script>alert('Error adding benefit');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}

// Handle form submission for editing a benefit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editBenefit'])) {
    try {
        // Edit benefit
        $benefitId = $_POST['benefitId'];
        $benefitType = $_POST['benefitType'];
        $amount = $_POST['amount'];

        $stmt = $conn->prepare("UPDATE deduction SET type = :type, amount = :amount WHERE id = :id");
        $stmt->bindParam(':id', $benefitId, PDO::PARAM_INT);
        $stmt->bindParam(':type', $benefitType, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<script>alert('Benefit updated successfully!'); window.location.href = 'benefits.php';</script>";
        } else {
            echo "<script>alert('Error updating benefit');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}

// Handle deletion
if (isset($_GET['deleteId'])) {
    try {
        $deleteId = $_GET['deleteId'];
        $stmt = $conn->prepare("DELETE FROM deduction WHERE id = :id");
        $stmt->bindParam(':id', $deleteId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Benefit deleted successfully!'); window.location.href = 'benefits.php';</script>";
        } else {
            echo "<script>alert('Error deleting benefit');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}


// Fetch existing incentives from the database
try {
    $stmt = $conn->prepare("SELECT id, type, amount FROM incentives");
    $stmt->execute();
    $incentiveData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}

// Handle form submission for adding a new incentive
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addIncentive'])) {
    try {
        // Add new incentive
        $incentiveType = $_POST['incentiveType'];
        $amount = $_POST['amount'];

        $stmt = $conn->prepare("INSERT INTO incentives (type, amount) VALUES (:type, :amount)");
        $stmt->bindParam(':type', $incentiveType, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<script>alert('Incentive added successfully!'); window.location.href = 'benefits.php';</script>";
        } else {
            echo "<script>alert('Error adding incentive');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}

// Handle form submission for editing an incentive
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editIncentive'])) {
    try {
        // Edit incentive
        $incentiveId = $_POST['incentiveId'];
        $incentiveType = $_POST['incentiveType'];
        $amount = $_POST['amount'];

        $stmt = $conn->prepare("UPDATE incentives SET type = :type, amount = :amount WHERE id = :id");
        $stmt->bindParam(':id', $incentiveId, PDO::PARAM_INT);
        $stmt->bindParam(':type', $incentiveType, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<script>alert('Incentive updated successfully!'); window.location.href = 'benefits.php';</script>";
        } else {
            echo "<script>alert('Error updating incentive');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}

// Handle deletion
if (isset($_GET['deleteId'])) {
    try {
        $deleteId = $_GET['deleteId'];
        $stmt = $conn->prepare("DELETE FROM incentives WHERE id = :id");
        $stmt->bindParam(':id', $deleteId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Incentive deleted successfully!'); window.location.href = 'benefits.php';</script>";
        } else {
            echo "<script>alert('Error deleting incentive');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/benefits.css">
    <script src="js/benefits.js"></script>



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
                                <h5 class="text-muted">Benefits</h5>



                                <!-- Table to Display Benefits -->
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th
                                                style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">
                                                Benefit Type</th>
                                            <th
                                                style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">
                                                Amount</th>
                                            <th
                                                style="background-color: #3d405c; color: white; padding: 15px; text-align: left; font-weight: bold;">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Check if we have any records
                                        if (!empty($benefitData)) {
                                            // Loop through the data and display each row
                                            foreach ($benefitData as $row) {
                                                echo "<tr>
                    <td>" . htmlspecialchars($row['type']) . "</td>
                    <td>" . htmlspecialchars($row['amount']) . "%" . "</td>
                    <td>
                        <button onclick='openSecondModal(" . $row['id'] . ", \"" . htmlspecialchars($row['type']) . "\", \"" . htmlspecialchars($row['amount']) . "\")' style='background-color: #ffc107; color: black; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; margin-right: 5px;'>Edit</button>
                        <a href='benefits.php?deleteId=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
                            <button style='background-color: #dc3545; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;'>Delete</button>
                        </a>
                    </td>
                </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='3'>No records found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                               

                                <!-- Button to open the first modal -->
                                <button onclick="openFirstModal()"
                                    class="btn btn-primary">
                                    Add New Benefit
                                </button>

                                <!-- Second Modal: Edit Benefit -->
                               

                                <!-- Script to open and close modals -->
                                <script>
                                    // Open and Close First Modal (Add Benefit)
                                    function openFirstModal() {
                                        document.getElementById('firstModal').style.display = 'flex';
                                    }

                                    function closeFirstModal() {
                                        document.getElementById('firstModal').style.display = 'none';
                                    }

                                    // Open and Close Second Modal (Edit Benefit)
                                    function openSecondModal(id, type, amount) {
                                        document.getElementById('editBenefitId').value = id;
                                        document.getElementById('editBenefitType').value = type;
                                        document.getElementById('editAmount').value = amount;
                                        document.getElementById('secondModal').style.display = 'flex';
                                    }

                                    function closeSecondModal() {
                                        document.getElementById('secondModal').style.display = 'none';
                                    }
                                </script>

                            </div>
                        </div>
                    </div>


                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted">Incentives</h5>

                                <!-- Table to Display Incentives -->
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="background-color: #3d405c; color: white; font-weight: bold;">
                                                Incentive Type</th>
                                            <th style="background-color: #3d405c; color: white;  font-weight: bold;">
                                                Amount</th>
                                            <th style="background-color: #3d405c; color: white;  font-weight: bold;">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($incentiveData)) {
                                            foreach ($incentiveData as $row) {
                                                echo "<tr>
                            <td>" . htmlspecialchars($row['type']) . "</td>
                            <td>" . htmlspecialchars($row['amount']) . "</td>
                            <td>
                                <button onclick='openEditModal(" . $row['id'] . ", \"" . htmlspecialchars($row['type']) . "\", \"" . htmlspecialchars($row['amount']) . "\")' style='background-color: #ffc107; color: black; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; margin-right: 5px;'>Edit</button>
                                <a href='benefits.php?deleteId=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
                                    <button style='background-color: #dc3545; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;'>Delete</button>
                                </a>

                            </td>
                        </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='3'>No records found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <!-- Add Incentive Modal -->
                                <div id="addIncentiveModal"
                                    style="display:none; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; justify-content: center; align-items: center;">
                                    <div
                                        style="background-color: white; padding: 20px; border-radius: 5px; max-width: 400px; width: 100%;">
                                        <h3>Add New Incentive</h3>
                                        <form method="POST" action="benefits.php">
                                            <label for="incentiveType">Incentive Type:</label>
                                            <input type="text" name="incentiveType" id="incentiveType" required><br><br>

                                            <label for="amount">Amount:</label>
                                            <input type="number" name="amount" id="amount" step="0.01" required><br><br>

                                            <button type="submit" name="addIncentive"
                                                style="background-color: #3d405c; color: white; padding: 10px 20px; border: none; cursor: pointer;">Add
                                                Incentive</button>
                                            <button type="button" onclick="closeAddModal()"
                                                style="background-color: #d9534f; color: white; padding: 10px 20px; border: none; cursor: pointer;">Cancel</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Edit Incentive Modal -->
                                <div id="editIncentiveModal"
                                    style="display:none; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; justify-content: center; align-items: center;">
                                    <div
                                        style="background-color: white; padding: 20px; border-radius: 5px; max-width: 400px; width: 100%;">
                                        <h3>Edit Incentive</h3>
                                        <form method="POST" action="benefits.php">
                                            <input type="hidden" name="incentiveId" id="editIncentiveId">
                                            <label for="editIncentiveType">Incentive Type:</label>
                                            <input type="text" name="incentiveType" id="editIncentiveType"
                                                required><br><br>

                                            <label for="editAmount">Amount:</label>
                                            <input type="number" name="amount" id="editAmount" step="0.01"
                                                required><br><br>

                                            <button type="submit" name="editIncentive"
                                                style="background-color: #3d405c; color: white; padding: 10px 20px; border: none; cursor: pointer;">Update
                                                Incentive</button>
                                            <button type="button" onclick="closeEditModal()"
                                                style="background-color: #d9534f; color: white; padding: 10px 20px; border: none; cursor: pointer;">Cancel</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Button to open Add Modal -->
                                <button onclick="openAddModal()" class="btn btn-primary">Add
                                    Incentive</button>

                                <script>
                                    // Open and Close Modals
                                    function openAddModal() {
                                        document.getElementById('addIncentiveModal').style.display = 'flex';
                                    }

                                    function closeAddModal() {
                                        document.getElementById('addIncentiveModal').style.display = 'none';
                                    }

                                    function openEditModal(id, type, amount) {
                                        document.getElementById('editIncentiveId').value = id;
                                        document.getElementById('editIncentiveType').value = type;
                                        document.getElementById('editAmount').value = amount;
                                        document.getElementById('editIncentiveModal').style.display = 'flex';
                                    }

                                    function closeEditModal() {
                                        document.getElementById('editIncentiveModal').style.display = 'none';
                                    }
                                </script>
                            </div>
                        </div>

                    </div>

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


 <!-- First Modal: Add Benefit -->
 <div id="firstModal"
                                    style="display:none; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; justify-content: center; align-items: center;">
                                    <div
                                        style="background-color: white; padding: 20px; border-radius: 5px; max-width: 400px; width: 100%;">
                                        <h3>Add New Benefit</h3>
                                        <form method="POST" action="benefits.php">
                                            <label for="benefitType">Benefit Type:</label>
                                            <input type="text" name="benefitType" id="benefitType" required><br><br>

                                            <label for="amount">Amount:</label>
                                            <input type="number" name="amount" id="amount" step="0.01" required><br><br>

                                            <button type="submit" name="addBenefit"
                                                style="background-color: #3d405c; color: white; padding: 10px 20px; border: none; cursor: pointer;">Add
                                                Benefit</button>
                                            <button type="button" onclick="closeFirstModal()"
                                                style="background-color: #d9534f; color: white; padding: 10px 20px; border: none; cursor: pointer;">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                                <div id="secondModal"
                                    style="display:none; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; justify-content: center; align-items: center;">
                                    <div
                                        style="background-color: white; padding: 20px; border-radius: 5px; max-width: 400px; width: 100%;">
                                        <h3>Edit Benefit</h3>
                                        <form method="POST" action="benefits.php">
                                            <input type="hidden" name="benefitId" id="editBenefitId">
                                            <label for="editBenefitType">Benefit Type:</label>
                                            <input type="text" name="benefitType" id="editBenefitType" required><br><br>

                                            <label for="editAmount">Amount:</label>
                                            <input type="number" name="amount" id="editAmount" step="0.01"
                                                required><br><br>

                                            <button type="submit" name="editBenefit"
                                                style="background-color: #3d405c; color: white; padding: 10px 20px; border: none; cursor: pointer;">Update
                                                Benefit</button>
                                            <button type="button" onclick="closeSecondModal()"
                                                style="background-color: #d9534f; color: white; padding: 10px 20px; border: none; cursor: pointer;">Cancel</button>
                                        </form>
                                    </div>
                                </div>

</body>

</html>