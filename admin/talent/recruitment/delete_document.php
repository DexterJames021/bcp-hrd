<?php
// Include the database connection
require "../../../config/db_talent.php";

// Get the ID and the file path from the URL
$document_id = intval($_GET['id']); // Make sure it's an integer
$file_path = urldecode($_GET['file']); // Decode the file path

// Check if the document exists in the database
$query = "SELECT * FROM document_submissions WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $document_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Get the record
    $row = $result->fetch_assoc();

    // Construct the full file path based on the file's stored location
    $upload_dir = __DIR__ . '/uploads/documents/';
    $absolute_file_path = $upload_dir . basename($file_path);

    // Delete the file from the server if it exists
    if (file_exists($absolute_file_path)) {
        if (unlink($absolute_file_path)) {
            // File deleted successfully
            // Now delete the record from the database
            $delete_query = "DELETE FROM document_submissions WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param("i", $document_id);

            if ($delete_stmt->execute()) {
                // Redirect back to the applicant portal or show success message
                header("Location: ../applicant_portal.php?id=" . $row['applicant_id']);
                exit;
            } else {
                echo "Error: Could not delete the document record from the database.";
            }
        } else {
            echo "Error: Could not delete the file from the server.";
        }
    } else {
        echo "Error: File not found on the server.";
    }
} else {
    echo "Error: Document not found in the database.";
}
?>
