<?php
session_start();
require "../../../config/db_talent.php"; // Adjust your path if needed

if (isset($_POST['program_id'])) {
    $program_id = mysqli_real_escape_string($conn, $_POST['program_id']);

    $delete_sql = "DELETE FROM retention_programs WHERE id = $program_id";

    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['success_message'] = "Program deleted successfully!";
    } else {
        $_SESSION['error_message'] = "Error deleting program: " . mysqli_error($conn);
    }
}

header("Location: ../talent_retention.php");
exit();
?>
