<?php
$dsn  = "mysql:host=localhost;dbname=mini_crm;charset=utf8";
$user = "root";
$pass = "";

try {
    $pdo = new PDO($dsn, $user, $pass);
    // echo "Connected!";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>