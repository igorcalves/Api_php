<?php
namespace App\Controllers;
use App\Repository\UserRepository; 
use App\Utils\UtilityFunctions;

use function App\Utils\connection;

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

class UserController {
    
    private $repository;



    public function __construct() {
        $this->repository = new UserRepository(connection());
    }

    function getUsers() {
        $this->repository->getUsers();  
    }

    function getUserById(){
     try {
        if(!isset($_GET['id'])){
            echo json_encode(['message' => 'Missing id']);
            return;
        }
        $id = $_GET['id'];
        $this->repository->getUserById($id);
     } catch (\Throwable $e) {
        echo json_encode(['message' => $e->getMessage()]);
     }
    }

    function createUser(){
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (UtilityFunctions::fildsRequired(['name', 'birthday', 'email', 'role'], $data)){
                $this->repository->createUser($data);
            }
        } catch (\Throwable $e) {
            echo json_encode(['message' => $e->getMessage()]);
        }
    }

    function updateUser(){
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (UtilityFunctions::fildsRequired(['id', 'name', 'birthday', 'email', 'role'], $data)){
                $this->repository->updateUser($data);
            }
        } catch (\Throwable $e) {
            echo json_encode(['message' => $e->getMessage()]);
        }
    }

    function deleteUser(){
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (UtilityFunctions::fildsRequired(['id'], $data)){
                $this->repository->deleteUser($data);
            }
        } catch (\Throwable $e) {
            echo json_encode(['message' => $e->getMessage()]);
        }
    }

    
}