<?php
header("Access-Control-Allow-Origin: *"); //  domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


require '../class/Room.php';
require '../class/Booking.php';
require '../../../../config/Database.php';

use Admin\Tech\Includes\Class\Room;
use Admin\Tech\Includes\Class\Booking;
// use Admin\Tech\Includes\Class\Email;

$room = new Room($conn);
$booking = new Booking($conn);
$action = $_GET['action'] ?? null;

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

    case 'update_book_status':
        $id = $_POST['id'];
        $status = $_POST['status'];

        if ($booking->updateStatus($id, $status)) {
            echo json_encode(['success' => 'true update']);
        } else {
            echo json_encode(['failed' => 'false update']);
        }

        break;

    case 'create_booking':
        if (empty($_POST['employee_id'])) {
            echo json_encode(['error' => 'Room id is required']);
            exit;
        }

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
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['failed' => false]);
        }
        break;

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
        if (!isset($_POST['id'])) return false;

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
        if (empty($_POST['edit_id']) || empty($_POST['edit_name']) || empty($_POST['edit_location']) || empty($_POST['edit_capacity']) || empty($_POST['edit_status'])) {
            echo json_encode(['error' => 'All fields are required']);
            exit;
        }

        $id = $_POST['edit_id'];
        $name = $_POST['edit_name'];
        $location = $_POST['edit_location'];
        $capacity = $_POST['edit_capacity'];
        $status = $_POST['edit_status'];

        // Update room details
        $updated = $room->updateRoom($id, $name, $location, $capacity, $status);

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
            if ($email->sendNotificationEmail($employeeEmail, $subject, $body)) {
                echo json_encode(['success' => true, 'message' => 'Status updated and notification email sent.']);
            } else {
                echo json_encode(['success' => true, 'message' => 'Status updated but email notification failed.']);
            }
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
        echo json_encode($room->FacilityUtilization());
        break;

    case 'facility_categorization':
        echo json_encode($room->FacilityCategorization());
        break;

    case 'booking_status_distribution':
        echo json_encode($room->BookingStatusDistribution());
        break;

    case 'booking_trends':
        echo json_encode($room->BookingTrends());
        break;



    default:
        null;
        break;
}
