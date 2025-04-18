<?php
namespace Admin\Tech\Includes\Class;

use PDO;
use PDOException;

class Notification
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    //for testing only 
    public function GetStatusNotifications(){
        $q = "SELECT * FROM notifications WHERE type = 'booking_status' OR type = 'resource_status' ORDER BY created_at DESC; ";
        $stmt = $this->conn->prepare($q);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function InsertNotification($user_id, $message, $type)
    {
        try {
            $notiQuery = "INSERT INTO notifications (user_id, message, type) VALUES (:user_id, :message, :type)";
            $notiStmt = $this->conn->prepare($notiQuery);
            $notiStmt->execute([':user_id' => $user_id, ':message' => $message, ':type' => $type]);
            return $notiStmt;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function GetNotificationByID($user_id)
    {
        try{
            $query = "SELECT * FROM notifications WHERE user_id = :user_id AND type = 'booking_status' ORDER BY created_at DESC; ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':user_id' => $user_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(PDOException $e){
            return $e;
        }

    }

    public function GetGeneralNotification()
    {
        try{
            $q = "SELECT users.username , 
                    notifications.message , 
                    notifications.created_at, 
                    notifications.type, 
                    notifications.id, 
                    notifications.status 
                FROM notifications 
                JOIN users ON user_id = users.id 
                WHERE type = 'booking' OR type = 'resource' AND status = 'unread' 
                ORDER BY created_at DESC; ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }catch(PDOException $e){
            return $e;
        }

    }

    

    
}
