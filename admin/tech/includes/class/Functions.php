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
                ORDER BY application_count DESC  ";
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

            return $success ? ['success' => true, 'message' => 'Status updated']
                : ['success' => false, 'message' => 'Update failed'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function AddJobPosting($data)
    {
        try {
            $q = "INSERT INTO `job_postings` ( `job_title`, `job_description`, `requirements`, `location`, `salary_range` ) 
             VALUES ( :job_title, :job_description, :requirements, :location, :salary_range); ";
            $stmt = $this->conn->prepare($q);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function AttendanceList()
    {
        try {
            $q = "SELECT 
                    a.attendance_id,
                    a.employee_id,
                    CONCAT(e.FirstName, ' ', e.LastName) AS fullname,
                    a.date,
                    TIME_FORMAT(a.time_in, '%H:%i:%s') as time_in,
                    TIME_FORMAT(a.time_out, '%H:%i:%s') as time_out,
                    a.status
                  FROM attendance a
                  JOIN employees e ON a.employee_id = e.EmployeeID
                  ORDER BY a.date DESC, a.time_in DESC";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("AttendanceList Error: " . $e->getMessage());
            return [];
        }
    }

    public function AddAttendance($data)
    {
        try {
            // Check if record exists for today
            $stmt = $this->conn->prepare("
                SELECT * FROM attendance 
                WHERE employee_id = :employeeId AND date = CURDATE()
            ");
            $stmt->execute([':employeeId' => $data['employee_id']]);
            $existing = $stmt->fetch();

            if ($existing) {
                // Update time out
                $stmt = $this->conn->prepare("
                    UPDATE attendance SET 
                    time_out = CURTIME(),
                    status = CASE 
                        WHEN TIMEDIFF(CURTIME(), time_in) < '04:00:00' THEN 'half-day'
                        WHEN time_in > '08:30:00' THEN 'late'
                        ELSE 'present'
                    END
                    WHERE attendance_id = :id
                ");
                return $stmt->execute([':id' => $existing['attendance_id']]);
            } else {
                // Insert new record
                $stmt = $this->conn->prepare("
                    INSERT INTO attendance (employee_id, date, time_in, status)
                    VALUES (:employeeId, CURDATE(), CURTIME(), 
                    CASE 
                        WHEN CURTIME() > '08:30:00' THEN 'late'
                        ELSE 'present'
                    END)
                ");
                return $stmt->execute([':employeeId' => $data['employee_id']]);
            }
        } catch (PDOException $e) {
            error_log("AddAttendance Error: " . $e->getMessage());
            return false;
        }
    }

    public function ImportAttendance($file)
    {
        try {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new \Exception("File upload error"); // Added backslash
            }

            $handle = fopen($file['tmp_name'], 'r');
            if (!$handle) {
                throw new \Exception("Cannot open file"); // Added backslash
            }

            // Skip header
            fgetcsv($handle);

            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare("
                INSERT INTO attendance 
                (employee_id, date, time_in, time_out, status)
                VALUES (?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                time_in = VALUES(time_in),
                time_out = VALUES(time_out),
                status = VALUES(status)
            ");

            $lineNumber = 1;
            $successCount = 0;
            $errorMessages = [];

            while (($data = fgetcsv($handle)) !== false) {
                $lineNumber++;

                try {
                    // Skip empty lines
                    if (empty($data[0])) {
                        continue;
                    }

                    // Validate employee_id is numeric
                    if (!is_numeric($data[0])) {
                        throw new \Exception("Invalid employee ID at line $lineNumber"); // Added backslash
                    }

                    $employeeId = (int) $data[0];
                    $date = date('Y-m-d', strtotime($data[1])); // Convert to proper date format
                    $timeIn = !empty($data[2]) ? date('H:i:s', strtotime($data[2])) : null;
                    $timeOut = !empty($data[3]) ? date('H:i:s', strtotime($data[3])) : null;
                    $status = in_array($data[4], ['present', 'absent', 'late', 'half-day'])
                        ? $data[4]
                        : 'present';

                    $stmt->execute([$employeeId, $date, $timeIn, $timeOut, $status]);
                    $successCount++;
                } catch (\Exception $e) { // Added backslash
                    $errorMessages[] = $e->getMessage();
                }
            }

            $this->conn->commit();
            fclose($handle);

            return [
                'success' => true,
                'message' => 'CSV imported successfully',
                'imported' => $successCount,
                'errors' => $errorMessages
            ];
        } catch (\Exception $e) { // Added backslash
            $this->conn->rollBack();
            if (isset($handle))
                fclose($handle);
            error_log("ImportAttendance Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => [$e->getMessage()]
            ];
        }
    }

    
}