<?php
namespace Admin\Tech\Includes\Class;

use PDO;
use PDOException;

class Permission
{
    public $conn;
    public $id;
    public $name;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getPermission()
    {
        try {
            $q = "SELECT * FROM permissions;";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function createPermission($name, $description)
    {
        try {
            $query = "INSERT INTO permissions (name, description) VALUES (?, ?)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$name,$description]);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function assignPermission($roleId, $permissionId)
    {
        $q = "INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($q);
        $stmt->execute([$roleId, $permissionId]);
    }

    public function userHasPermission($userId, $permissionName)
    {
        $q = "
            SELECT COUNT(*) FROM user_roles ur
            JOIN role_permissions rp ON ur.role_id = rp.role_id
            JOIN permissions p ON rp.permission_id = p.id
            WHERE ur.user_id = ? AND p.name = ?
        ";
        $stmt = $this->conn->prepare($q);
        $stmt->execute([$userId, $permissionName]);
        return $stmt->fetchColumn() > 0;
    }
}
