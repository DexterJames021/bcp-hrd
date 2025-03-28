<?php 
// need ng basis ng performance

include_once('../../../../config/Database.php');

try{
    if(!$conn){
        die("Database connection failed" . $conn->connect_error);
    }

    

}catch(PDOException $e){
    return "Error: " . $e->getMessage(); 
}finally{
    $conn = null;
}