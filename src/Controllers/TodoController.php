<?php

namespace App\Controllers;

use App\Repository\TodoRepository;

use function App\Utils\connection;
use App\Utils\UtilityFunctions;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

class TodoController{
    private $repository;
    private $body;

    public function __construct() {
        $this->repository = new TodoRepository(connection());
        $this->body = json_decode(file_get_contents('php://input'), true);
    }

    public function createTodo() {
        try {
            if(UtilityFunctions::fildsRequired(['user_id', 'title', 'description'], $this->body)){
                $this->repository->createTodo($this->body);
            }
        } catch (\Throwable $th) {
            echo json_encode(['message' => $th->getMessage()]);
        }
    }

    function getTodos() {
        try {
            if(!isset($_GET['id'])){
                echo json_encode(['message' => 'Missing id in query params']);
                return;
            }
            $id = $_GET['id'];
            $this->repository->getTodoByUserId($id);
        } catch (\Throwable $th) {
            echo json_encode(['message' => $th->getMessage()]);
        }
    }

    function updateTodo() {
        try {
            if(UtilityFunctions::fildsRequired(['id', 'title', 'description', 'is_complete',], $this->body)){
                $this->repository->updateTodo($this->body);
            }
        } catch (\Throwable $th) {
            echo json_encode(['message' => $th->getMessage()]);
        }
    }

    function deleteTodo() {
        try {
            if(UtilityFunctions::fildsRequired(['id'], $this->body)){
                $this->repository->deleteTodo($this->body['id']);
            }

        } catch (\Throwable $th) {
            echo json_encode(['message' => $th->getMessage()]);
        }
    }


}