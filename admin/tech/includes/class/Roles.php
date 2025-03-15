<?php
namespace Admin\Tech\Includes\Class;

use PDO;
use PDOException;

class Roles
{

    public $conn;
    public $table = 'roles';
    public $id;
    public $name;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createRole($roleId, $description)
    {
        try {
            $q = "INSERT INTO roles (RoleName, Description) VALUES (?, ?)";
            $stmt = $this->conn->prepare($q);
            return $stmt->execute([$roleId, $description]);
        } catch (Exception $e) {
            echo "ERROR::::::::::: " . $e->getMessage();
        }
    }

    public function get_roles()
    {
        try {
            $q = "SELECT * FROM roles;";
            $stmt = $this->conn->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
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

    public function deleteRolesPermission($id)
    {
        try {
            $q = "DELETE FROM roles_permissions WHERE id=:id";
            $stmt = $this->conn->prepare($q);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function assignPermissions($role_id, $permissions)
    {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("SELECT permission_id FROM role_permissions WHERE role_id = ?");
            $stmt->execute([$role_id]);
            $existingPermissions = $stmt->fetchAll(PDO::FETCH_COLUMN); // Get current permissions as an array

            // ✅ Insert only if the permission is not already assigned
            $stmt = $this->conn->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)");
            foreach ($permissions as $permission_id) {
                if (!in_array($permission_id, $existingPermissions)) {
                    $stmt->execute([$role_id, (int) $permission_id]);
                }
            }

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return $e->getMessage();
        }
    }

    public function editRolePermission($role_id, $permissions)
    {
        try {
            $this->conn->beginTransaction();

            // Fetch existing permissions for the role
            $stmt = $this->conn->prepare("SELECT permission_id FROM role_permissions WHERE role_id = ?");
            $stmt->execute([$role_id]);
            $existingPermissions = $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch as array

            // Insert new permissions if not already assigned
            $stmtInsert = $this->conn->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)");
            foreach ($permissions as $permission_id) {
                if (!in_array($permission_id, $existingPermissions)) {
                    $stmtInsert->execute([$role_id, (int) $permission_id]); // Insert new permission
                }
            }

            // Remove unchecked permissions
            $stmtDelete = $this->conn->prepare("DELETE FROM role_permissions WHERE role_id = ? AND permission_id = ?");
            foreach ($existingPermissions as $permission_id) {
                if (!in_array($permission_id, $permissions)) {
                    $stmtDelete->execute([$role_id, (int) $permission_id]); // Remove permission
                }
            }

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return $e->getMessage();
        }
    }



}
