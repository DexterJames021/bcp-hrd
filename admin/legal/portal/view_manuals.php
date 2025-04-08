<?php
include 'db_connection.php';

$result = $conn->query("SELECT * FROM employees_manual ORDER BY uploaded_at DESC");

echo "<h2>Employee's Manual</h2>";
echo "<table border='1'>";
echo "<tr><th>Title</th><th>Download</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
    echo "<td><a href='" . $row['file_path'] . "' download>Download PDF</a></td>";
    echo "</tr>";
}

echo "</table>";
?>