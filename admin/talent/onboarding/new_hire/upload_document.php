<?php
session_start();
require "../../../../config/db_talent.php"; // Adjust the path as needed

// Assuming the logged-in user's ID is stored in $_SESSION['user_id']
$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define the upload directory
    $upload_dir = 'uploads/documents'; // Ensure this directory exists and is writable

    // Loop through each uploaded file
    foreach ($_FILES['documents']['tmp_name'] as $key => $tmp_name) {
        $document_name = $_FILES['documents']['name'][$key];
        $document_tmp_name = $_FILES['documents']['tmp_name'][$key];
        $document_error = $_FILES['documents']['error'][$key];

        // Validate file upload
        if ($document_error === UPLOAD_ERR_OK) {
            $target_file = $upload_dir . basename($document_name);

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($document_tmp_name, $target_file)) {
                // Insert document details into the database
                $insert_query = "INSERT INTO documents (user_id, document_name, file_path) VALUES (?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bind_param("iss", $user_id, $document_name, $target_file);

                if ($insert_stmt->execute()) {
                    echo "Document '$document_name' uploaded successfully!<br>";
                } else {
                    echo "Error saving document information for '$document_name': " . $conn->error . "<br>";
                }
                $insert_stmt->close();
            } else {
                echo "Error uploading document '$document_name'.<br>";
            }
        } else {
            echo "Error with document '$document_name': " . $document_error . "<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Task 2: Upload Documents</h2>
    
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="documents">Choose Documents to Upload</label>
            <input type="file" class="form-control-file" name="documents[]" multiple required>
        </div>
        <button type="submit" class="btn btn-primary">Upload Documents</button>
    </form>

    <!-- Navigation buttons -->
    <div class="mt-3">
        <form action="previous_step.php" method="GET" style="display:inline;">
            <button type="submit" class="btn btn-secondary">Back</button>
        </form>
        <form action="next_step.php" method="GET" style="display:inline;">
            <button type="submit" class="btn btn-success">Next</button>
        </form>
    </div>
</div>
</body>
</html>
