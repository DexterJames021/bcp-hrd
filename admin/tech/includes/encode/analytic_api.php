<?php
session_start();

// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(['error' => 'Unauthorized access']);
//     http_response_code(403);
//     exit;
// }


header("Access-Control-Allow-Origin: *"); //  domain
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");
// header("Content-Type: application/json"); 

require '../class/Functions.php';
require '../class/Employee.php';
require '../../../../config/Database.php';

use Admin\Tech\Includes\Class\Functions;
use Admin\Tech\Includes\Class\Employee;

$function = new Functions($conn);
$employee = new Employee($conn);
$action = $_GET['action'] ?? null;

//todo: filter($_POST['id'], FILTER_SANITIZE_NUMBER_INT) implement this

switch ($action) {
    case 'applicant_status_distro':
        echo json_encode($function->applicantStatusDistro());
        break;
    case 'applicant_per_dept':
        echo json_encode($employee->ApplicantsPerDept());
        break;
    case 'employee_per_dept':
        echo json_encode($employee->EmployeesPerDept());
        break;
    case 'job_trend':
        echo json_encode($function->JobTrend());
        break;
    case 'job_status':
        echo json_encode([
            "open" => $function->OpenJob(),
            "closed" => $function->CloseJob(),
            "applicant_count" => $function->ApplicantCount(),
        ]);
        break;
    case "job_posting":
        echo json_encode($function->JobPosting());
        break;
    case "update_jobs_status":
        $job_id = $_POST["job_id"];
        $job_status = $_POST["job_status"];

        $result = $function->UpdateJobStatus($job_id, $job_status);
        echo json_encode($result);
        break;

    default:
        return null;

}