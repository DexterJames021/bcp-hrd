<?php 
<<<<<<< HEAD
session_start(); // Start the session

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: ../auth/index.php");
exit; // Stop script execution after redirect
?>
=======
session_start();

if(isset($_SESSION['user_id'])){
    unset($_SESSION['user_id']);
}

header("Location: ../auth/index.php");

>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
