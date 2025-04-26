<?php
session_start();
require('../../config/db_talent.php');

// Handle deletion
if (isset($_GET['delete'])) {
    $employeeID = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM employees WHERE EmployeeID = ?");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_employees.php");
    exit;
}

// Handle adding a new employee
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $hireDate = $_POST['hire_date'];
    $employeeType = $_POST['employee_type'];
    $salary = $_POST['salary'];
    $status = $_POST['status'];
    $userID = !empty($_POST['user_id']) ? $_POST['user_id'] : null;

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT Email FROM employees WHERE Email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        echo "<div id='employeeAddedMessage' class='alert alert-danger'>Email already exists!</div>";
    } else {
        // Auto-create user if user ID does not exist
        if (!empty($userID)) {
            $checkUser = $conn->prepare("SELECT id FROM users WHERE id = ?");
            $checkUser->bind_param("i", $userID);
            $checkUser->execute();
            $checkUser->store_result();

            if ($checkUser->num_rows == 0) {
                // Insert a dummy user with this ID
                $username = "user" . $userID;
                $password = password_hash("password", PASSWORD_DEFAULT); // default password
                $usertype = "employee";

                // Insert into users
                $insertUser = $conn->prepare("INSERT INTO users (id, username, password, usertype) VALUES (?, ?, ?, ?)");
                $insertUser->bind_param("isss", $userID, $username, $password, $usertype);
                if ($insertUser->execute()) {
                    echo "<div id='employeeAddedMessage' class='alert alert-success'>User account created for Employee.</div>";
                } else {
                    echo "<div id='employeeAddedMessage' class='alert alert-danger'>Failed to create user account.</div>";
                    exit;
                }
                $insertUser->close();
            }
            $checkUser->close();
        }

        // Add employee to the database
        $stmt = $conn->prepare("INSERT INTO employees (FirstName, LastName, Email, Phone, Address, DOB, HireDate, EmployeeType, Salary, Status, UserID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssdis", $firstName, $lastName, $email, $phone, $address, $dob, $hireDate, $employeeType, $salary, $status, $userID);

        if ($stmt->execute()) {
            echo "<div id='employeeAddedMessage' class='alert alert-success'>Employee added successfully!</div>";
        } else {
            echo "<div id='employeeAddedMessage' class='alert alert-danger'>Failed to add employee. Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }

    $checkEmail->close();
}

// Fetch all employees
$result = $conn->query("SELECT * FROM employees");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Employees</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
        .container {
            max-width: 100%;
        }
        table {
            width: 100%;
        }
        th, td {
            padding: 0.5in;
            word-wrap: break-word;
        }
        .card-body {
            padding: 0.5;
        }
        .card {
            border-radius: 0.5;
            border: none;
        }
        .back-to-dashboard {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
    <script>
        // Function to hide all alert messages after 3 seconds
        function hideMessages() {
            const messages = document.querySelectorAll('.alert');
            messages.forEach((message) => {
                setTimeout(function() {
                    message.style.display = 'none';
                }, 3000);
            });
        }

        window.onload = function() {
            hideMessages();  // Hide all messages after the page loads
        };
    </script>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Employee Management</h2>

    <!-- Back to Dashboard Button in the Upper Right -->
    <div class="back-to-dashboard">
        <a href="perf_dboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>

    <div class="row g-4">
        <!-- Add Employee Form -->
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Add New Employee</h5>
                </div>
                <div class="card-body">
                    <form method="post" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hire Date</label>
                            <input type="date" name="hire_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Employee Type</label>
                            <select name="employee_type" class="form-select" required>
                                <option disabled selected>Select Type</option>
                                <option value="Teaching">Teaching</option>
                                <option value="Non-teaching">Non-teaching</option>
                                <option value="Officer">Officer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Salary</label>
                            <input type="number" name="salary" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option disabled selected>Select Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">User ID (Optional)</label>
                            <input type="number" name="user_id" class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success w-100">Add Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Employee Table -->
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Employee List</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>DOB</th>
                                <th>Hire Date</th>
                                <th>Type</th>
                                <th>Salary</th>
                                <th>Status</th>
                                <th>User ID</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['FirstName']) ?></td>
                                <td><?= htmlspecialchars($row['LastName']) ?></td>
                                <td><?= htmlspecialchars($row['Email']) ?></td>
                                <td><?= htmlspecialchars($row['Phone']) ?></td>
                                <td><?= htmlspecialchars($row['Address']) ?></td>
                                <td><?= htmlspecialchars($row['DOB']) ?></td>
                                <td><?= htmlspecialchars($row['HireDate']) ?></td>
                                <td><?= htmlspecialchars($row['EmployeeType']) ?></td>
                                <td><?= htmlspecialchars($row['Salary']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $row['Status'] == 'Active' ? 'success' : 'secondary' ?>">
                                        <?= $row['Status'] ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($row['UserID']) ?></td>
                                <td>
                                    <a href="edit_employee.php?id=<?= $row['EmployeeID'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="?delete=<?= $row['EmployeeID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- /.col-lg-7 -->
    </div> <!-- /.row -->
</div>

</body>
</html>
