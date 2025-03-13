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
}
