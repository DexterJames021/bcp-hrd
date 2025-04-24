<?php
// Database connection
require('../../config/db_talent.php');

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch employee data for the specified EmployeeID
if (isset($_GET['id'])) {
    $emp_id = $_GET['id'];
    $sql = "SELECT * FROM employees WHERE EmployeeID = $emp_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        echo "Employee not found.";
        exit;
    }
}

// Update employee details
if (isset($_POST['update_employee'])) {
    // Getting POST data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $hire_date = $_POST['hire_date'];
    $employee_type = $_POST['employee_type'];  // changed this to employee_type
    $job_role_id = $_POST['job_role_id'];
    $salary = $_POST['salary'];
    $manager_id = $_POST['manager_id'];
    $status = $_POST['status'];

    // Update query
    $sql = "UPDATE employees SET 
            FirstName = '$first_name', 
            LastName = '$last_name', 
            Email = '$email', 
            Phone = '$phone', 
            Address = '$address', 
            DOB = '$dob', 
            HireDate = '$hire_date', 
            EmployeeType = '$employee_type',  // changed this to EmployeeType
            JobRoleID = '$job_role_id', 
            Salary = '$salary', 
            ManagerID = '$manager_id', 
            Status = '$status' 
            WHERE EmployeeID = $emp_id";
    
    // Execute query and check for success
    if ($conn->query($sql) === TRUE) {
        echo "Employee updated successfully";
        header('Location: managedep.php'); // Redirect to employee listing page
        exit;
    } else {
        echo "Error updating employee: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        
        <h1 class="mt-5">Edit Employee</h1>

        <!-- Edit Employee Form -->
        <form method="POST" class="my-3">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $employee['FirstName']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $employee['LastName']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $employee['Email']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $employee['Phone']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $employee['Address']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $employee['DOB']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="hire_date" class="form-label">Hire Date</label>
                <input type="date" class="form-control" id="hire_date" name="hire_date" value="<?php echo $employee['HireDate']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="employee_type" class="form-label">Employee Type</label>
                <select class="form-control" id="employee_type" name="employee_type" required>
                    <option value="Teaching" <?php echo ($employee['EmployeeType'] == 'Teaching') ? 'selected' : ''; ?>>Teaching</option>
                    <option value="Non-Teaching" <?php echo ($employee['EmployeeType'] == 'Non-Teaching') ? 'selected' : ''; ?>>Non-Teaching</option>
                    <option value="Officer" <?php echo ($employee['EmployeeType'] == 'Officer') ? 'selected' : ''; ?>>Officer</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="job_role_id" class="form-label">Job Role ID</label>
                <input type="number" class="form-control" id="job_role_id" name="job_role_id" value="<?php echo $employee['JobRoleID']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input type="number" step="0.01" class="form-control" id="salary" name="salary" value="<?php echo $employee['Salary']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="manager_id" class="form-label">Manager ID</label>
                <input type="number" class="form-control" id="manager_id" name="manager_id" value="<?php echo $employee['ManagerID']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Active" <?php echo ($employee['Status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                    <option value="Inactive" <?php echo ($employee['Status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                    <option value="Terminated" <?php echo ($employee['Status'] == 'Terminated') ? 'selected' : ''; ?>>Terminated</option>
                </select>
            </div>

            <button type="submit" name="update_employee" class="btn btn-primary">Update Employee</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
