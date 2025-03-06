<?php
include_once __DIR__ . '/../../../../config/Database.php';

class Task
{
    private $conn;
    private $table = "tasks";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function select_all_task(): mixed
    {
        try {
            // $q = "SELECT * FROM {$this->table}";
            $q = "SELECT t.*, e.FirstName, e.LastName 
            FROM tasks t
            JOIN employees e ON t.UserID = e.EmployeeID
            ORDER BY t.CreatedDate DESC";
            
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $tasks;
        } catch (PDOException $e) {
            return "Something went wrong. " . $e->getMessage();
        }
    }

    // TODO: filter
    public function filter($status){

    }

    public function create_task($creator,$title, $description, $userID): bool|string
    {
        try {
            
            $q = "INSERT INTO " . $this->table . " (Creator, Title, Description, UserID, Status)
            VALUES (:creator, :title, :description, :userID, :status)";

            $stmt = $this->conn->prepare($q);
            $stmt->bindParam(':creator', $creator);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':userID', $userID);
            
            $status = "Pending";
            $stmt->bindParam(':status', $status);

            if ($stmt->execute()) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            return "Something went wrong. " . $e->getMessage();
        }
    }

    public function update_task($id, $creator, $title, $description, $userID) {
        // Prepare the SQL query to update the task
        $query = "UPDATE tasks SET Creator = :creator, Title = :title, Description = :description, UserID = :userID WHERE TaskID = :id";
        $stmt = $this->conn->prepare($query);

        // Bind parameters using PDO
        $stmt->bindParam(':creator', $creator, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
