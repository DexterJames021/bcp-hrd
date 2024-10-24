<?php
// thanks gpt
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
            JOIN employees e ON t.UserID = e.EmployeeID";
            
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $tasks;
        } catch (PDOException $e) {
            return "Something went wrong. " . $e->getMessage();
        }
    }

    public function create_task($title, $description, $userID): bool|string
    {
        try {
            $q = "INSERT INTO " . $this->table . " (Title, Description, userID, Status)
            VALUES (:title, :description, :userID, Status)";
            $stmt = $this->conn->prepare($q);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':userID', $userID);
            // $stmt->bindParam(':status', $status);

            if ($stmt->execute()) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            return "Something went wrong. " . $e->getMessage();
        }
    }
}
