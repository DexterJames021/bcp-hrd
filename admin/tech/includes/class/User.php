<?php
namespace Admin\Tech\Includes\Class;

use PDO;
use PDOException;

class User
{
    private $conn;
    private $table = "users";
    public $id;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getId($id){
        $this->id = $id;
    }

    public function profile_select_one($id){
        try{
            $q = "SELECT * FROM {$this->table} WHERE id= :id LIMIT 1";
            $stmt = $this->conn->prepare($q);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function profile_update(){
        try{
            $q = "UPDATE {$this->table} SET ";

        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
}