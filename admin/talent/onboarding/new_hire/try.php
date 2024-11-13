<?php
session_start();

// Initialize current task in session
if (!isset($_SESSION['current_task'])) {
    $_SESSION['current_task'] = 1; // Start with the first task
}

// Handle task navigation
if (isset($_POST['next'])) {
    $_SESSION['current_task'] = min($_SESSION['current_task'] + 1, 3); // Increment task, max 3
} elseif (isset($_POST['back'])) {
    $_SESSION['current_task'] = max($_SESSION['current_task'] - 1, 1); // Decrement task, min 1
}

// Define tasks
$tasks = [
    1 => 'Onboarding Form',
    2 => 'Document Upload',
    3 => 'Task Completion',
];

// Determine the progress percentage
$progress_percentage = ($_SESSION['current_task'] / 3) * 100;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Bar Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Task Progress</h2>

    <!-- Progress Bar -->
    <div class="progress mb-3">
        <div class="progress-bar" role="progressbar" style="width: <?= $progress_percentage ?>%;" aria-valuenow="<?= $_SESSION['current_task'] ?>" aria-valuemin="0" aria-valuemax="3">
            Task <?= $_SESSION['current_task'] ?> of 3
        </div>
    </div>

    <!-- Display Current Task -->
    <h4>Current Task: <?= $tasks[$_SESSION['current_task']] ?></h4>

    <form method="POST" action="">
        <button type="submit" class="btn btn-secondary" name="back" <?= $_SESSION['current_task'] == 1 ? 'disabled' : '' ?>>Back</button>
        <button type="submit" class="btn btn-success" name="next" <?= $_SESSION['current_task'] == 3 ? 'disabled' : '' ?>>Next</button>
    </form>
</div>
</body>
</html>
