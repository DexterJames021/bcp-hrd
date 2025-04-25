<?php
require "../config/db_talent.php";
require '../auth/mysqli_accesscontrol.php';

$base_url = 'http://localhost/bcp-hrd';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);


$userID = $_SESSION['user_id'];

// First, kunin yung EmployeeID base sa UserID
$getEmployeeQuery = "SELECT EmployeeID FROM employees WHERE UserID = $userID";
$result = mysqli_query($conn, $getEmployeeQuery);
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
    $targetDir = "uploads/profile_pictures/"; // Create this folder if not existing
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $targetFilePath = $targetDir . time() . "_" . $fileName;
    
    if (move_uploaded_file($fileTmp, $targetFilePath)) {
        $profilePicturePath = $targetFilePath;
    }
}

// Update employee info
$firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
$lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);

$updateEmployee = "UPDATE employees 
                   SET FirstName = '$firstName', LastName = '$lastName', Email = '$email', Phone = '$phone'
                   WHERE EmployeeID = $employeeID";
mysqli_query($conn, $updateEmployee);

// Insert or update profile picture
if ($profilePicturePath) {
    // Check if existing na
    $checkProfile = "SELECT id FROM employee_profile_pictures WHERE EmployeeID = $employeeID";
    $checkResult = mysqli_query($conn, $checkProfile);

    if (mysqli_num_rows($checkResult) > 0) {
        // UPDATE
        $updateProfile = "UPDATE employee_profile_pictures SET profile_picture_path = '$profilePicturePath' WHERE EmployeeID = $employeeID";
        mysqli_query($conn, $updateProfile);
    } else {
        // INSERT
        $insertProfile = "INSERT INTO employee_profile_pictures (EmployeeID, profile_picture_path) VALUES ($employeeID, '$profilePicturePath')";
        mysqli_query($conn, $insertProfile);
    }
}

// Optionally update mo rin session variables kung gusto mong live yung update sa page
$_SESSION['first_name'] = $firstName;
$_SESSION['last_name'] = $lastName;
$_SESSION['email'] = $email;
$_SESSION['phone'] = $phone;
if ($profilePicturePath) {
    $_SESSION['profile_picture'] = $profilePicturePath;
}

// Redirect pabalik sa profile page
header("Location: " . $base_url . "/admin/index.php");
exit;
?>
