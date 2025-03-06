<?php 
require_once './admin/tech/includes/class/Permission.php';
require_once './admin/tech/includes/class/Roles.php';
require_once '../config/Database.php';

use Admin\Tech\Includes\Class\Permission as p;
use Admin\Tech\Includes\Class\Roles;

$permission = new p($conn);
$roles = new Roles($conn);

// Example usage
if ($permission->userHasPermission($_SESSION['user_id'], 'manage_employees')) {
    echo "Access granted";
} else {
    echo "Access denied";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>asdasd</title>
</head>
<body>
    <h1>dasdasd</h1>
</body>
</html>