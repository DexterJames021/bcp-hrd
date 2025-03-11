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

$action = $_GET['action'] ?? null;
switch ($action) {
    case 'get_all_roles_permission':
        echo json_encode($user->get_all_roles());
        break;

    case 'new_role':
        $rolename = $_POST["RoleName"];
        $description = $_POST["Description"];
        $rs = $roles->newRole($rolename, $description)
        if($rs){
            echo json_encode("message"=> "succefully added");
        }else{
            echo json_encode("message"=> "failed.");
        }
        break;

}