<?php
namespace Admin\Tech\Includes\Class;

use PDO;
use PDOException;

class Functions
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function applicantStatusDistro()
    {
        try {
            $q = "SELECT 
                        status, 
                        COUNT(*) AS status_count
                    FROM 
                        applicants
                    GROUP BY 
                        status;";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $employees;
        } catch (PDOException $e) {
            return "Something went wrong" . $e;
        }
    }

    
}