<?php 
// display debug err
ini_set('display_errors', 1);
error_reporting(E_ALL);

define("host","localhost");
define("db","bcp-hrd");
define("user","root");
define("pass","");
define("dns","mysql:host=".host.";dbname=".db);

try{
    $conn = new PDO(dns,user,pass);
}catch(PDOException $e){
    echo "DATABASE ERROR: ". $e->getMessage();
}
