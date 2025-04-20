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

    public function profile_select_one($id)
    {
        try {
            $q = "SELECT * FROM {$this->table} WHERE EmployeeID= :id LIMIT 1";
            $stmt = $this->conn->prepare($q);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function EmployeesPerDept()
    {
        try {
            $q = "SELECT d.DepartmentName, COUNT(e.EmployeeID) AS totalEmployees
                            FROM employees e
                            LEFT JOIN users u ON e.UserID = u.id  -- Get the applicant ID through users table
                            LEFT JOIN applicants a ON u.applicant_id = a.id  -- Get the department through the applicant
                            LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID  -- Fetch department name
                GROUP BY d.DepartmentName";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function ApplicantsPerDept()
    {
        try {
            $q = "SELECT d.DepartmentName, COUNT(a.id) AS totalApplicants
                FROM applicants a
                LEFT JOIN departments d ON a.DepartmentID = d.DepartmentID
                GROUP BY d.DepartmentName";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }




}
