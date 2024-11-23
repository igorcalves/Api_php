<?php
namespace App\Utils;

function connection() {
    $dsn = "mysql:host=localhost;dbname=api_interview";
    $username = 'root'; 
    $password = 'password'; 

    try {
        $pdo = new \PDO($dsn, $username, $password);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        return $pdo;
    } catch (\PDOException $e) {
        return "Connection failed: " . $e->getMessage();
    }
}
