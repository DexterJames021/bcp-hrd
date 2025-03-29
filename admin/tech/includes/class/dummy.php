<?php

namespace Admin\Tech\Includes\Class;

use PDO;
use PDOException;

include_once "../../../../config/Database.php";

class Dummy
{

    private $conn;

    /**
     * Class constructor.
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function Engagement()
    {
        try {

            // Attendance: line chart
            $login_data = [];
            $sql = "SELECT DATE_FORMAT(login_date, '%Y-%m-%d') as login_day, COUNT(*) as total_logins
            FROM attendanceleave 
            WHERE status = 'Present'
            GROUP BY login_day 
            ORDER BY login_day ASC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $login_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Performance evaluations: pie chart
            $evaluation_data = [];
            $sql = "SELECT EvaluationType as evaluation_type, COUNT(*) as total_evaluations
                FROM performanceevaluations
                GROUP BY EvaluationType";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $evaluation_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(['logins' => $login_data, 'evaluations' => $evaluation_data]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            // Close the PDO this->connection
            $this->conn = null;
        }
    }

    public function talent()
    {

        $response = [];

        // Pie Chart: Workforce Composition by Job Role
        $sql = "SELECT COUNT(e.EmployeeID) AS total_employees
                FROM employees e
                JOIN jobroles jr ON e.JobRoleID = jr.JobRoleID
                GROUP BY e.JobRoleID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $response['pie_chart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Line Chart: Talent Development Over Time (Tasks Completed)
        $sql = "SELECT DATE(t.CreatedDate) AS task_date, COUNT(*) AS tasks_completed
                FROM tasks t
                WHERE t.Status = 'Completed'
                GROUP BY DATE(t.CreatedDate)
                ORDER BY task_date ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $response['line_chart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Bar Chart: Attrition Rates by Department
        $sql = "SELECT d.DepartmentName AS department_name, 
                       SUM(CASE WHEN e.Status = 'Inactive' THEN 1 ELSE 0 END) AS attrition_count,
                       COUNT(e.EmployeeID) AS total_employees
                FROM employees e
                JOIN departments d ON e.DepartmentID = d.DepartmentID
                GROUP BY e.DepartmentID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $response['bar_chart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return JSON response
        echo json_encode($response);
        $this->conn = null;
    }

    public function task()
    {
        if (isset($_GET['task_id'])) {
            $taskId = $_GET['task_id'];

            // Prepare the SQL query using PDO
            $query = "SELECT * FROM tasks WHERE TaskID = :taskId";
            $stmt = $this->conn->prepare($query);

            // Bind the parameter using PDO
            $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();

            // Fetch the result
            $task = $stmt->fetch();

            if ($task) {
                // Return the task details as JSON
                echo json_encode(['success' => true, 'task' => $task]);
            } else {
                // If no task found, return an error message
                echo json_encode(['success' => false, 'message' => 'Task not found']);
            }
        }
    }

    public function workforce()
    {

        $response = [];

        // Stacked Bar Chart: Workload Distribution
        $sql = "SELECT CONCAT(e.FirstName, ' ', e.LastName) AS employee_name, t.Title AS task_name, COUNT(*) AS total_tasks 
        FROM employees e
        JOIN tasks t ON e.UserID = t.UserID
        GROUP BY e.EmployeeID, t.TaskID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $response['stacked_bar_chart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Bubble Chart: Workload and Productivity (assuming Status impacts workload)
        $sql = "SELECT CONCAT(e.FirstName, ' ', e.LastName) AS employee_name, COUNT(t.TaskID) AS workload, 
               SUM(CASE WHEN t.Status = 'Completed' THEN 1 ELSE 0 END) AS productivity
        FROM employees e
        JOIN tasks t ON e.UserID = t.UserID
        GROUP BY e.EmployeeID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $response['bubble_chart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Org Chart: Team Structure
        $sql = "SELECT CONCAT(e.FirstName, ' ', e.LastName) AS employee_name, CONCAT(m.FirstName, ' ', m.LastName) AS manager_name, 
               t.Title AS task_name
        FROM employees e
        LEFT JOIN employees m ON e.ManagerID = m.EmployeeID
        LEFT JOIN tasks t ON e.UserID = t.UserID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $response['org_chart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Send JSON response
        echo json_encode($response);
        $this->conn = null;
    }

    public function efficiency()
    {

        $response = [];

        // Bar Chart: Time Spent on Tasks
        $sql = "SELECT Title, SUM(CreatedDate) as total_time 
        FROM tasks
        GROUP BY Title";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $response['bar_chart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Histogram: Time Distribution Across Tasks
        $sql = "SELECT Title, CreatedDate 
        FROM tasks";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $response['histogram'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Gantt Chart: Task Timelines
        $sql = "SELECT Title, CreatedDate 
        FROM tasks";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $response['gantt_chart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Send JSON response
        echo json_encode($response);
        $this->conn = null;
    }

    public function performance()
    {

        $data = [];

        // Bar Chart: Count of Evaluations per Employee
        $sql = "SELECT EmployeeID, COUNT(*) as total_evaluations 
        FROM performanceevaluations 
        GROUP BY EmployeeID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $data['bar_chart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Radar Chart: Average Scores per Metric
        $sql = "SELECT 
            EmployeeID, 
            AVG(Score) as avg_score 
        FROM performanceevaluations 
        GROUP BY EmployeeID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $data['radar_chart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Scatter Plot: Evaluation Type vs Evaluation Score
        $sql = "SELECT  EvaluationType , Score 
        FROM performanceevaluations";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $data['scatter_plot'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Send JSON response
        echo json_encode($data);
        $this->conn = null; // Close the connection
    }

    public function retention()
    {

        $data = [];

        // Line Chart: Retention Trends (Attendance Over Time)
        $sql = "SELECT DATE(login_date) as date, COUNT(*) as total_attendance 
        FROM attendanceleave 
        WHERE status = 'Present' 
        GROUP BY DATE(login_date)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $data['line_chart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cohort Analysis: Retention by Evaluation Date
        $sql = "SELECT DATE(EvaluationDate) as cohort_date, COUNT(*) as total_users 
        FROM performanceevaluations 
        GROUP BY DATE(EvaluationDate)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $data['cohort_analysis'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Funnel Chart: Retention Stages (Simulated Stages)
        $sql = "SELECT 
            'Signups' as stage, COUNT(*) as total FROM performanceevaluations
        UNION ALL
        SELECT 
            'Attendance' as stage, COUNT(*) as total FROM attendanceleave WHERE status = 'Present'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $data['funnel_chart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Send JSON response
        echo json_encode($data);
        $this->conn = null;
    }

    public function turnover()
    {

        $start_date = $_GET['start_date'] ?? '2024-01-01'; // Default to a start date if not provided
        $end_date = $_GET['end_date'] ?? date('Y-m-d');    // Default to today's date if not provided

        try {
            // Query: Count employees who left within the date range
            $sql_left = "
        SELECT d.DepartmentID, d.DepartmentName, COUNT(e.EmployeeID) AS left_employees
        FROM employees e
        JOIN departments d ON e.DepartmentID = d.DepartmentID
        WHERE e.Status = 'Inactive' AND e.HireDate BETWEEN :start_date AND :end_date
        GROUP BY d.DepartmentID, d.DepartmentName";
            $stmt_left = $this->conn->prepare($sql_left);
            $stmt_left->execute([
                'start_date' => $start_date,
                'end_date' => $end_date
            ]);
            $left_data = $stmt_left->fetchAll(PDO::FETCH_ASSOC);

            // Transform left data into an associative array for easier lookup
            $turnover_data = [];
            foreach ($left_data as $row) {
                $turnover_data[$row['DepartmentID']] = [
                    'DepartmentName' => $row['DepartmentName'],
                    'LeftEmployees' => $row['left_employees'],
                    'AvgEmployees' => 0, // Default value
                    'TurnoverRate' => 0  // Default value
                ];
            }

            // Query: Calculate average employees in each department
            $sql_avg = "
    SELECT d.DepartmentID, d.DepartmentName, COUNT(e.EmployeeID) AS avg_employees
    FROM employees e
    JOIN departments d ON e.DepartmentID = d.DepartmentID
    WHERE e.HireDate <= :end_date
    GROUP BY d.DepartmentID, d.DepartmentName";
            $stmt_avg = $this->conn->prepare($sql_avg);
            $stmt_avg->execute(['end_date' => $end_date]);
            $avg_data = $stmt_avg->fetchAll(PDO::FETCH_ASSOC);


            // Update turnover data with average employees and calculate turnover rate
            foreach ($avg_data as $row) {
                $dept_id = $row['DepartmentID'];
                if (isset($turnover_data[$dept_id])) {
                    $turnover_data[$dept_id]['AvgEmployees'] = $row['avg_employees'];
                    if ($row['avg_employees'] > 0) {
                        $turnover_data[$dept_id]['TurnoverRate'] = round(
                            ($turnover_data[$dept_id]['LeftEmployees'] / $row['avg_employees']) * 100,
                            2
                        );
                    }
                }
            }

            // Output JSON
            echo json_encode(array_values($turnover_data)); // Convert to indexed array for JSON
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
