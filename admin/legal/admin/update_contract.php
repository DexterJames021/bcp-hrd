<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contract_id = $_POST['contract_id'];
    $action = $_POST['action'];
    $status = '';

    if ($action == 'Approve') {
        $status = 'Approved';
    } elseif ($action == 'Reject') {
        $status = 'Rejected';
    }

    $query = "UPDATE contracts SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $status, $contract_id);

    if ($stmt->execute()) {
        header('Location: contracts.php');
        exit();
    } else {
        echo "Error updating status: " . $conn->error;
    }
}
?>