<?php
// students_eval.php

require('../../config/db_talent.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Only include Teaching employees
$sql = "SELECT EmployeeID, FirstName, LastName FROM employees WHERE EmployeeType = 'Teaching'";
$employee_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Evaluation Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('https://bcp.edu.ph/images/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            background: rgba(255,255,255,0.95);
            padding: 40px;
            border-radius: 15px;
            margin-top: 50px;
            box-shadow: 0 0 25px rgba(0,0,0,0.15);
        }
        h2 {
            color: #004a99;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }
        h4 {
            color: #0066cc;
            margin-top: 30px;
            border-bottom: 2px solid #cce5ff;
            padding-bottom: 5px;
        }
        label {
            font-weight: 500;
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
        ul {
            background: #e9f3ff;
            padding: 15px 20px;
            border-radius: 10px;
            border: 1px solid #cce5ff;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Student Evaluation Form</h2>
    <p><strong>Guide for Rating:</strong></p>
    <ul>
        <li>5 - Excellent</li>
        <li>4 - Very Satisfactory</li>
        <li>3 - Satisfactory</li>
        <li>2 - Needs Improvement</li>
        <li>1 - Poor</li>
    </ul>

    <form action="submit_evaluation.php" method="POST" onsubmit="return confirm('Submit your evaluation?')">
        <!-- Hidden Evaluation Type -->
        <input type="hidden" name="evaluationType" value="Students Evaluation">

        <!-- Teacher Selection -->
        <div class="form-group">
            <label for="employeeID">Select Teacher</label>
            <select class="form-control" id="employeeID" name="employeeID" required>
                <option value="">-- Select Teacher --</option>
                <?php
                if ($employee_result->num_rows > 0) {
                    while($row = $employee_result->fetch_assoc()) {
                        echo "<option value='" . $row['EmployeeID'] . "'>" . $row['FirstName'] . " " . $row['LastName'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No teaching employees found</option>";
                }
                ?>
            </select>
        </div>

        <!-- Evaluation Questions -->
        <?php
        $categories = [
            "A. Knowledge of the subject matter" => [
                "Presents the subject clearly and discusses relevant matters.",
                "Relates subject matter to other fields & real-life situations.",
                "Has up-to-date information about the subject matter."
            ],
            "B. Motivation strategy and techniques" => [
                "Uses appropriate instructional materials.",
                "Encourages student participation.",
                "Gives relevant assignments.",
                "Uses effective evaluation methods."
            ],
            "C. Classroom management" => [
                "Regularly checks student attendance.",
                "Maintains order and discipline inside the class.",
                "Enforces classroom policies consistently."
            ],
            "D. Punctuality and attendance" => [
                "Regularly meets the class.",
                "Arrives and dismisses class on time."
            ],
            "E. Communication Skills" => [
                "Speaks fluently and articulately with a clear voice."
            ],
            "F. Personality and attitude" => [
                "Wears appropriate attire and maintains neat appearance.",
                "Is refined in speech and behavior."
            ],
            "G. Student-faculty relation (Human Relation)" => [
                "Shows concern for students who need help.",
                "Exhibits patience in dealing with students.",
                "Welcomes student ideas and opinions."
            ],
            "H. Fairness in grading" => [
                "Explains the grading procedure clearly.",
                "Allows students to track their performance."
            ]
        ];

        $questionIndex = 1;
        foreach ($categories as $category => $questions) {
            echo "<h4>$category</h4>";
            foreach ($questions as $question) {
                echo "<div class='form-group'>";
                echo "<label>$question</label>";
                echo "<select class='form-control' name='question$questionIndex' required>";
                for ($i = 5; $i >= 1; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                echo "</select>";
                echo "</div>";
                $questionIndex++;
            }
        }
        ?>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Submit Evaluation</button>
        </div>
    </form>
</div>

<?php $conn->close(); ?>
</body>
</html>
