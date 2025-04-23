<?php
// add_candidate.php
session_start();
require "../../../config/db_talent.php"; // adjust your path

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $program_name = mysqli_real_escape_string($conn, $_POST['program_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $frequency = mysqli_real_escape_string($conn, $_POST['frequency']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = !empty($_POST['end_date']) ? mysqli_real_escape_string($conn, $_POST['end_date']) : NULL;
    $eligibility = mysqli_real_escape_string($conn, $_POST['eligibility']);
    $reward = mysqli_real_escape_string($conn, $_POST['reward']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql = "INSERT INTO retention_programs 
            (program_name, description, frequency, start_date, end_date, eligibility, reward, status) 
            VALUES 
            ('$program_name', '$description', '$frequency', '$start_date', " . 
            ($end_date ? "'$end_date'" : "NULL") . ", 
            '$eligibility', '$reward', '$status')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success_message'] = "Program successfully added!";
        header("Location: ../talent_retention.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Failed to add program: " . mysqli_error($conn);
        header("Location: ../talent_retention.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid request.";
    header("Location: ../talent_retention.php");
    exit();
}
?>
