<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Define the target directory where the file will be uploaded
    $targetDir = "uploads/contracts/";

    // Get the file's original name
    $fileName = basename($_FILES["contract_file"]["name"]);

    // Define the full path to where the file should be uploaded
    $targetFilePath = $targetDir . $fileName;

    // Check if the file was uploaded successfully
    if (move_uploaded_file($_FILES["contract_file"]["tmp_name"], $targetFilePath)) {
        echo "The file " . htmlspecialchars($fileName) . " has been uploaded successfully.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>