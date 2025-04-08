<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bcp-hrd";

$conn = new mysqli('localhost', 'root', '', 'bcp-hrd');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>