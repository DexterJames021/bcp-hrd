<?php 
//todo: 0 when deployed
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
// error_reporting(E_ALL);


define("host","localhost");
define("db","bcp-hrd");
define("port","8080");
define("user","root");
define("pass","");
define("dns","mysql:host=".host.";dbname=".db);

try{
    $conn = new PDO(dns,user,pass);
}catch(PDOException $e){
    echo "DATABASE ERROR: ". $e->getMessage();
}
