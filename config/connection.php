<?php
set_include_path("../");
require('config/creds.php');
$db_name = 'hypertube';
try{
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass);
}catch (PDOException $e){
    echo $e->getMessage();
}