<?php
// Include database connection
require "../../../config/db_talent.php";
$base_url = 'http://localhost/bcp-hrd';

// Validate applicant ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Error: Applicant ID is missing.";
    exit;
}

$applicant_id = intval($_GET['id']); // Ensure it's an integer for safety

// Check if a file was uploaded via POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['document'])) {
    $file = $_FILES['document'];

    // Validate the upload
    if ($file['error'] === UPLOAD_ERR_OK) {
        $allowed_extensions = ['pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg'];

        // Correct upload folder
        $upload_dir = 'uploads/documents/';
        $target_directory = __DIR__ . '/uploads/documents/';

        $original_name = basename($file['name']);
        $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

        // Check allowed file types
        if (!in_array($file_ext, $allowed_extensions)) {
            echo "Invalid file type. Only PDF, Word, JPG, and PNG files are allowed.";
            exit;
        }

        // Create upload directory if not exists
        if (!is_dir($target_directory)) {
            mkdir($target_directory, 0777, true);
        }

        // Keep the original filename
        $file_destination = $target_directory . $original_name;

        // Move file to upload directory
        if (move_uploaded_file($file['tmp_name'], $file_destination)) {
            // Save to database
            $relative_path = $original_name; 
            // This is the path saved into DB

            $query = "INSERT INTO document_submissions (applicant_id, document, submission_date) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("is", $applicant_id, $relative_path);

            if ($stmt->execute()) {
                // Redirect back to the applicant portal
                header("Location: ../applicant_portal.php?id=" . $applicant_id);
                exit;
            } else {
                echo "Database error: Unable to save document.";
            }
        } else {
            echo "Error moving uploaded file.";
        }
    } else {
        echo "Upload error: " . $file['error'];
    }
} else {
    echo "No file uploaded.";
}
?>
