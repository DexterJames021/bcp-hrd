<?php 
require_once './admin/tech/includes/class/Permission.php';
require_once './admin/tech/includes/class/Roles.php';
require_once '../config/Database.php';

use Admin\Tech\Includes\Class\Permission as p;
use Admin\Tech\Includes\Class\Roles;

$permission = new p($conn);
$roles = new Roles($conn);

// Example usage
if ($roles->userHasPermission($_SESSION['user_id'], 'admin')) {
    echo "Access granted";
} else {
    echo "Access denied";
}

?>
