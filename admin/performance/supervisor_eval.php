<?php
// supervisor_eval.php

// Database connection configuration
<<<<<<< HEAD
require('C:/xampp/htdocs/bcp-hrd/config/db_talent.php');

=======
require('../../config/db_talent.php');
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Only fetch employees with EmployeeType = 'Teaching'
$sql = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) AS FullName, EmployeeType FROM employees WHERE EmployeeType = 'Teaching'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supervisor Evaluation Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
<<<<<<< HEAD
        /* Your existing styles */
=======
        body {
            background-image: url('https://bcp.edu.ph/images/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.96);
            padding: 40px;
            border-radius: 15px;
            margin-top: 50px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
        }

        h2 {
            color: #004a99;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        label {
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .btn-primary {
            background-color: #0056b3;
            border: none;
            padding: 10px 40px;
            font-size: 16px;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #004080;
        }
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
    </style>
</head>
<body>

    <div class="container">
        <h2>Supervisor Evaluation Form</h2>

        <form id="evaluationForm" action="submit_evaluation.php" method="POST" onsubmit="return showConfirmation()">

            <!-- Hidden input to mark the evaluation type -->
            <input type="hidden" name="evaluationType" value="Supervisor Evaluation">

            <!-- Employee dropdown selection -->
            <div class="form-group">
                <label for="employeeName">Select Employee</label>
                <select class="form-control" id="employeeName" name="employeeName" required>
                    <option value="">-- Select Employee --</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['EmployeeID'] . "'>
                                [" . $row['EmployeeID'] . "] " . $row['FullName'] . " (" . $row['EmployeeType'] . ")
                            </option>";
                        }
                    } else {
                        echo "<option value=''>No teaching employees found</option>";
                    }
                    ?>
                </select>
            </div>

<<<<<<< HEAD
            <!-- Evaluation questions with radio buttons -->
=======
            <!-- Evaluation questions -->
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
            <?php
            $questions = [
                "1. How would you rate the employee's overall performance?",
                "2. How effectively does the employee manage their time and prioritize tasks?",
                "3. How well does the employee demonstrate teamwork and collaboration with others?",
                "4. How would you rate the employee's problem-solving abilities?",
                "5. How effective is the employee's communication (both written and verbal)?",
                "6. Does the employee meet deadlines and manage work under pressure?",
                "7. How would you assess the employee's leadership abilities (if applicable)?",
                "8. How well does the employee adapt to change and new challenges?",
                "9. How would you rate the employee's technical skills (if applicable)?",
                "10. How would you rate the employee's overall attitude and work ethic?"
            ];

            foreach ($questions as $index => $question) {
                $qNumber = $index + 1;
                echo "
<<<<<<< HEAD
                    <div class='card question-card'>
                        <div class='card-body'>
                            <label>$question</label>
                            <!-- Radio buttons at the bottom -->
                            <div class='radio-options'>
                                <div class='form-check form-check-inline'>
                                    <input class='form-check-input' type='radio' name='question$qNumber' value='1' required>
                                    <label class='form-check-label'>1 (Poor)</label>
                                </div>
                                <div class='form-check form-check-inline'>
                                    <input class='form-check-input' type='radio' name='question$qNumber' value='2'>
                                    <label class='form-check-label'>2</label>
                                </div>
                                <div class='form-check form-check-inline'>
                                    <input class='form-check-input' type='radio' name='question$qNumber' value='3'>
                                    <label class='form-check-label'>3</label>
                                </div>
                                <div class='form-check form-check-inline'>
                                    <input class='form-check-input' type='radio' name='question$qNumber' value='4'>
                                    <label class='form-check-label'>4</label>
                                </div>
                                <div class='form-check form-check-inline'>
                                    <input class='form-check-input' type='radio' name='question$qNumber' value='5'>
                                    <label class='form-check-label'>5 (Excellent)</label>
                                </div>
                            </div>
                        </div>
=======
                    <div class='form-group'>
                        <label for='question$qNumber'>$question</label>
                        <select class='form-control' id='question$qNumber' name='question$qNumber' required>
                            <option value='1'>1 (Poor)</option>
                            <option value='2'>2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5 (Excellent)</option>
                        </select>
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
                    </div>
                ";
            }
            ?>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Submit Evaluation</button>
            </div>
        </form>
    </div>

    <script>
        function showConfirmation() {
            alert("Evaluation submitted successfully!");
<<<<<<< HEAD
            window.location.href = 'supervisor_eval.php'; // Redirect to eval.php after submission
            return false; // Prevent the default form submission
=======
            return true;
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
        }
    </script>

    <?php $conn->close(); ?>
</body>
</html>
