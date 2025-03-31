<?php
require "../../../../config/db_talent.php"; // Adjust path as needed

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["document_id"])) {
    $document_id = $_POST["document_id"];

    // Delete the document from the database
    $query = "DELETE FROM documents WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $document_id);

    if ($stmt->execute()) {
        // Redirect back with success message
        header("Location: step1.php");
        exit();
    } else {
        // Redirect back with error message
        header("Location: step1.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
