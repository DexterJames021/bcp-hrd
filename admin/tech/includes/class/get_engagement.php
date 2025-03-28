<?php
include_once("../../../../config/Database.php");

try {

    // Attendance: line chart
    $login_data = [];
    $sql = "SELECT DATE_FORMAT(login_date, '%Y-%m-%d') as login_day, COUNT(*) as total_logins
        FROM attendanceleave 
        WHERE status = 'Present'
        GROUP BY login_day 
        ORDER BY login_day ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $login_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Performance evaluations: pie chart
    $evaluation_data = [];
    $sql = "SELECT EvaluationType as evaluation_type, COUNT(*) as total_evaluations
            FROM performanceevaluations
            GROUP BY EvaluationType";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $evaluation_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['logins' => $login_data, 'evaluations' => $evaluation_data]);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    // Close the PDO connection
    $conn = null;
}
