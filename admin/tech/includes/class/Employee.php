<?php

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
}
