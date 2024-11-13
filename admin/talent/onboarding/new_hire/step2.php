<?php
session_start();
require "../../../../config/db_talent.php"; // Adjust the path as needed

// Check if the user is already onboarded
if (!isset($_SESSION['user_id'])) {
    header("Location: step1.php"); // Redirect to step 1 if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the employee record exists
$check_employee_query = "SELECT * FROM employees WHERE UserID = ?";
$check_employee_stmt = $conn->prepare($check_employee_query);
$check_employee_stmt->bind_param("i", $user_id);
$check_employee_stmt->execute();
$check_employee_result = $check_employee_stmt->get_result();

if ($check_employee_result->num_rows === 0) {
    header("Location: step1.php"); // Redirect to step 1 if no employee record exists
    exit();
}

// Initialize an array to hold uploaded documents
$uploaded_documents = [];

// Fetch already uploaded documents from the database
$document_query = "SELECT document_name, file_path FROM documents WHERE user_id = ?";
$document_stmt = $conn->prepare($document_query);
$document_stmt->bind_param("i", $user_id);
$document_stmt->execute();
$document_result = $document_stmt->get_result();

while ($doc = $document_result->fetch_assoc()) {
    $uploaded_documents[] = $doc; // Store uploaded documents
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "uploads/documents/"; // Ensure this directory is writable
    foreach ($_FILES['documents']['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($_FILES['documents']['name'][$key]);
        $target_file = $target_dir . $file_name;

        // Attempt to move the uploaded file
        if (move_uploaded_file($tmp_name, $target_file)) {
            // Insert file information into the database
            $insert_document_query = "INSERT INTO documents (user_id, document_name, file_path) VALUES (?, ?, ?)";
            $insert_document_stmt = $conn->prepare($insert_document_query);
            $insert_document_stmt->bind_param("iss", $user_id, $file_name, $target_file);
            
            // Execute the insert query
            if ($insert_document_stmt->execute()) {
                // Successfully uploaded and saved to the database
                // Redirect to prevent re-uploading
                header("Location: step2.php");
                exit();
            } else {
                echo "<script>alert('Error saving document to database: " . $conn->error . "');</script>";
            }
            $insert_document_stmt->close();
        } else {
            echo "<script>alert('Error uploading file: " . htmlspecialchars($_FILES['documents']['name'][$key]) . "');</script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 2: Upload Documents</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <nav aria-label="Progress">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="step1.php">Step 1: Personal Information</a></li>
            <li class="breadcrumb-item active" aria-current="page">Step 2: Upload Documents</li>
            <li class="breadcrumb-item"><a href="step3.php">Step 3: Confirmation</a></li>
        </ol>
        <div class="progress mb-4">
            <div class="progress-bar" role="progressbar" style="width: 66%;" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100">Step 2 of 3</div>
        </div>
    </nav>

    <h2>Upload Your Documents</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="documents">Select documents to upload:</label>
            <input type="file" class="form-control-file" name="documents[]" multiple required>
            <small class="form-text text-muted">You can upload multiple files.</small>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <h3>Uploaded Documents:</h3>
    <ul>
        <?php foreach ($uploaded_documents as $document): ?>
            <li>
                <a href="<?php echo htmlspecialchars($document['file_path']); ?>" download><?php echo htmlspecialchars($document['document_name']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

    <form action="step1.php" method="GET" style="display:inline;">
        <button type="submit" class="btn btn-secondary mt-3">Back</button>
    </form>
    <form action="step3.php" method="GET" style="display:inline;">
        <button type="submit" class="btn btn-success mt-3">Next</button>
    </form>
</div>
</body>
</html>
