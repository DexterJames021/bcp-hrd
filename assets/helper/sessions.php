<?php

session_start();
//need to sa taas ng mga page
//check user_id exist if not back login
if(isset($_SESSION['user_id'])){
    
}else{
    header("Location: ../index.php");
   
}