<?php
// types_of_evaluations.php

$evaluationTypes = [
    "Supervisor Evaluation" => "supervisor_eval.php",
    "Students Evaluation" => "students_eval.php",
    "Peer Evaluation" => "peer_eval.php"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Types of Evaluations</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('https://bcp.edu.ph/images/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            margin-top: 60px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
            max-width: 600px;
        }

        h2 {
            color: #004a99;
            text-align: center;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .btn-eval {
            background-color: #0056b3;
            color: white;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }

        .btn-eval:hover {
            background-color: #003f7f;
            text-decoration: none;
        }

        .custom-btn {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            display: block;
            margin: 30px auto 0;
            transition: background-color 0.3s ease;
        }

        .custom-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Types of Evaluations</h2>
        <?php foreach ($evaluationTypes as $type => $link): ?>
            <a href="<?php echo $link; ?>" class="btn-eval"><?php echo $type; ?></a>
        <?php endforeach; ?>

        <button onclick="window.location.href='perf_dboard.php';" class="custom-btn">Back to Dashboard</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
