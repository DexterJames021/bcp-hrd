<?php 
//todo: 0 when deployed
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


define("DB_HOST","localhost");
define("DB_NAME","bcp-hrd");
define("DB_PORT","8080");
define("DB_USER","root");
define("DB_PASS","");
define("dns","mysql:host=".DB_HOST.";dbname=".DB_NAME);

// DEPLOY CONFIGURATION
// define("DB_HOST", "localhost");
// define("DB_NAME", "!u114085275_bcphrd");
// define("DB_USER", "!u114085275_admin");
// define("DB_PASS", "!7ooiO?kJ");
// define("DB_PORT", "3306"); 
// define("dns","mysql:host=".DB_HOST.";dbname=".DB_NAME);

try{
    $conn = new PDO(dns,DB_USER,DB_PASS);
}catch(PDOException $e){
    echo "DATABASE ERROR: ". $e->getMessage();
}
