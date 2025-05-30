<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Content-Type: application/json");
    // echo json_encode(['error' => 'Unauthorized access']);
    http_response_code(403);
    exit;
}


header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Origin: https://bcp-hrd.site"); 
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");
// header("Access-Control-Allow-Credentials: true");
// header("Content-Type: application/json"); employee b 

require '../class/Room.php';
require '../class/Booking.php';
require '../class/Notification.php';
// require '../class/Email.php';
require '../../../../config/Database.php';

use Admin\Tech\Includes\Class\Room;
use Admin\Tech\Includes\Class\Booking;
use Admin\Tech\Includes\Class\Notification;

// use Admin\Tech\Includes\Class\Email;

$room = new Room($conn);
$booking = new Booking($conn);
// $mail = new Email();
$nofication = new Notification($conn);
$action = $_GET['action'] ?? null;
$employee_id = $_POST['employee_id'] ?? null;

//todo: filter($_POST['id'], FILTER_SANITIZE_NUMBER_INT) implement this

switch ($action) {
    case 'create_room':
        if (empty($_POST['fm_name'])) {
            echo json_encode(['error' => 'Room name is required']);
            exit;
        }

        $data = [
            ':name' => $_POST['fm_name'],
            ':location' => $_POST['fm_location'],
            ':capacity' => $_POST['fm_capacity'],
            ':status' => $_POST['fm_status'],
        ];
        echo json_encode(['success' => $room->create_room($data)]);
        break;

    case 'fetch_avail_room':
        echo json_encode($room->getAllAvailable());
        break;

    case 'fetch_avail_book':
        /* kuha ng available room para sa select tag  */
        $status = $_GET['status'] ?? 'Pending';
        echo json_encode($booking->getBookings($status));
        break;

    case 'get_all_room':
        echo json_encode($room->getAll());
        break;

    case 'fetch_all_book_adm':
        echo json_encode($booking->getAll());
        break;

    //approval 
    case 'update_book_status':
        $id = $_POST['id'];
        $status = $_POST['status'];

        $message = ($status === 'Approved')
            ? "Your booking #{$id} has been approved. Thank you for using our service!"
            : "Your booking #{$id} has been rejected. Please contact support for more information.";

        $userid = $booking->getBookingByUserID($_POST['userID']);

        if ($booking->updateStatus($id, $status)) {
            $nofication->InsertNotification($userid, $message, 'booking_status');
            echo json_encode(['success' => 'true update ' . $message]);
        } else {
            echo json_encode(['failed' => 'false update']);
        }

        break;

    case 'create_booking':
        if (empty($_POST['employee_id'])) {
            echo json_encode(['error' => 'Room id is required']);
            exit;
        }

        $message = "New booking request for Room. ID:" . $_POST['room_id'];

        $data = [
            ':employee_id' => $_POST['employee_id'],
            ':room_id' => $_POST['room_id'],
            ':booking_date' => $_POST['booking_date'],
            ':start_time' => $_POST['start_time'],
            ':end_time' => $_POST['end_time'],
            ':purpose' => $_POST['purpose'],
        ];

        //room status bookd when booking is created
        if ($booking->createBooking($data)) {
            $room->updateStatus($_POST['room_id'], 'Booked');
            $nofication->InsertNotification($_POST['employee_id'], $message, 'booking');
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['failed' => false]);
        }
        break;


    //approval with mail
    // case 'update_book_status':
    //     $id = $_POST['id'];
    //     $status = $_POST['status'];

    //     // First get booking details before updating
    //     $bookingDetails = $booking->getBookings($id);

    //     if (!$bookingDetails) {
    //         echo json_encode(['failed' => 'Booking not found']);
    //         break;
    //     }

    //     // Update the status
    //     if ($booking->updateStatus($id, $status)) {
    //         // Prepare email notification
    //         $toEmail = $bookingDetails['email']; // Assuming your booking has an email field
    //         $subject = "Your Booking Status Update";

    //         if ($status === 'approved') {
    //             $message = "Your booking #{$id} has been approved. Thank you for using our service!";
    //         } else {
    //             $message = "Your booking #{$id} has been rejected. Please contact support for more information.";
    //         }

    //         // Send email notification
    //         $emailResult = $email->sendEmailNotification($toEmail, $subject, $message);

    //         if ($emailResult === true) {
    //             echo json_encode(['success' => 'Status updated and notification sent']);
    //         } else {
    //             // Status was updated but email failed
    //             echo json_encode([
    //                 'success' => 'Status updated but email failed',
    //                 'email_error' => $emailResult
    //             ]);
    //         }
    //     } else {
    //         echo json_encode(['failed' => 'Status update failed']);
    //     }
    //     break;

    case 'get_all_approved_bookings':
        echo json_encode($booking->getActiveBookings());
        break;

    case 'check_ended_bookings':
        echo json_encode($booking->checkEndedBookings());
        break;

    //todo: get all approve and pending display all
    case 'get_facility_events':
        echo json_encode($booking->getFacilityEvents());
        break;

    case 'mark_inactive':
        if (!isset($_POST['id']))
            return false;

        $id = $_POST['id'];
        echo json_encode(['success' => $booking->markRoomAvailable($id)]);
        break;

    case 'end_booking': //pagdigumana remove if empty booking_id
        if (empty($_POST['booking_id'])) {
            echo json_encode(['error' => 'Room id is required']);
            exit;
        }

        $booking_id = $_POST['booking_id'];
        $room_id = $_POST['room_id'];
        echo json_encode(['success' => $booking->endBooking($booking_id, $room_id)]);
        break;

    case 'update_room':
        // Validate input
        if (empty($_POST['edit_id']) || empty($_POST['edit_name']) || empty($_POST['edit_location']) || empty($_POST['edit_capacity'])) {
            echo json_encode(['error' => 'All fields are required']);
            exit;
        }

        $id = $_POST['edit_id'];
        $name = $_POST['edit_name'];
        $location = $_POST['edit_location'];
        $capacity = $_POST['edit_capacity'];
        // $status = $_POST['edit_status'];
        // $status = !empty($_POST['edit_status']) ? $_POST['edit_status'] : NULL;

        // Update room details
        $updated = $room->updateRoom($id, $name, $location, $capacity);

        if ($updated) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Failed to update the room']);
        }
        break;


    case 'get_room_by_id':
        if (empty($_GET['id'])) {
            echo json_encode(['error' => 'Room ID is required']);
            exit;
        }

        $id = $_GET['id'];
        $roomData = $room->getRoomById($id);

        if ($roomData) {
            echo json_encode($roomData);
        } else {
            echo json_encode(['error' => 'Room not found']);
        }
        break;

    case 'delete_room':
        // Validate input
        if (empty($_POST['id'])) {
            echo json_encode(['error' => 'Room ID is required']);
            exit;
        }

        $id = $_POST['id'];

        // Delete the room
        $deleted = $room->deleteRoom($id);

        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Failed to delete the room']);
        }
        break;

    //! not use
    case 'update_booking_status':
        if (empty($_POST['id']) || empty($_POST['status'])) {
            echo json_encode(['success' => false, 'message' => 'Booking ID and status are required.']);
            exit;
        }

        $id = $_POST['id'];
        $status = $_POST['status'];
        $employeeEmail = $booking->getEmployeeEmailByBookingId($id); // Fetch employee's email based on booking ID

        // Update booking status in the database
        $isUpdated = $booking->updateBookingStatus($id, $status);

        if ($isUpdated) {
            // Prepare email content
            $subject = "Booking Status Updated: {$status}";
            $body = "Dear Employee,<br><br>Your booking request has been <b>{$status}</b>.<br>Thank you for using our booking system.<br><br>Best regards,<br>Booking Team";

            // Send email notification
            // if ($email->sendNotificationEmail($employeeEmail, $subject, $body)) {
            //     echo json_encode(['success' => true, 'message' => 'Status updated and notification email sent.']);
            // } else {
            //     echo json_encode(['success' => true, 'message' => 'Status updated but email notification failed.']);
            // }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update booking status.']);
        }
        break;

    case 'cancel_facility_booking':
        $id = $_POST['id'];

        if ($booking->cancelBooking($id)) {
            $room->updateStatus($_POST['room_id'], 'Available');
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;

    case 'facility_utilization':
        $start_date = $_POST['start_date'] ?? null;
        $end_date = $_POST['end_date'] ?? null;
        echo json_encode($room->FacilityUtilization($start_date, $end_date));
        break;

    case 'booking_status_distribution':
        $start_date = $_POST['start_date'] ?? null;
        $end_date = $_POST['end_date'] ?? null;
        echo json_encode($room->BookingStatusDistribution($start_date, $end_date));
        break;

    case 'booking_trends':
        $start_date = $_POST['start_date'] ?? null;
        $end_date = $_POST['end_date'] ?? null;
        echo json_encode($room->BookingTrends($start_date, $end_date));
        break;

    case 'facility_categorization':
        echo json_encode($room->FacilityCategorization());
        break;
    case 'events_all_approved':
        echo json_encode($room->ApproveEvents());
        break;


    default:
        null;
        break;
}
