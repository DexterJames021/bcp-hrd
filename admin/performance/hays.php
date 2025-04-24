<?php
// Database connection parameters
require('../../config/db_talent.php');
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <div class="container mt-5">

        <style>
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
    <div class="employee-profile">
        <!-- Flex container for the title and button -->
        <div class="profile-header">
            <h2>Employee Profile</h2>
            <button onclick="window.location.href='perf_dboard.php';" class="custom-btn">Back to dashboard</button>
        </div>

        <?php
        // Fetch employee data, including EmployeeType
        $sql = "SELECT EmployeeID, FirstName, LastName, Email, Phone, Address, DOB, HireDate, Salary, Status, UserID, EmployeeType
                FROM employees";  // Fetch EmployeeType along with other details
        $result = $conn->query($sql);

        // Check if the query returns any rows
        if ($result->num_rows > 0) {
            // Output data of each row
            echo "<table class='table'>";
            echo "<thead><tr>";
            echo "<th>EmployeeID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Address</th><th>DOB</th><th>Hire Date</th><th>Salary</th><th>Status</th><th>UserID</th><th>EmployeeType</th>";
            echo "</tr></thead><tbody>";

            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['EmployeeID'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['Phone'] . "</td>";
                echo "<td>" . $row['Address'] . "</td>";
                echo "<td>" . $row['DOB'] . "</td>";
                echo "<td>" . $row['HireDate'] . "</td>";
                echo "<td>" . $row['Salary'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['UserID'] . "</td>";
                echo "<td>" . $row['EmployeeType'] . "</td>";  // Display the EmployeeType
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "0 results found.";
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
