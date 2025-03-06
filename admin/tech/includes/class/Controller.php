<?php 
namespace Admin\Tech\Includes\Class;

class Controller{
    // super();
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }
}

?>