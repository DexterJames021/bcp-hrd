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


}
