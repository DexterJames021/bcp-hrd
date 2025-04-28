<?php
<<<<<<< HEAD

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
=======
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
// db.php - Database connection
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "bcp-hrd"; // Your database name

<<<<<<< HEAD
// $servername = "localhost";
// $username = "u114085275_admin";
// $password = "7ooiO?kJ"; 
// $dbname = "u114085275_bcphrd"; 

=======
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>