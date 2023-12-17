<?php
//Open a new connection to the DB
$error = false;
$host = "localhost";
$db = "proyecto";
$user = "tema3";
$pass = "123456";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
try{
    $conexProyecto = new PDO($dsn, $user, $pass);
    $conexProyecto->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Error: ".$e->getMessage());
}
