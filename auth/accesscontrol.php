<?php
session_start();


if (!isset($_SESSION['usertype']) || !isset($_SESSION['user_id'])) {
    header("Location: ../");
    exit();
}

function getUserRoleAndPermissions($user_id, $conn)
{
    $stmt = $conn->prepare("SELECT usertype FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return null;
    }

    $role = $user['usertype'];

    $stmt = $conn->prepare("
        SELECT p.name 
        FROM permissions p 
        JOIN role_permissions rp ON p.id = rp.permission_id 
        JOIN roles r ON rp.role_id = r.RoleID 
        WHERE r.RoleName = ?
    ");
    $stmt->execute([$role]);

    $permissions = $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];

    return ['role' => $role, 'permissions' => $permissions];
}

function hasPermission($permission)
{
    global $permissions;
    return in_array($permission, $permissions);
}


function access_log($userData)
{
    echo "<script>console.log('@@@@@@@@@@@@@@@@ ACCESS CONTROL @@@@@@@@@@@@@@@@')</script>";
    echo "<script>console.log('Role: " . $userData['role'] . "')</script>";
    foreach ($userData['permissions'] as $value) {
        echo "<script>console.log('Permission: " . $value . "')</script>";
    }
    echo "<script>console.log('@@@@@@@@@@@@@@@@ ACCESS CONTROL @@@@@@@@@@@@@@@@')</script>";

}