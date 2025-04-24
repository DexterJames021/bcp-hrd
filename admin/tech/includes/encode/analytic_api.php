<?php
session_start();

if (!isset($_SESSION['user_id']) ) {
    header("Content-Type: application/json");
    echo json_encode(['error' => 'Unauthorized access']);
    http_response_code(403);
    exit;
}


header("Access-Control-Allow-Origin: *"); //  domain
// header("Access-Control-Allow-Origin: https://bcp-hrd.site");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");
// header("Content-Type: application/json"); 

require '../class/Functions.php';
require '../class/Employee.php';
require '../../../../config/Database.php';

use Admin\Tech\Includes\Class\Functions;
use Admin\Tech\Includes\Class\Employee;

$function = new Functions($conn);
$employee = new Employee($conn);
$action = $_GET['action'] ?? null;

//todo: filter($_POST['id'], FILTER_SANITIZE_NUMBER_INT) implement this

switch ($action) {
    case 'applicant_status_distro':
        echo json_encode($function->applicantStatusDistro());
        break;
    case 'applicant_per_dept':
        echo json_encode($employee->ApplicantsPerDept());
        break;
    case 'employee_per_dept':
        echo json_encode($employee->EmployeesPerDept());
        break;
    case 'get_all_job_post':
        echo json_encode($function->GetAllJobPost());
        break;
    case 'job_trend':
        echo json_encode($function->JobTrend());
        break;
    case 'job_status':
        echo json_encode([
            "open" => $function->OpenJob(),
            "closed" => $function->CloseJob(),
            "applicant_count" => $function->ApplicantCount(),
        ]);
        break;
    case "job_posting":
        echo json_encode($function->JobPosting());
        break;
    case "update_jobs_status":
        $job_id = $_POST["job_id"];
        $job_status = $_POST["job_status"];

        $result = $function->UpdateJobStatus($job_id, $job_status);
        echo json_encode($result);
        break;
    case "add_new_job_post":

        $data = [
            ":job_title" => $_POST["job_title"],
            ":job_description" => $_POST["job_description"],
            ":requirements" => $_POST["requirements"],
            ":location" => $_POST["location"],
            ":salary_range" => $_POST["salary_range"]
        ];

        if ($function->AddJobPosting($data)) {
            echo json_encode(["message" => true]);
        } else {
            echo json_encode(["message" => false]);

        }
        break;
    case "attendance_list":
        echo json_encode($function->AttendanceList());
        break;
    case "record_attendance":
        $data = [
            ":employee_id" => $_POST["employee_id"],
        ];

        $result = $function->AddAttendance($data);
        echo json_encode($result ? ["success" => true] : ["error" => "Failed to record attendance"]);
        break;

    case "import_attendance":
        if (!isset($_FILES['csvFile']) || $_FILES['csvFile']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['error' => true, 'message' => 'No file uploaded or upload error']);
            break;
        }

        $result = $function->ImportAttendance($_FILES['csvFile']);
        echo json_encode($result);
        break;

    case "daily_summary":
        $start = $_GET['start_date'] ?? date('Y-m-01');
        $end = $_GET['end_date'] ?? date('Y-m-t');

        $sql = "SELECT 
                        date,
                        COUNT(*) AS total_employees,
                        SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) AS present_count,
                        SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) AS absent_count,
                        SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) AS late_count,
                        SUM(CASE WHEN status = 'half-day' THEN 1 ELSE 0 END) AS half_day_count,
                        CASE 
                            WHEN SUM(TIME_TO_SEC(time_out) - TIME_TO_SEC(time_in)) < 0 THEN '0:00:00'
                            ELSE SEC_TO_TIME(SUM(TIME_TO_SEC(time_out) - TIME_TO_SEC(time_in)))
                        END AS total_hours
                    FROM attendance
                    WHERE date BETWEEN :start AND :end
                    GROUP BY date
                    ORDER BY date";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':start' => $start, ':end' => $end]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
        break;

    case "employee_monthly":
        $start = $_GET['start_date'] ?? date('Y-m-01', strtotime('-6 months'));
        $end = $_GET['end_date'] ?? date('Y-m-t');
        $employee_id = $_GET['employee_id'] ?? null;

        $sql = "SELECT 
                        a.employee_id,
                        DATE_FORMAT(a.date, '%Y-%m-01') AS month_year,
                        COUNT(*) AS total_days,
                        SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) AS days_present,
                        SUM(CASE WHEN a.status = 'absent' THEN 1 ELSE 0 END) AS days_absent,
                        SUM(CASE WHEN a.status = 'late' THEN 1 ELSE 0 END) AS days_late,
                        SUM(CASE WHEN a.status = 'half-day' THEN 1 ELSE 0 END) AS days_half_day,
                        SUM(TIME_TO_SEC(TIMEDIFF(a.time_out, a.time_in)))/3600 AS total_working_hours
                    FROM attendance a";

        if ($employee_id) {
            $sql .= " WHERE a.employee_id = :employee_id";
            $params = [':employee_id' => $employee_id];
        } else {
            $sql .= " JOIN employees e ON a.employee_id = e.EmployeeID";
            $params = [];
        }

        $sql .= " AND a.date BETWEEN :start AND :end
                    GROUP BY a.employee_id, DATE_FORMAT(a.date, '%Y-%m-01')
                    ORDER BY month_year DESC";

        $params[':start'] = $start;
        $params[':end'] = $end;

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // If not filtering by employee, include names
        if (!$employee_id) {
            $sql = "SELECT EmployeeID, FirstName, LastName FROM employees";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $employeeMap = [];
            foreach ($employees as $emp) {
                $employeeMap[$emp['EmployeeID']] = $emp;
            }

            foreach ($results as &$row) {
                if (isset($employeeMap[$row['employee_id']])) {
                    $row['FirstName'] = $employeeMap[$row['employee_id']]['FirstName'];
                    $row['LastName'] = $employeeMap[$row['employee_id']]['LastName'];
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($results);
        break;

    case "employee_details":
        $employee_id = $_POST['employee_id'] ?? null;
        if (!$employee_id) {
            echo json_encode("Employee ID is required");
        }

        $start = $_POST['start_date'] ?? date('Y-m-01');
        $end = $_POST['end_date'] ?? date('Y-m-t');

        // Employee info
        $sql = "SELECT * FROM employees WHERE EmployeeID = :employee_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':employee_id' => $employee_id]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        // Attendance details
        $sql = "SELECT * FROM attendance 
                    WHERE employee_id = :employee_id 
                    AND date BETWEEN :start AND :end
                    ORDER BY date DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':employee_id' => $employee_id,
            ':start' => $start,
            ':end' => $end
        ]);
        $attendance = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Monthly summary
        $sql = "SELECT * FROM employee_monthly_summary
                    WHERE employee_id = :employee_id
                    ORDER BY month_year DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':employee_id' => $employee_id]);
        $monthly_summary = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'employee' => $employee,
            'attendance' => $attendance,
            'monthly_summary' => $monthly_summary
        ]);
        break;

        case "attendance_trends":
            $start = $_GET['start_date'] ?? date('Y-m-01', strtotime('-1 year'));
            $end = $_GET['end_date'] ?? date('Y-m-t');
            $period = $_GET['period'] ?? 'monthly'; // monthly, weekly, daily
            
            if ($period === 'monthly') {
                $group = "DATE_FORMAT(date, '%Y-%m-01')";
                $label = "DATE_FORMAT(date, '%b %Y')";
            } 
            elseif ($period === 'weekly') {
                $group = "YEARWEEK(date, 1)";
                $label = "CONCAT('Week ', WEEK(date, 1), ' ', YEAR(date))";
            } 
            else { // daily
                $group = "date";
                $label = "date";
            }
            
            $sql = "SELECT 
                        $group AS period,
                        $label AS label,
                        COUNT(*) AS total_records,
                        SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) AS present_count,
                        SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) AS absent_count,
                        SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) AS late_count,
                        SUM(CASE WHEN status = 'half-day' THEN 1 ELSE 0 END) AS half_day_count,
                        ROUND(SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) / COUNT(*) * 100, 2) AS attendance_rate
                    FROM attendance
                    WHERE date BETWEEN :start AND :end
                    GROUP BY period
                    ORDER BY period";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([':start' => $start, ':end' => $end]);
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            header('Content-Type: application/json');
            echo json_encode($results);
            break;

    default:
        return null;

}