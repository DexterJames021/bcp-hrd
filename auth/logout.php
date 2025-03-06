<?php 
// session_start();
// session_unset();
// session_destroy();
// header('Location: ../auth/index.php');
// die();

session_start();

if(isset($_SESSION['user_id'])){
    unset($_SESSION['user_id']);
}


header("Location: ../auth/index.php");
die();
