<?php
header("Access-Control-Allow-Origin: *"); //  domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json; charset=utf-8');



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

    case 'assign_role_permissions':
        $role_id = $_POST['role_id'];
        $permissions = $_POST['permissions'];

        $rs = $roles->assignPermissions($role_id, $permissions);

        if ($rs === true) {
            echo json_encode(['success' => true, 'message' => 'Permissions updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update permissions: ' . $rs]);
        }
        break;

    case 'update_role_permissions':
        $role_id = $_POST['role_id'];
        $permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];

        $result = $roles->editRolePermission($role_id, $permissions);

        if ($result === true) {
            echo json_encode(["success" => true, "message" => "Permissions updated"]);
        } else {
            echo json_encode(["failed" => false, "message" => $result]); // Error message from function
        }
        break;
        

    case 'delete_role_permission':
        if (empty($_POST['id'])) {
            echo json_encode(['error' => 'ID is required']);
            exit;
        }

        $id = $_POST['id'];

        // Delete 
        $deleted = $roles->deleteRolesPermission($id);

        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Failed to delete the room']);
        }
        break;


}