<?php

session_start();

// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(['error' => 'Unauthorized access']);
//     http_response_code(403);
//     exit;
// }

header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Origin: https://bcp-hrd.site");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");
// header("Content-Type: application/json");


require '../class/Resources.php';
require '../class/Notification.php';
require '../../../../config/Database.php';

use Admin\Tech\Includes\Class\Resources;
use Admin\Tech\Includes\Class\Notification;

$resource = new Resources($conn);
$nofication = new Notification($conn);
$action = $_GET['action'] ?? null;

switch ($action) {
    case 'fetch_all':
        echo json_encode($resource->getAll());
        break;
    case 'fetch_all_request':
        echo json_encode($resource->getAllRequest());
        break;
    case 'add_new_resource':
        if (!isset($_POST['name']))
            return false;
        $data = [
            ':name' => $_POST['name'],
            ':category' => $_POST['category'],
            ':quantity' => $_POST['quantity'],
            ':status' => $_POST['status'],
            ':next_maintenance' => !empty($_POST['next_maintenance']) ? $_POST['next_maintenance'] : NULL,
            ':last_maintenance' => !empty($_POST['last_maintenance']) ? $_POST['last_maintenance'] : NULL,
            ':location' => $_POST['location'],
        ];

        echo json_encode(['success' => $resource->create_resource($data)]);
        break;

    case 'delete_resource':
        if (!isset($_POST['id']))
            return false;

            $delete = $resource->delete_asset($_POST['id']);
            if($delete){
                echo json_encode(['success'=> true]);
            }else {
                echo json_encode(['success'=> false]);
            }
        break;

    case 'update_resource':
        if (!isset($_POST['id'])) {
            echo json_encode(['success' => false, 'message' => 'Resource ID is required.']);
            return;
        }

        $id = $_POST['id'];
        $data = [
            ':name' => $_POST['name'],
            ':category' => $_POST['category'],
            ':quantity' => $_POST['quantity'],
            ':location' => $_POST['location'],
            ':status' => $_POST['status'],
            ':last_maintenance' => !empty($_POST['last_maintenance']) ? $_POST['last_maintenance'] : NULL,
            ':next_maintenance' => !empty($_POST['next_maintenance']) ? $_POST['next_maintenance'] : NULL,
        ];

        $success = $resource->update_resource($id, $data);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Resource updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update resource.']);
        }
        break;

    case 'update_allocation_status':
        if (!isset($_POST['id'])) {
            echo json_encode(['success' => false, 'message' => 'Resource ID is required.']);
            return;
        }

        $id = $_POST['id'];

        $success = $resource->updateAllocationStatus($id);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Resource updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update resource.']);
        }
        break;

    case 'get_resources_available':
        echo json_encode($resource->getAvailableResource());
        break;

    case 'get_allocation_log':
        echo json_encode($resource->getAllocatedResourcesLog());
        break;

    case 'request_resources':
        if (empty($_POST['resource_id']) || empty($_POST['quantity']) || empty($_POST['employee_id'])) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit;
        }

        $data = [
            'resource_id' => $_POST['resource_id'],
            'employee_id' => $_POST['employee_id'],
            'quantity' => $_POST['quantity'],
            'purpose' => $_POST['purpose'],
        ];

        $message = "New Resource/s request for asset. ID:" . $_POST['resource_id'];

        $result = $resource->requestResource($data);

        if($result){
            $nofication->InsertNotification($_POST['employee_id'], $message, 'resource');
        }

        echo json_encode(['success' => $result]);
        break;

    case 'get_pending_request':
        echo json_encode($resource->PendingRequests());
        break;

    case 'update_request_status':
        if (empty($_POST['request_id']) || empty($_POST['status'])) {
            echo json_encode(['success' => false, 'message' => 'Request ID and status are required.']);
            exit;
        }

        $requestId = $_POST['request_id'];
        $status = $_POST['status'];
        $userID = $_POST['user_id'];

        if (!in_array($status, ['Approved', 'Rejected'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid status.']);
            exit;
        }

        $message = ($status === 'Approved') 
        ? "Your request #{$requestId} has been approved. Thank you for using our service!" 
        : "Your request #{$requestId} has been rejected. Please contact support for more information.";


        $result = $resource->updateRequestStatus($requestId, $status);
        
        if($result){
            $nofication->InsertNotification($userID, $message, 'booking');
        }

        echo json_encode($result);
        break;

    case 'allocate_resource':
        if (empty($_POST['allocate_id']) || empty($_POST['quantity']) || empty($_POST['employee_id']) || empty($_POST['allocation_start'])) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit;
        }

        $data = [
            'resource_id' => $_POST['allocate_id'],
            'employee_id' => $_POST['employee_id'],
            'quantity' => $_POST['quantity'],
            'allocation_start' => $_POST['allocation_start'],
            'allocation_end' => $_POST['allocation_end'] ?? null,
            'status' => 'allocated',
            'notes' => $_POST['notes'] ?? null,
        ];

        $result = $resource->allocateResource($data);
        echo json_encode($result);
        break;

    case 'get_allocated_resources':
        echo json_encode($resource->getAllocatedResources());
        break;

    case 'update_status_allocated_resources':
        if (empty($_POST['allocation_id']) || empty($_POST['status'])) {
            echo json_encode(['success' => false, 'message' => 'Missing data.']);
            exit;
        }

        $allocationId = $_POST['allocation_id'];
        $status = $_POST['status'];

        if ($resource->AllocationStatusUpdate($status, $allocationId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
        }
        break;

    case 'get_allocated_resources_by_ID':
        if (empty($_POST['id'])) {
            echo json_encode(['success' => false, 'message' => 'Request ID and status are required.']);
            exit;
        }

        echo json_encode($resource->getAllocatedResourcesByID($_POST['id']));
        break;

    case 'usage_patterns':
        echo json_encode($resource->UsagePatterns());
        break;

    case 'requests_trend':
        echo json_encode($resource->RequestTrend());
        break;

    case 'unused_resources':
        echo json_encode($resource->getUnusedResources());
        break;

    case 'overutilized_resources':
        echo json_encode($resource->OverutilizedResources());
        break;
    case 'categorize_resources':
        echo json_encode($resource->CategorizedResources());
        break;

    case 'return_all':
        if (empty($_POST['request_id'])) {
            echo json_encode(['success' => false, 'message' => 'Request ID is required.']);
            exit;
        }

        $request_id = $_POST['request_id'];
        $result = $resource->returnResource($request_id);
        echo json_encode($result);
        break;





    default:
        return null;
}
