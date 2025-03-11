<?php
namespace Admin\Tech\Includes\Class;

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

    public function newRole($roleId, $description)
    {
        try {
            $q = "INSERT INTO roles (RoleName, Description) VALUES (?, ?)";
            $stmt = $this->conn->prepare($q);
            return $stmt->execute([$roleId, $description]);
        } catch (Exception $e) {
            echo "ERROR::::::::::: " . $e->getMessage();
        }
    }

    public function createRole()
    {
        $q = "";
    }
}
