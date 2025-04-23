<?php
session_start();
require "../../../config/db_talent.php"; // Adjust your path if needed


if (isset($_POST['assign_award'])) {
    // Get form data
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $program_id = mysqli_real_escape_string($conn, $_POST['program_id']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $award_date = mysqli_real_escape_string($conn, $_POST['award_date']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Fetch the program name from the retention_programs table
    $program_sql = "SELECT program_name FROM retention_programs WHERE id = '$program_id'";
    $program_result = mysqli_query($conn, $program_sql);
    if ($program_result && mysqli_num_rows($program_result) > 0) {
        $program_row = mysqli_fetch_assoc($program_result);
        $award_name = $program_row['program_name'];  // Award name comes from the retention program name

        // Insert award into employee_awards table
        $sql = "INSERT INTO employee_awards (employee_id, program_id, description, award_date, status)
                VALUES ('$employee_id', '$program_id', '$description', '$award_date', '$status')";

        if (mysqli_query($conn, $sql)) {
            // Set success message
            $_SESSION['success_message'] = 'Award assigned successfully!';
        } else {
            // Set error message
            $_SESSION['error_message'] = 'Error assigning award: ' . mysqli_error($conn);
        }
    } else {
        // Set error message if the program doesn't exist
        $_SESSION['error_message'] = 'Program not found!';
    }

    // Redirect back to the page where the form is located (to show the message)
    header('Location: ../talent_retention.php');
    exit();
}
?>
