<?php
// peer_eval.php

require('C:/xampp/htdocs/bcp-hrd/config/db_talent.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT EmployeeID, FirstName, LastName, EmployeeType FROM employees WHERE EmployeeType = 'Teaching'";
$employee_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Peer Evaluation Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('https://bcp.edu.ph/images/bg.jpg');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.95);
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

        h4 {
            color: #0066cc;
            border-bottom: 2px solid #cce5ff;
            padding-bottom: 5px;
            margin-top: 30px;
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
    <h2>Peer Evaluation Form</h2>
    <p><strong>Guide for Rating:</strong></p>
    <ul>
        <li>5 - Excellent</li>
        <li>4 - Very Satisfactory</li>
        <li>3 - Satisfactory</li>
        <li>2 - Needs Improvement</li>
        <li>1 - Poor</li>
    </ul>

    <form action="submit_evaluation.php" method="POST" onsubmit="return confirm('Submit peer evaluation?')">
        <!-- Hidden Evaluation Type -->
        <input type="hidden" name="evaluationType" value="Peer Evaluation">

        <!-- Peer Selection -->
        <div class="form-group">
            <label for="employeeID">Select Peer</label>
            <select class="form-control" id="employeeID" name="employeeID" required>
                <option value="">-- Select Peer --</option>
                <?php
                if ($employee_result->num_rows > 0) {
                    while($row = $employee_result->fetch_assoc()) {
                        echo "<option value='" . $row['EmployeeID'] . "'>" . $row['FirstName'] . " " . $row['LastName'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No peers found</option>";
                }
                ?>
            </select>
        </div>

        <!-- Evaluation Questions -->
        <?php
        $peerQuestions = [
            "A. Teamwork & Collaboration" => [
                "Contributes actively to team discussions.",
                "Respects and values others’ opinions.",
                "Supports teammates and helps when needed.",
                "Works effectively with others to solve problems."
            ],
            "B. Communication" => [
                "Communicates clearly and professionally.",
                "Keeps the team informed of progress.",
                "Listens actively to feedback."
            ],
            "C. Contribution & Accountability" => [
                "Completes assigned tasks on time.",
                "Is reliable in meeting deadlines.",
                "Takes responsibility for their contributions."
            ],
            "D. Initiative & Leadership" => [
                "Demonstrates leadership and initiative.",
                "Motivates and encourages team members."
            ],
            "E. Openness to Feedback & Growth" => [
                "Accepts constructive criticism positively.",
                "Shows noticeable improvement over time."
            ]
        ];

        $questionIndex = 1;
        foreach ($peerQuestions as $category => $questions) {
            echo "<h4>$category</h4>";
            foreach ($questions as $question) {
                echo "<div class='form-group'>";
                echo "<label for='question$questionIndex'>$question</label>";
                echo "<select class='form-control' name='question$questionIndex' id='question$questionIndex' required>";
                for ($i = 5; $i >= 1; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                echo "</select>";
                echo "</div>";
                $questionIndex++;
            }
        }
        ?>

        <!-- Submit Button -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Submit Evaluation</button>
        </div>
    </form>
</div>

<?php $conn->close(); ?>
</body>
</html>
