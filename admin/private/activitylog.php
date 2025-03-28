<?php
require_once '../../config/Database.php';

class ActivityLog {
    private $conn;
    private $table = 'activity_logs';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function log($user_id, $action, $details = null) {
        $query = "INSERT INTO " . $this->table . " (user_id, action, details) VALUES (:user_id, :action, :details)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':user_id' => $user_id,
            ':action' => $action,
            ':details' => $details
        ]);
    }

    public function getLogs() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY timestamp DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
