<?php

namespace Admin\Tech\Includes\Class;

use PDO;
use PDOException;

class Room
{
    private $conn;
    private $table = 'fm_rooms';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllAvailable()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'Available'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //used for create booking status pending when room is booked 
    public function updateStatus($id, $status)
    {
        try {
            $query = "UPDATE {$this->table} SET status = :status WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([':id' => $id, ':status' => $status]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    public function getAll()
    {
        $q = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->conn->prepare($q);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create_room($data)
    {
        $q = "INSERT INTO {$this->table} (name,location,capacity,status)
        VALUES(:name,:location,:capacity,:status) ";
        $stmt = $this->conn->prepare($q);
        return $stmt->execute($data);
    }

    public function updateRoom($id, $name, $location, $capacity)
    {
        $q = "UPDATE {$this->table} 
              SET name = :name, location = :location, capacity = :capacity
              WHERE id = :id";

        $stmt = $this->conn->prepare($q);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':location' => $location,
            ':capacity' => $capacity,
        ]);
    }

    /**
     * get by id to update room
     */
    public function getRoomById($id)
    {
        $q = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($q);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteRoom($id)
    {
        $q = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($q);
        return $stmt->execute([':id' => $id]);
    }



    public function FacilityCategorization()
    {
        try {
            $q = "SELECT id, name AS facility_name, 
                    location, 
                    capacity, 
                    status 
                    FROM fm_rooms 
                    WHERE status = 'booked'
                    ORDER BY status DESC, capacity DESC;";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ApproveEvents()
    {
        try {
            $q = "SELECT * FROM `fm_bookings` WHERE status = 'Approved'; ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function FacilityUtilization($start_date, $end_date)
    {
        try {
            $q = "SELECT f.name AS facility_name, 
                        COUNT(b.id) AS booking_count, 
                        f.capacity, 
                        (COUNT(b.id) / f.capacity) * 100 AS utilization_rate 
                  FROM fm_rooms f 
                  LEFT JOIN fm_bookings b 
                    ON f.id = b.room_id 
                    AND b.is_active = 1 
                    " . ($start_date && $end_date ? "AND b.start_date BETWEEN :start_date AND :end_date" : "") . "
                  GROUP BY f.id;";

            $stmt = $this->conn->prepare($q);

            if ($start_date && $end_date) {
                $stmt->bindParam(':start_date', $start_date);
                $stmt->bindParam(':end_date', $end_date);
            }

            $stmt->execute();

            $labels = [];
            $data = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $labels[] = $row['facility_name'];
                $data[] = $row['utilization_rate'];
            }

            return [
                'labels' => $labels,
                'data' => $data
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function BookingStatusDistribution($start_date, $end_date)
    {
        try {
            $q = "SELECT status, COUNT(id) AS status_count 
                  FROM fm_bookings 
                  WHERE is_active = 1
                  " . ($start_date && $end_date ? "AND start_date BETWEEN :start_date AND :end_date" : "") . "
                  GROUP BY status;";

            $stmt = $this->conn->prepare($q);

            if ($start_date && $end_date) {
                $stmt->bindParam(':start_date', $start_date);
                $stmt->bindParam(':end_date', $end_date);
            }

            $stmt->execute();

            $labels = [];
            $data = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $labels[] = $row['status'];
                $data[] = $row['status_count'];
            }

            return [
                'labels' => $labels,
                'data' => $data
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function BookingTrends($start_date, $end_date)
    {
        try {
            $q = "SELECT DATE(booking_date) AS booking_date, COUNT(id) AS total_bookings
                  FROM fm_bookings
                  WHERE is_active = 1
                  " . ($start_date && $end_date ? "AND booking_date BETWEEN :start_date AND :end_date" : "") . "
                  GROUP BY DATE(booking_date)
                  ORDER BY booking_date ASC;";
    
            $stmt = $this->conn->prepare($q);
    
            if ($start_date && $end_date) {
                $stmt->bindParam(':start_date', $start_date);
                $stmt->bindParam(':end_date', $end_date);
            }
    
            $stmt->execute();
    
            $labels = [];
            $data = [];
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $labels[] = $row['booking_date'];
                $data[] = $row['total_bookings'];
            }
    
            return [
                'labels' => $labels,
                'data' => $data
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    

}
