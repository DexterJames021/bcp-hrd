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

    public function update_task($taskID, $title, $description, $userID, $status){
        try{
            $q = "UPDATE " .$this->table . " SET TaskID = :Title, :Description, :userID, :Status 
            WHERE :TaskID ";
            $stmt = $this->conn->prepare($q);
            $stmt->bindParam('TaskID', $taskID);
            $stmt->bindParam('Title', $title);
            $stmt->bindParam('Description', $description);
            $stmt->bindParam('userID', $userID);
            $stmt->bindParam('Status', $status);
            $result = $stmt->execute();


        }catch(PDOException $e){
            return "Something went wrong. " . $e->getMessage();
        }

    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    $creator = $_SESSION['username'];
    $title = $_POST['Title'];
    $description = $_POST['Description'];
    $userID = $_POST['UserID'];
    // $status = $_POST['Status'];

    $task = new Task($conn); // Ensure $conn is the active database connection
    $taskCreated = $task->create_task($creator, $title, $description, $userID);
    
    // Call the create() method to insert data
    header('Content-Type: application/json'); // Set the content type to JSON
    
    if ($taskCreated === true) {
        echo json_encode(["message" => "Task created successfully!"]);
    } elseif ($taskCreated === false) {
        echo json_encode(["message" => "Failed to create task."]);
    } else {
        echo json_encode(["error" => $taskCreated]); // Return the error message if exception occurred
    }

    exit;
}