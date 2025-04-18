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
//  header("Content-Type: application/json");


require '../class/Resources.php';
require '../class/Booking.php';
require '../class/Notification.php';
require '../../../../config/Database.php';

use Admin\Tech\Includes\Class\Notification;
use Admin\Tech\Includes\Class\Booking;

$notification = new Notification($conn);
$booking = new Booking($conn);

$action = $_GET['action'] ?? null;

switch ($action) {

    ###################
    # TODO:
    #   the user id or employee must be pass on creation insteed of admin id 
    ###################
    case 'get_notification_by_id':
        $user_id = $_POST['user_id'];

        $userid = $booking->getBookingByUserID($user_id);

        echo json_encode($user_id ? true : false);

        echo json_encode($notification->GetNotificationByID($userid));
        break;

    case 'get_general_notification':
        echo json_encode($notification->GetGeneralNotification());
        break;

    # employee notif all
    case 'get_status_notification':
        echo json_encode($notification->GetStatusNotifications());
        break;
        
    default:
        return null;
}