<?php

namespace Admin\Tech\Includes\Class;

require_once 'Email.php';

use PDO;
use PDOException;
use Admin\Tech\Includes\Class\Email;
use Admin\Tech\Includes\Class\TechException; //? not used


class Booking 
{
    private $conn;
    private $table = 'fm_bookings';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getBookingByUserID($user_id){
        try {
            $query = "SELECT employee_id FROM fm_bookings WHERE id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([":user_id" => $user_id]);
            $rs = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['user_id'] ?? null;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param array[] $data Booking Creation 
     */
    public function createBooking($data)
    {
        $query = "INSERT INTO {$this->table} (employee_id, room_id, booking_date, start_time, end_time, purpose) 
                  VALUES (:employee_id, :room_id, :booking_date, :start_time, :end_time, :purpose)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    /**
     * @param $status request facility table 
     * */
    public function getBookings($status = 'Pending')
    {
        try {
            $query = "SELECT b.*, u.username as employee_name , r.name 
            FROM fm_bookings b 
            JOIN users u ON b.employee_id = u.id 
            JOIN fm_rooms r ON b.room_id = r.id 
            WHERE b.status = :status";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':status' => $status]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @func mixed this Update booking status
     */
    public function updateStatus($id, $status)
    {
        try {
            $query = "UPDATE {$this->table} 
            SET status = :status WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([':status' => $status, ':id' => $id]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    /**
     *get all the data from database for admin side 
     **/
    public function getAll()
    {
        try {
            $q = "SELECT b.booking_date, b.start_time, b.end_time, b.status , r.name 
                    FROM fm_bookings b 
                    JOIN users u ON b.employee_id = u.id 
                    JOIN fm_rooms r ON b.room_id = r.id 
                    ORDER BY b.created_at ASC;  ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function getActiveBookings()
    {
        try {
            $query = "SELECT 
                            b.*, 
                            u.username AS employee_name, 
                            r.name, 
                            r.location, 
                            r.capacity, 
                            r.status AS room_status
                        FROM 
                            fm_bookings b
                        JOIN 
                            users u ON b.employee_id = u.id
                        JOIN 
                            fm_rooms r ON b.room_id = r.id
                        WHERE b.is_active = 1 AND b.status = 'Approved'
                        ORDER BY b.id DESC;";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function checkEndedBookings()
    {
        try {
            $currentTime = date('H:i:s');
            $currentDate = date('Y-m-d');

            $query = "SELECT b.*, u.username as employee_name 
                        FROM fm_bookings b
                        JOIN users u ON b.employee_id = u.id
                        WHERE b.booking_date = :date 
                        AND b.end_time <= :current_time 
                        AND b.is_active = 1";

            $stmt = $this->conn->prepare($query);
            $stmt->execute([':date' => $currentDate, ':current_time' => $currentTime]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    /**
     * @function getFacilityEvents employee event calendar
     * */
    public function getFacilityEvents()
    {
        $query = "SELECT b.*, b.status ,room_id, r.name AS title 
        FROM fm_bookings b 
        JOIN fm_rooms r ON b.room_id = r.id 
        WHERE b.status = 'Approved' OR b.status = 'Pending' OR b.status = 'Cancelled'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $events = [];
        foreach ($results as $row) {
            $events[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'start' => $row['booking_date'] . 'T' . $row['start_time'],
                'end' => $row['booking_date'] . 'T' . $row['end_time'],
                'status' => $row['status'],
                'room' => $row['room_id'],
            ];
        }

        return $events;
    }

    /**
     * when done, the booking will be marked as inactive
     * */
    public function markRoomAvailable($id)
    {
        try {
            $query = "UPDATE fm_rooms SET status = 'Available' WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute([':id' => $id])) {
                return json_encode(['success' => true]);
            }
            return json_encode(['success' => false, 'error' => 'Failed to update room status']);
        } catch (PDOException $e) {
            return json_encode(['error' => 'PDO error: ' . $e->getMessage()]);
        }
    }

    /**
     * @param mixed $booking_id , $room_id end booking
     * */
    public function endBooking($booking_id, $room_id)
    {
        try {
            $query = "UPDATE {$this->table} SET is_active = 0 WHERE id = :booking_id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':booking_id' => $booking_id]);

            $roomUpdated = $this->markRoomAvailable($room_id);

            return $roomUpdated;
        } catch (Exception $e) {
            return json_encode(['error' => 'General error: ' . $e->getMessage()]);
        }
    }

    /**
     * @param mixed $employee_id get booking status
     * emloyee panel view their booking status if approve or reject
     * */
    public function getEmployeeBookings($employee_id)
    {
        $query = "SELECT b.id, b.status, b.purpose, b.booking_date, b.start_time, b.end_time 
                  FROM bookings b
                  WHERE b.employee_id = :employee_id
                  ORDER BY b.updated_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':employee_id' => $employee_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * email
     */
    public function getEmployeeEmailByBookingId($id)
    {
        $query = "SELECT u.username AS email 
                    FROM {$this->table} b 
                    JOIN users u ON b.employee_id = u.id 
                    WHERE b.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['email'] ?? null;
    }

    public function updateBookingStatus($id, $status)
    {
        $query = "UPDATE bookings SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }

    public function cancelBooking($id)
    {
        // $bookingId = intval($id);

        $query = "UPDATE {$this->table} SET status = 'Cancelled', is_active = 0  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
