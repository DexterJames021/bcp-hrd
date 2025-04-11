<?php
session_start();


// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(['error' => 'Unauthorized access']);
//     http_response_code(403);
//     exit;
// }

header("Access-Control-Allow-Origin: https://bcp-hrd.site"); //  domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// header("Content-Type: application/json");

require_once '../class/User.php';
require_once '../class/Roles.php';
require_once '../class/Permission.php';
require '../../../../config/Database.php';

use Admin\Tech\Includes\Class\User;
use Admin\Tech\Includes\Class\Roles;
use Admin\Tech\Includes\Class\Permission;

$user = new User($conn);

$action = $_GET['action'] ?? null;
switch ($action) {

    case 'get_all_employee_details':
        echo json_encode($user->getAllEmployee());
        break;

    case 'get_by_id_employee_info':
        $id = $_POST['id'] ?? null;
        $result = $user->getAllEmployeeByID($id);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Employee not found']);
        }
        break;

    case 'employee_records_edit':

        $data = [
            ':fn' => $_POST['edit_FirstName'],
            ':ln' => $_POST['edit_LastName'],
            ':email' => $_POST['edit_email'],
            ':phone' => $_POST['edit_phone'],
            ':address' => $_POST['edit_address'],
            ':dob' => $_POST['edit_birthday'],
            ':id' => $_POST['edit_id'],
        ];

        $result = $user->EmployeerecordEdit($data);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;

    case 'get_by_id_overview_info':
        $id = $_POST['id'] ?? null;

        $result = $user->getEmployeeOverviewInfo($id);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Employee not found']);
        }
        break;

    case 'get_by_id_training_list':
        $id = $_POST['id'] ?? null;

        $result = $user->getEmployeeTrainingList($id);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Employee not found']);
        }
        break;
    case 'get_by_id_salary':
        $id = $_POST['id'] ?? null;

        $result = $user->getEmployeeSalary($id);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Employee not found']);
        }
        break;
        


    default:
        return null;
}
