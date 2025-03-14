<?php
header("Access-Control-Allow-Origin: *"); //  domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../class/User.php';
require_once '../class/Roles.php';
require_once '../class/Permission.php';
require '../../../../config/Database.php';

use Admin\Tech\Includes\Class\User;
use Admin\Tech\Includes\Class\Roles;
use Admin\Tech\Includes\Class\Permission;

$user = new User($conn);
$roles = new Roles($conn);
$permission = new Permission($conn);

$action = $_GET['action'] ?? null;
switch ($action) {
    case 'get_all_roles_permission':
        echo json_encode($user->get_all_roles_permission());
        break;

    case 'get_roles':
        echo json_encode($roles->get_roles());
        break;

    case 'get_permissions':
        echo json_encode($permission->getPermission());
        break;


    case 'new_role':
        $rolename = $_POST["RoleName"];
        $description = $_POST["Description"];
        $rs = $roles->createRole($rolename, $description);
        if ($rs) {
            echo json_encode(["success" => "succefully added"]);
        } else {
            echo json_encode(["success" => "failed."]);
        }
        break;

    case 'new_permission':
        $rolename = $_POST["name"];
        $description = $_POST["description"];
        $rs = $permission->createPermission($rolename, $description);
        if ($rs) {
            echo json_encode(["success" => "succefully added"]);
        } else {
            echo json_encode(["success" => "failed."]);
        }
        break;

    case 'update_role_permissions':
        $role_id = $_POST['role_id'];
        $permissions = $_POST['permissions'];
        if ($role->assignPermissions($role_id, $permissions)) {
            echo json_encode(['success' => true, 'message' => 'Permissions updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update permissions']);
        }
        break;


}