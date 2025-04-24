<?php
// Step 1: Connect to the Database
require('../../config/db_talent.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Fetch Employee Names from the Database
$sql = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) AS FullName FROM employees";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Employee Evaluation Form</h2>

        <!-- Evaluation Form -->
        <form id="evaluationForm" action="submit_evaluation.php" method="POST" onsubmit="return showConfirmation()">
            <!-- Employee Name Dropdown -->
            <div class="form-group">
                <label for="employeeName">Select Employee</label>
                <select class="form-control" id="employeeName" name="employeeName">
                    <option value="">-- Select Employee --</option>
                    <?php
                    // Step 3: Display the Employee Names in the Dropdown
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            // Display employee name in the format "John Doe" and use EmployeeID as the value
                            echo "<option value='" . $row['EmployeeID'] . "'>" . $row['FullName'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No employees found</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Evaluation Questions -->
            <div class="form-group">
                <label for="question1">1. How would you rate the employee's overall performance?</label>
                <select class="form-control" id="question1" name="question1">
                    <option value="1">1 (Poor)</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5 (Excellent)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="question2">2. How effectively does the employee manage their time and prioritize tasks?</label>
                <select class="form-control" id="question2" name="question2">
                    <option value="1">1 (Poor)</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5 (Excellent)</option>
                </select>
            </div>

            <!-- Question 3: Teamwork -->
            <div class="form-group">
                <label for="question3">3. How well does the employee demonstrate teamwork and collaboration with others?</label>
                <select class="form-control" id="question3" name="question3">
                    <option value="1">1 (Poor)</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5 (Excellent)</option>
                </select>
            </div>

            <!-- Question 4: Problem-Solving -->
            <div class="form-group">
                <label for="question4">4. How would you rate the employee's problem-solving abilities?</label>
                <select class="form-control" id="question4" name="question4">
                    <option value="1">1 (Poor)</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5 (Excellent)</option>
                </select>
            </div>

            <!-- Question 5: Communication -->
            <div class="form-group">
                <label for="question5">5. How effective is the employee's communication (both written and verbal)?</label>
                <select class="form-control" id="question5" name="question5">
                    <option value="1">1 (Poor)</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5 (Excellent)</option>
                </select>
            </div>

            <!-- Question 6: Meeting Deadlines -->
            <div class="form-group">
                <label for="question6">6. Does the employee meet deadlines and manage work under pressure?</label>
                <select class="form-control" id="question6" name="question6">
                    <option value="1">1 (Poor)</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5 (Excellent)</option>
                </select>
            </div>

            <!-- Question 7: Leadership (if applicable) -->
            <div class="form-group">
                <label for="question7">7. How would you assess the employee's leadership abilities (if applicable)?</label>
                <select class="form-control" id="question7" name="question7">
                    <option value="1">1 (Poor)</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5 (Excellent)</option>
                </select>
            </div>

            <!-- Question 8: Adaptability -->
            <div class="form-group">
                <label for="question8">8. How well does the employee adapt to change and new challenges?</label>
                <select class="form-control" id="question8" name="question8">
                    <option value="1">1 (Poor)</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5 (Excellent)</option>
                </select>
            </div>

            <!-- Question 9: Technical Skills -->
            <div class="form-group">
                <label for="question9">9. How would you rate the employee's technical skills (if applicable)?</label>
                <select class="form-control" id="question9" name="question9">
                    <option value="1">1 (Poor)</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5 (Excellent)</option>
                </select>
            </div>

            <!-- Question 10: Overall Attitude -->
            <div class="form-group">
                <label for="question10">10. How would you rate the employee's overall attitude and work ethic?</label>
                <select class="form-control" id="question10" name="question10">
                    <option value="1">1 (Poor)</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5 (Excellent)</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit Evaluation</button>
        </form>
    </div>

    <script>
    // Function to show a confirmation alert when the form is submitted
    function showConfirmation() {
        // You can modify this message based on your requirements
        alert("Evaluation submitted successfully!");
        
        // Return true to allow the form submission
        return true;
    }
    </script>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
