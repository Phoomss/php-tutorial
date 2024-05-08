<?php
$serverName = "localhost";
$userName  = "root";
$password = "";

try {
    $connect = new PDO("mysql:host=$serverName;dbname=workshop_pdo;charset=utf8", $userName, $password);
    // set the PDO error mode to exception
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "connected successfully";
} catch (PDOException $e) {
    echo "connection failed:" . $e->getMessage();
}
