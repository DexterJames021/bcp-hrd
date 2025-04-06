<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized access']);
    http_response_code(403);
    exit;
}


header("Access-Control-Allow-Origin: *"); //  domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json"); 

require '../class/Functions.php';
require '../../../../config/Database.php';

use Admin\Tech\Includes\Class\Functions;
// use Admin\Tech\Includes\Class\Email;

$function = new Functions($conn);
$action = $_GET['action'] ?? null;

//todo: filter($_POST['id'], FILTER_SANITIZE_NUMBER_INT) implement this

switch ($action) {
    case 'applicant_status_distro':
        echo json_encode($function->applicantStatusDistro());
        break;

}