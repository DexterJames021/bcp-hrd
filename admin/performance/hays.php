<?php
// Database connection parameters
require('C:/xampp/htdocs/bcp-hrd/config/db_talent.php');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        /* General body and layout styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Container for the employee profile */
        .container {
            max-width: 100%;
        }

        /* Custom button style */
        .custom-btn {
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

        /* Flex container for the title and button */
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

        /* Table styles */
        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        /* Card styles */
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 18px;
        }

        .card-body {
            padding: 30px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <!-- Profile header with title and back button -->
        <div class="profile-header">
            <h2>Employee Profile</h2>
            <button onclick="window.location.href='perf_dboard.php';" class="custom-btn">Back to Dashboard</button>
        </div>

        <!-- Employee Data Table -->
        <?php
        // Fetch employee data
        $sql = "SELECT EmployeeID, FirstName, LastName, Email, Phone, Address, DOB, HireDate, Status, UserID
                FROM employees";  
        $result = $conn->query($sql);

        // Check if the query executed successfully
        if ($result === false) {
            echo "Error executing query: " . $conn->error;
        } else {
            // Check if the query returns any rows
            if ($result->num_rows > 0) {
                echo "<div class='card shadow-sm'>";
                echo "<div class='card-header'>Employee Details</div>";
                echo "<div class='card-body table-responsive'>";
                echo "<table class='table table-striped'>";
                echo "<thead><tr>";
                echo "<th>EmployeeID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Address</th><th>DOB</th><th>Hire Date</th><th>Status</th><th>UserID</th>";
                echo "</tr></thead><tbody>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['EmployeeID'] . "</td>";
                    echo "<td>" . $row['FirstName'] . "</td>";
                    echo "<td>" . $row['LastName'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['Phone'] . "</td>";
                    echo "<td>" . $row['Address'] . "</td>";
                    echo "<td>" . $row['DOB'] . "</td>";
                    echo "<td>" . $row['HireDate'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "<td>" . $row['UserID'] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
                echo "</div></div>";
            } else {
                echo "<p>No employee data found.</p>";
            }
        }

        // Close connection
        $conn->close();
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
        