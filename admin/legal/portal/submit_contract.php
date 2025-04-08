<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $user_id = 1; // Assuming you get the current logged-in user ID.
    
    // Handle file upload
    $target_dir = "uploads/contracts/";
    $target_file = $target_dir . basename($_FILES["contract_file"]["name"]);
    
    // Debugging output for target file
    echo "Target file path: " . $target_file . "<br>";

    if ($_FILES["contract_file"]["error"] !== UPLOAD_ERR_OK) {
        echo "File upload error: " . $_FILES["contract_file"]["error"];
    } else {
        // Check if the target directory exists and is writable
        if (!file_exists($target_dir)) {
            echo "Error: Directory doesn't exist.";
        } elseif (!is_writable($target_dir)) {
            echo "Error: Directory is not writable.";
        } else {
            if (move_uploaded_file($_FILES["contract_file"]["tmp_name"], $target_file)) {
                // File uploaded successfully
                echo "File uploaded successfully.";

                // Prepare and execute SQL query
                $query = "INSERT INTO contracts (user_id, title, file_path) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('iss', $user_id, $title, $target_file);

                if ($stmt->execute()) {
                    echo "Contract submitted successfully!";
                } else {
                    echo "Error executing query: " . $stmt->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}
?>
