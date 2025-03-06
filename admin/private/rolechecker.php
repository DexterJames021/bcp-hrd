<?php 

function role($usertype){

    if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == $usertype ||  $_SESSION['usertype'] == $usertype) {
        echo "<script>welcome()</script>";
    } else {
        // header("Location: ../auth/index.php");
        die("Access denied");
    }

    return true;
}

?>