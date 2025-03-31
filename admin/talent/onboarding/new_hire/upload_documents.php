<?php
session_start();
require "../../../../config/db_talent.php"; // Adjust path as needed

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

if (!empty($_FILES['documents']['name'][0])) {
    foreach ($_FILES['documents']['name'] as $key => $name) {
        $fileTmp  = $_FILES['documents']['tmp_name'][$key];
        $filePath = "uploads/" . basename($name);

        if (move_uploaded_file($fileTmp, $filePath)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO documents (user_id, document_name, file_path) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $name, $filePath);
            $stmt->execute();
            $stmt->close();
        } else {
            die("Failed to upload $name.");
        }
    }

    // Redirect back to the page
    header("Location: step1.php");
    exit();
} else {
    echo "No file selected.";
}

$conn->close();
?>
