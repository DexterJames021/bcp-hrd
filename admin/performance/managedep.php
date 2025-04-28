<?php
session_start();
require('C:/xampp/htdocs/bcp-hrd/config/db_talent.php');

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
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Employee Management</h2>

    <!-- Back to Dashboard Button in the Upper Right -->
    <div class="back-to-dashboard">
        <a href="perf_dboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>

    <div class="row g-4">
        <!-- Employee Table -->
        <div class="col-lg-12">
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
                                <th>Status</th>
                                <th>User ID</th>
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
                                <td>
                                    <span class="badge bg-<?= $row['Status'] == 'Active' ? 'success' : 'secondary' ?>">
                                        <?= $row['Status'] ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($row['UserID']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- /.col-lg-12 -->
    </div> <!-- /.row -->
</div>

</body>
</html>
