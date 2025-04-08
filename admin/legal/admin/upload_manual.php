
<?php
include 'db_connection.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $upload_dir = "uploads/";
    
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create directory if not exists
    }

    $file_name = basename($_FILES["manual"]["name"]);
    $target_file = $upload_dir . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES["manual"]["tmp_name"], $target_file)) {
        // Assuming $admin_id is stored in session or set somewhere
        $admin_id = 1;  // Example value, replace with actual admin ID
        $stmt = $conn->prepare("INSERT INTO employees_manual (title, file_path, uploaded_by) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $target_file, $admin_id); // $admin_id should be from session
        $stmt->execute();

        // After successful upload, redirect or send success status
        echo "<script type='text/javascript'>window.onload = function() { alert('Successfully uploaded!'); window.location = 'emanual.php'; };</script>";
    } else {
        // Error occurred during upload
        echo "<script type='text/javascript'>window.onload = function() { alert('Error uploading file!'); window.location = 'emanual.php'; };</script>";
    }
}
?>