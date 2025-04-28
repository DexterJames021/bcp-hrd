<?php
session_start();
require __DIR__ . '/../../config/Database.php'; // make sure path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = trim($_POST['password']);

    // Fetch the password from `authenticate` table
    $stmt = $conn->prepare("SELECT password FROM authenticate LIMIT 1");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $db_password = $row['password'];

        // If password is hashed (bcrypt etc.)
        // if (password_verify($password, $db_password)) {
        //     echo "success";
        // } else {
        //     echo "fail";
        // }

        // If password is **plain text** (not recommended), use direct comparison
        if ($password === $db_password) {
            echo "success";
        } else {
            echo "fail";
        }
    } else {
        echo "fail"; // No password record found
    }
}
?>
