<?php

namespace Admin\Tech\Includes\Class;

use PDO;
use PDOException;

class User
{
    private $conn;
    public $id;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getId($id)
    {
        $this->id = $id;
    }

    public function getAllUser()
    {
        try {
            $q = "SELECT * FROM users";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function profile_select_one($id)
    {
        try {
            $q = "SELECT * FROM users WHERE id={$id} LIMIT 1";
            $stmt = $this->conn->prepare($q);
            // $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function profile_select_all()
    {
        try {
            $q = "SELECT * FROM users ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function get_all_roles_permission()
    {
        try {
            $q = "SELECT r.RoleID AS role_id, 
                r.RoleName AS role_name,
                GROUP_CONCAT(p.name ORDER BY p.name SEPARATOR ', ') AS permissions 
                FROM roles r 
                LEFT JOIN role_permissions rp ON r.RoleID = rp.role_id 
                LEFT JOIN permissions p ON rp.permission_id = p.id 
                GROUP BY r.RoleID, r.RoleName; ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getAllEmployee()
    {
        $q = "SELECT e.*, CONCAT(e.FirstName, ' ', e.LastName) AS FullName, 
                jp.job_title AS JobTitle 
                FROM employees e 
                LEFT JOIN applicants a ON e.EmployeeID = a.id 
                LEFT JOIN job_postings jp ON a.job_id = jp.id; ";
        $stmt = $this->conn->prepare($q);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllEmployeeByID($id)
    {
        $q = "SELECT e.* , u.* , a.* 
                FROM employees e 
                JOIN users u ON e.UserID = u.id 
                JOIN applicants a ON u.applicant_id = a.id 
                WHERE e.EmployeeID = :id; ";
        $stmt = $this->conn->prepare($q);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function EmployeerecordEdit($data)
    {
        try {
            $sql = "UPDATE employees 
                    SET FirstName = :fn, 
                        LastName = :ln, 
                        Email = :email, 
                        Phone = :phone, 
                        Address = :address, 
                        DOB = :dob 
                    WHERE EmployeeID = :id";

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getEmployeeOverviewInfo($id)
    {
        $q = "SELECT 
                e.*,
                CONCAT(e.FirstName, ' ', e.LastName) AS FullName,
                d.DepartmentName,
                cb.BaseSalary,
                cb.Bonus,
                (cb.BaseSalary + cb.Bonus) AS TotalCompensation,
                pe.Score AS PerformanceScore,
                pe.EvaluationDate,
                jp.job_title AS JobTitle,
                a.DepartmentID AS ApplicantDepartmentID
            FROM 
                employees e
            LEFT JOIN 
                applicants a ON e.EmployeeID = a.id
            LEFT JOIN 
                departments d ON a.DepartmentID = d.DepartmentID
            LEFT JOIN 
                compensationbenefits cb ON e.EmployeeID = cb.EmployeeID
            LEFT JOIN 
                performanceevaluations pe ON e.EmployeeID = pe.EmployeeID
            LEFT JOIN 
                job_postings jp ON a.job_id = jp.id
            WHERE e.EmployeeID = :id; ";

        $stmt = $this->conn->prepare($q);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEmployeeTrainingList($id)
    {
        $q = "SELECT 
                    tp.TrainingID,
                    tp.TrainingName,
                    tp.Description,
                    tp.StartDate,
                    tp.EndDate,
                    tp.Instructor,
                    ta.status AS TrainingStatus,
                    ta.completion_date AS CompletionDate
                FROM 
                    training_assignments ta
                JOIN 
                    trainingprograms tp ON ta.training_id = tp.TrainingID
                JOIN 
                    employees e ON ta.employee_id = e.EmployeeID
                WHERE e.EmployeeID = :id; ";

        $stmt = $this->conn->prepare($q);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEmployeeSalary($id)
    {
        $q = "SELECT e.EmployeeID, 
                CONCAT(e.FirstName, ' ', e.LastName) AS FullName, 
                cb.BaseSalary, 
                cb.Bonus, 
                cb.BenefitValue 
                FROM employees e 
                LEFT JOIN compensationbenefits cb ON e.EmployeeID = cb.EmployeeID 
                WHERE e.EmployeeID = :id; ";

        $stmt = $this->conn->prepare($q);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
     

}
