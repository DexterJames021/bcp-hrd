<?php
// update_program.php
session_start();
require "../../../config/db_talent.php"; // adjust your path

if (isset($_POST['update_program'])) {
    // Get the updated data from the form
    $program_id = mysqli_real_escape_string($conn, $_POST['program_id']);
    $program_name = mysqli_real_escape_string($conn, $_POST['program_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $frequency = mysqli_real_escape_string($conn, $_POST['frequency']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $eligibility = mysqli_real_escape_string($conn, $_POST['eligibility']);
    $reward = mysqli_real_escape_string($conn, $_POST['reward']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update the retention program in the database
    $update_sql = "UPDATE retention_programs SET
                    program_name = '$program_name',
                    description = '$description',
                    frequency = '$frequency',
                    start_date = '$start_date',
                    end_date = '$end_date',
                    eligibility = '$eligibility',
                    reward = '$reward',
                    status = '$status'
                    WHERE id = $program_id";

    if (mysqli_query($conn, $update_sql)) {
        $_SESSION['success_message'] = "Program updated successfully!";
    } else {
        $_SESSION['success_message'] = "Error updating program: " . mysqli_error($conn);
    }

    header("Location: ../talent_retention.php");
    exit();
}
?>
