<?php

// Database configuration constants
define("HOST", "localhost");
define("DB", "bcp-hrd");
define("USER", "root");
define("PASS", "");
define("PORT", 3306); // If you're using a specific port, include it
define("DSN", "mysql:host=".HOST.";port=".PORT.";dbname=".DB.";charset=utf8mb4");

try {
    // PDO connection
    $conn = new PDO(DSN, USER, PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DATABASE ERROR: " . $e->getMessage());
}




