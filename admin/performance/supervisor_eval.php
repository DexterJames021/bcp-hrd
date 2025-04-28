<?php
// supervisor_eval.php

// Database connection configuration
require('C:/xampp/htdocs/bcp-hrd/config/db_talent.php');

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
        /* Your existing styles */
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

            <!-- Evaluation questions with radio buttons -->
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
            window.location.href = 'supervisor_eval.php'; // Redirect to eval.php after submission
            return false; // Prevent the default form submission
        }
    </script>

    <?php $conn->close(); ?>
</body>
</html>
