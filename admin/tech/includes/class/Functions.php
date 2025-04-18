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

    public function GetAllJobPost()
    {
        try {
            $q = "SELECT DISTINCT * FROM job_postings ORDER BY `job_postings`.`job_title` ASC ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_BOTH);
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function totalApplicants($job_id)
    {
        try {

            $q = "SELECT COUNT(*) as totalApplicants 
                FROM applicants 
                WHERE job_id = ? 
                AND 
                status != 'Hired'";
            $stmt = $this->conn->prepare($q);
            $stmt->execute([$job_id]);
            return $stmt->fetch(PDO::FETCH_BOTH);
        } catch (PDOException $e) {
            return $e;
        }

    }

    public function perDepartment()
    {
        try {

            $q = "SELECT d.DepartmentID, 
                d.DepartmentName, 
                e.FirstName AS Manager 
                FROM departments d 
                LEFT JOIN employees e ON d.ManagerID = e.EmployeeID;";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_BOTH);
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function JobTrend()
    {
        try {

            $q = "SELECT jp.id, jp.job_title, jp.DepartmentID, d.DepartmentName, COUNT(a.id) AS application_count 
                FROM job_postings jp 
                LEFT JOIN applicants a ON jp.id = a.job_id 
                LEFT JOIN departments d ON jp.DepartmentID = d.DepartmentID 
                GROUP BY jp.id, jp.job_title, jp.DepartmentID, d.DepartmentName 
                ORDER BY application_count 
                DESC LIMIT 10; ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_BOTH);
        } catch (PDOException $e) {
            return $e;
        }
    }
    public function OpenJob()
    {
        try {

            $q = "SELECT COUNT(*) as open_job_count
            FROM `job_postings` WHERE status = 'Open' ORDER BY `job_postings`.`status` ASC;  ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function CloseJob()
    {
        try {
            $q = "SELECT COUNT(*) as closed_job_count 
            FROM `job_postings` WHERE status = 'Closed' ORDER BY `job_postings`.`status` ASC;  ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function ApplicantCount()
    {
        try {
            $q = "SELECT DISTINCT COUNT(*) applicant_count FROM `applicants`; ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function JobPosting()
    {
        try {
            $q = "SELECT DISTINCT jp.id, jp.status, jp.job_title FROM job_postings jp; ";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function UpdateJobStatus($job_id, $job_status)
    {
        try {
            $q = "UPDATE `job_postings` SET status=:status WHERE id = :id";
            $stmt = $this->conn->prepare($q);
            $success = $stmt->execute(['id' => $job_id, 'status' => $job_status]);
            
            // Return proper success response
            return $success ? ['success' => true, 'message' => 'Status updated'] 
                           : ['success' => false, 'message' => 'Update failed'];
        } catch (PDOException $e) {
            // Return error information
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}