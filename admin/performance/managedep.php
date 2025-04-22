<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bcp-hrd"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete Employee Logic
if (isset($_GET['delete'])) {
    $emp_id = (int) $_GET['delete']; // Sanitize the delete ID

    // SQL to delete the employee
    $sql = "DELETE FROM employees WHERE EmployeeID = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $emp_id); // Bind the parameter
        if ($stmt->execute()) {
            header('Location: managedep.php'); // Redirect after successful deletion
            exit;
        } else {
            echo "Error deleting employee: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing SQL: " . $conn->error;
    }
}

// Handling form submission to add new employee
if (isset($_POST['add_employee'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $hire_date = mysqli_real_escape_string($conn, $_POST['hire_date']);
    $employee_type = mysqli_real_escape_string($conn, $_POST['employee_type']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $policy_agreed = isset($_POST['policy_agreed']) ? 1 : 0;

    $sql = "INSERT INTO employees (FirstName, LastName, Email, Phone, Address, DOB, HireDate, EmployeeType, Salary, Status, UserID, PolicyAgreed) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssdsiis", $first_name, $last_name, $email, $phone, $address, $dob, $hire_date, $employee_type, $salary, $status, $user_id, $policy_agreed);
        if ($stmt->execute()) {
            echo "New employee added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing SQL: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link rel="stylesheet" href="style.css">

    <style>
/* Container for the form */
.form-container {
    max-width: 400px;
    margin: 0 auto;
    float:left;
    padding: 16px;
    background-color: #f9f9f9;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Label styling */
.form-label {
    font-size: 16px;
    font-weight: 400;
    color: #333;
    margin-bottom: 8px;
}

/* Input and Select styling */
.form-control {
    padding: 12px 16px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 3px;
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 16px;
}

/* Focus effect for input fields */
.form-control:focus {
    outline: none;
    border-color: #5c6bc0;
    box-shadow: 0 0 5px rgba(92, 107, 192, 0.6);
}

/* Submit button styling */
.btn-primary {
    padding: 12px 30px;
    font-size: 16px;
    background-color: #5c6bc0;
    border: none;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

/* Button hover effect */
.btn-primary:hover {
    background-color: #3f51b5;
}

/* Styling the entire form's spacing */
.mb-3 {
    margin-bottom: 20px;
}

/* Optional: Styling for the form section container */
.form-section {
    padding: 20px;
    margin-bottom: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

/* Optional: Border for the form section */
.form-section-border {
    border: 1px solid #ddd;
}

/* Status select styling */
.form-control select {
    padding: 12px 16px;
    font-size: 16px;
    border-radius: 5px;
    width: 100%;
    background-color: #ffffff;
    border: 1px solid #ddd;
}

/* Hover effect for select */
.form-control select:hover {
    background-color: #f1f1f1;
}

/* Placeholder Styling */
::placeholder {
    color: #aaa;
    font-style: italic;
}


/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

/* Table Header */
th {
    background-color: #5c6bc0;
    color: #ffffff;
    font-weight: bold;
    padding: 12px;
    text-transform: uppercase;
}

/* Table Body */
td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
}

/* Alternate Row Color */
tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Hover Effect on Rows */
tr:hover {
    background-color: #f1f1f1;
}

/* Table Action Buttons */
.btn {
    padding: 6px 12px;
    border-radius: 5px;
    font-size: 14px;
    text-decoration: none;
    margin: 0 5px;
}

.btn-warning {
    background-color: #ff9800;
    color: #ffffff;
}

.btn-danger {
    background-color: #e57373;
    color: #ffffff;
}

.btn-warning:hover {
    background-color: #f57c00;
}

.btn-danger:hover {
    background-color: #d32f2f;
}

/* Table Pagination */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination a {
    color: #5c6bc0;
    padding: 8px 16px;
    text-decoration: none;
    margin: 0 5px;
    border-radius: 5px;
}

.pagination a:hover {
    background-color: #5c6bc0;
    color: white;
}

.pagination .active {
    background-color: #5c6bc0;
    color: white;
}
/* Container for both the form and the table */
.container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-top: 20px;
}

/* Form container */
.form-container {
    max-width: 400px;
    padding: 16px;
    background-color: #f9f9f9;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Table container */
.table-container {
    width: 65%; /* Adjust the width of the table */
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

/* Table Header */
th {
    background-color: #5c6bc0;
    color: #ffffff;
    font-weight: bold;
    padding: 12px;
    text-transform: uppercase;
}

/* Table Body */
td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
}

/* Alternate Row Color */
tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Hover Effect on Rows */
tr:hover {
    background-color: #f1f1f1;
}

/* Table Action Buttons */
.btn {
    padding: 6px 12px;
    border-radius: 5px;
    font-size: 14px;
    text-decoration: none;
    margin: 0 5px;
}

.btn-warning {
    background-color: #ff9800;
    color: #ffffff;
}

.btn-danger {
    background-color: #e57373;
    color: #ffffff;
}

.btn-warning:hover {
    background-color: #f57c00;
}

.btn-danger:hover {
    background-color: #d32f2f;
}

/* Table Pagination */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination a {
    color: #5c6bc0;
    padding: 8px 16px;
    text-decoration: none;
    margin: 0 5px;
    border-radius: 5px;
}

.pagination a:hover {
    background-color: #5c6bc0;
    color: white;
}

.pagination .active {
    background-color: #5c6bc0;
    color: white;
}

/* Form Label Styling */
.form-label {
    font-size: 16px;
    font-weight: 400;
    color: #333;
    margin-bottom: 8px;
}

/* Form Control Styling */
.form-control {
    padding: 12px 16px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 16px;
}
.custom-btn {
    position: fixed;
    top: 20px;        /* 20px from the top of the page */
    right: 20px;      /* 20px from the right side of the page */
    background-color: #4CAF50;  /* Green background */
    color: white;               /* White text color */
    border: none;               /* Remove the border */
    padding: 10px 20px;         /* Padding for size */
    text-align: center;         /* Center align text */
    text-decoration: none;      /* Remove underline (if used as a link) */
    display: inline-block;      /* Allow multiple buttons to line up */
    font-size: 16px;            /* Text size */
    border-radius: 5px;         /* Rounded corners */
    cursor: pointer;           /* Cursor on hover */
    transition: background-color 0.3s ease; /* Smooth transition for hover */
}

/* Hover effect for the button */
.custom-btn:hover {
    background-color: #45a049;  /* Darker green on hover */
}

/* Flex container for title and button */
.profile-header {
    display: flex;               /* Use Flexbox for alignment */
    justify-content: space-between; /* Spread title and button across the container */
    align-items: center;         /* Vertically align content */
    margin-bottom: 40px;          /* Space below the header */
}

/* Optional styles for the profile title */
.profile-header h2 {
    margin: 0;                   /* Remove default margin */
}


    </style>

</head>
<body>

<div class="profile-header">
    <button onclick="window.location.href='perf_dboard.php';" class="custom-btn">Back to dashboard</button>
</div>

<div class="container">
    <!-- Form Container -->
    <div class="form-container">
        <form method="POST" class="my-3">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob">
            </div>
            <div class="mb-3">
                <label for="hire_date" class="form-label">Hire Date:</label>
                <input type="date" class="form-control" id="hire_date" name="hire_date">
            </div>
            <div class="mb-3">
                <label for="employee_type" class="form-label">Employee Type:</label>
                <select class="form-control" id="employee_type" name="employee_type">
                    <option value="Teaching">Teaching</option>
                    <option value="Non-Teaching">Non-Teaching</option>
                    <option value="Officer">Officer</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Salary:</label>
                <input type="number" class="form-control" id="salary" name="salary" step="0.01">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Terminated">Terminated</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="user_id" class="form-label">User ID:</label>
                <input type="number" class="form-control" id="user_id" name="user_id">
            </div>
            <div class="mb-3">
                <label for="policy_agreed" class="form-label">Agree to Policy:</label>
                <input type="checkbox" id="policy_agreed" name="policy_agreed">
            </div>
            <button type="submit" name="add_employee" class="btn btn-primary">Add Employee</button>
        </form>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <?php
        // Fetching employees from the database
        $sql = "SELECT * FROM employees";
        $result = $conn->query($sql);
        ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Date of Birth</th>
                    <th>Hire Date</th>
                    <th>Employee Type</th>
                    <th>Salary</th>
                    <th>Status</th>
                    <th>User ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['EmployeeID']); ?></td>
                        <td><?php echo htmlspecialchars($row['FirstName']); ?></td>
                        <td><?php echo htmlspecialchars($row['LastName']); ?></td>
                        <td><?php echo htmlspecialchars($row['Email']); ?></td>
                        <td><?php echo htmlspecialchars($row['Phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['Address']); ?></td>
                        <td><?php echo htmlspecialchars($row['DOB']); ?></td>
                        <td><?php echo htmlspecialchars($row['HireDate']); ?></td>
                        <td><?php echo htmlspecialchars($row['EmployeeType']); ?></td>
                        <td><?php echo htmlspecialchars($row['Salary']); ?></td>
                        <td><?php echo htmlspecialchars($row['Status']); ?></td>
                        <td><?php echo htmlspecialchars($row['UserID']); ?></td>
                        <td><a href="?delete=<?php echo $row['EmployeeID']; ?>" class="btn btn-danger">Delete</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
