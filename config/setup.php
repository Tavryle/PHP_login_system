<?php
session_start();
set_include_path("../");
require('config/creds.php');

try{
    $conn = new PDO("mysql:host=$host", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS hypertube";
    $conn->exec($sql);
    echo "database created";
}catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
}

$db_name = 'hypertube';

try{
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS users (`id` INT(6) AUTO_INCREMENT,`profile` VARCHAR(100) ,`Username` VARCHAR(30) NOT NULL,`Firstname` VARCHAR(30) NOT NULL,`Lastname` VARCHAR(30) NOT NULL,`Email` VARCHAR(30) NOT NULL,`Password` VARCHAR(15) NOT NULL,`Token` VARCHAR(50) NOT NULL, `Verify` INT(6) NOT NULL, PRIMARY KEY (id))";
        $conn->exec($sql);
    echo "<br> table created";
}catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
}
?>