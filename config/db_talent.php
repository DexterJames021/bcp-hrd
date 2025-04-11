<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
// error_reporting(E_ALL);
// db.php - Database connection
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "bcp-hrd"; // Your database name

// $servername = "localhost";
// $username = "u114085275_admin";
// $password = "7ooiO?kJ"; 
// $dbname = "u114085275_bcphrd"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>