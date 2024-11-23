<?php

namespace App\Controllers;

use App\Repository\TodoRepository;

use function App\Utils\connection;


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


}