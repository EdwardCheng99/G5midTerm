<?php

$servername = "localhost";
$username = "admin";
$password = "";
$dbname = "my_test_db";

try{
    $dbHost = new PDO(
        "mysql:host={$servername};dbname={$dbname};charset=utf8",
        $username, $password
    );
    // echo "連線成功";
}catch(PDOException $e){
    echo "資料庫連線失敗";
    echo "error: ".$e->getMessage();
};