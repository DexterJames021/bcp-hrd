<?php
require "../config/db_talent.php"; // adjust mo na lang path kung kailangan
require '../auth/mysqli_accesscontrol.php';

$base_url = 'http://localhost/bcp-hrd'; // adjust mo rin kung nasaan ka

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

$userID = $_SESSION['user_id'];

// Get the EmployeeID based on current UserID
$getEmployeeQuery = "SELECT EmployeeID FROM employees WHERE UserID = ?";
$stmt = mysqli_prepare($conn, $getEmployeeQuery);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$employee = mysqli_fetch_assoc($result);

if (!$employee) {
    die("Employee not found.");
}

$employeeID = $employee['EmployeeID'];

// Handle profile picture upload
$profilePicturePath = null;
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['profile_picture']['tmp_name'];
    $fileName = basename($_FILES['profile_picture']['name']);
    $targetDir = "uploads/profile_pictures/"; // adjust mo rin depende sa folder mo
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $targetFilePath = $targetDir . time() . "_" . $fileName;

    if (move_uploaded_file($fileTmp, $targetFilePath)) {
        $profilePicturePath = $targetFilePath;
    }
}

// Sanitize form inputs
$firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
$lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);

// Update employee information
$updateEmployeeQuery = "UPDATE employees 
                        SET FirstName = ?, LastName = ?, Email = ?, Phone = ?
                        WHERE EmployeeID = ?";
$stmt = mysqli_prepare($conn, $updateEmployeeQuery);
mysqli_stmt_bind_param($stmt, "ssssi", $firstName, $lastName, $email, $phone, $employeeID);
mysqli_stmt_execute($stmt);

// Insert or update profile picture
if ($profilePicturePath) {
    $checkProfileQuery = "SELECT id FROM employee_profile_pictures WHERE EmployeeID = ?";
    $stmt = mysqli_prepare($conn, $checkProfileQuery);
    mysqli_stmt_bind_param($stmt, "i", $employeeID);
    mysqli_stmt_execute($stmt);
    $checkResult = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($checkResult) > 0) {
        // UPDATE profile picture
        $updateProfileQuery = "UPDATE employee_profile_pictures 
                               SET profile_picture_path = ?
                               WHERE EmployeeID = ?";
        $stmt = mysqli_prepare($conn, $updateProfileQuery);
        mysqli_stmt_bind_param($stmt, "si", $profilePicturePath, $employeeID);
        mysqli_stmt_execute($stmt);
    } else {
        // INSERT profile picture
        $insertProfileQuery = "INSERT INTO employee_profile_pictures (EmployeeID, profile_picture_path) 
                               VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insertProfileQuery);
        mysqli_stmt_bind_param($stmt, "is", $employeeID, $profilePicturePath);
        mysqli_stmt_execute($stmt);
    }
}

// Optionally update session variables para realtime na rin sa profile mo
$_SESSION['first_name'] = $firstName;
$_SESSION['last_name'] = $lastName;
$_SESSION['email'] = $email;
$_SESSION['phone'] = $phone;
if ($profilePicturePath) {
    $_SESSION['profile_picture'] = $profilePicturePath;
}

// Redirect after update
header("Location: " . $base_url . "/portal/index.php"); // change mo kung saan babalik
exit;
?>
