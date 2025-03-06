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

    public function assignRole($userId, $roleId)
    {
        try {
            $q = "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)";
            $stmt = $this->conn->prepare($q);
            return $stmt->execute([$userId, $roleId]);
        } catch (Exception $e) {
            echo "ERROR::::::::::: " . $e->getMessage();
        }
    }

    public function createRole()
    {
        $q = "";
    }
}
