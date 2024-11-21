<?php

namespace App\Repository;

use function App\Utils\connection;

class UserRepository {
    
    private $pdo;

    function __construct() {
        // connection();
        // $this->pdo = connection();
        // echo var_dump(connection());
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

    function createUser($data){
        $requireds = ['name', 'birthday', 'email', 'role'];
        $erros = [];
        foreach($requireds as $require){
            if(!array_key_exists($require, $data)){
                $erros[] = $require;
            }
        }
    
        if(count($erros) > 0){
            http_response_code(400);
            echo json_encode(['missing attributes'=> $erros]);
            return;
        }
    
        $stmt = $this->pdo->prepare("INSERT INTO users (name, birthday, email, role) VALUES (?, ?, ?, ?)");
    
        $stmt->bindValue(1, $data['name'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $data['birthday'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $data['email'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $data['role'], \PDO::PARAM_STR);
    

        try {
            $stmt->execute();
            echo json_encode(['message' => 'User created successfully']);
        } catch (\Throwable $e) {
            if (strpos($e->getMessage(), '1062') !== false) {
                http_response_code(500);
                echo json_encode(['message' => 'duplicate key constraint \'email\' ']);
                return;
            }
            echo json_encode(['message' => $e->getMessage()]);

        }
        }
    
    

    function getUsers() {
        try {
             $sql = "SELECT * FROM users";
            $users = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
            http_response_code(200);
            echo json_encode($users);
         } catch (\Throwable $th) {
            echo json_encode(['error in get' => $th]);
         }
    }

    function getUserById($data){
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'User ID is required']);
            return;
        }

        $stmt = $this->pdo->prepare("SELECT * FROM users u WHERE u.id = ?");

        try {
            $stmt->bindParam(1, $data['id'], \PDO::PARAM_INT);
        
            if ($stmt->execute()) {
                $user = $stmt->fetch(); 
        
                if ($user) {
                    http_response_code(200);
                    echo json_encode($user);
                } else {
                    http_response_code(404);
                    echo json_encode(['message' => 'User not found']);
                }
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to execute query']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
        }
    }

    function updateUser($data) {
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'User ID is required']);
            return;
        }

        $stmt = $this->pdo->prepare("UPDATE users SET name = :name, email = :email, birthday = :birthday, role = :role WHERE id = :id");

        try {
            $stmt->execute([
                ':id' => $data['id'],
                ':name' => $data['name'],
                ':email' => $data['email'],
                ':birthday' => $data['birthday'],
                ':role' => $data['role']
            ]);
        } catch (\Throwable $th) {
            echo json_encode(['error in update' => $th->getMessage()]);
            
        }

        if ($stmt->rowCount() > 0) {
            echo json_encode(['message' => 'User updated successfully']);
        } else {
            echo json_encode(['message' => 'No user found with the given ID or no changes made']);
        }
    }

    function deleteUser($data ){
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'User ID is required']);
            return;
        }
        $stmt = $this->pdo->prepare("DELETE FROM users where id = :id");
        try {
            $stmt->bindParam(':id', $data['id'], \PDO::PARAM_INT);
            
            $stmt->execute();
            http_response_code(204);
        } catch (\Throwable $th) {
            echo json_encode(['error' => $th->getMessage()]);
            
        }

    }
}