<?php

function count_col($conn, $table)
{
    $q = "SELECT count(*) FROM  {$table} LIMIT 1";
    $stmt = $conn->prepare($q);
    $stmt->execute();
    $result = $stmt->fetchColumn();
    return $result;
}

?>