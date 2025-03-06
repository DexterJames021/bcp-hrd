<?php
namespace Admin\Tech\Includes\Class;

use PDO;
use PDOException;

class Employee
{
    private $conn;
    private $table = "employees";
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function select_all()
    {
        try {
            $q = "SELECT * FROM {$this->table}";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $employees;
        } catch (PDOException $e) {
            return "Something went wrong" . $e;
        }
    }

    public function profile_select_one($id){
        try{
            $q = "SELECT * FROM {$this->table} WHERE EmployeeID= :id LIMIT 1";
            $stmt = $this->conn->prepare($q);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
}   
