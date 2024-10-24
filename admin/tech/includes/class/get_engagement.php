<?php

// Fetch login data for the line chart
$login_data = [];
$sql = "SELECT DATE(login_date) as login_day, COUNT(*) as total_logins
        FROM attendanceleave WHERE status = 'Present'
        GROUP BY login_day ORDER BY login_day ASC";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $login_data[] = $row;
    }
}

// Fetch performance evaluations data for the pie chart
$evaluation_data = [];
$sql = "SELECT evaluation_type, COUNT(*) as total_evaluations
        FROM performanceevaluations
        GROUP BY evaluation_type";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $evaluation_data[] = $row;
    }
}

// Return data as JSON
echo json_encode(['logins' => $login_data, 'evaluations' => $evaluation_data]);

$conn->close();
