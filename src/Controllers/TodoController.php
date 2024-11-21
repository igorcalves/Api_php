<?php

require_once('./repositories/todo_repository.php');
require_once('./db.php'); 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

class TodoController{
    private $repository;
    private $pathRoute;
    private $method;
    private $body;

    public function __construct() {
        $this->repository = new \todoRepository\TodoRepository(\db\connection());
        $this->pathRoute = isset($_GET['route']) ? trim($_GET['route']): null;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->body = json_decode(file_get_contents('php://input'), true);

    }

    private function  isValidMethod($validMethod){
        if($this->method !== $validMethod){
            http_response_code(405);
            echo json_encode(["message" => "Method Not Allowed"]);
            return false;
        }
        return true;
    }

    public function handleRequest() {
        if ($this->method === 'OPTIONS') {
            http_response_code(200); 
            exit; 
        }

            switch($this->pathRoute) {
                case 'createTodo':
                   $this->createTodo();
                   break;
                case 'getTodoByUser':
                    $this->getTodoByUser();
                    break;
                case 'updateTodo':
                    $this->updateTodo();
                    break;
                case 'deleteTodo':
                    $this->deleteTodo();
                    break;
    
                default:
                    http_response_code(404);
                    echo json_encode(["message" => "Route Not Allowed for $this->pathRoute" ]);
                    break;
                } 
    }

    function createTodo(){
        if($this->isValidMethod('POST')){
            echo $this->repository->createTodo($this->body);
        }
    }

    function getTodoByUser(){
        if($this->isValidMethod('POST')){
            echo $this->repository->getTodoByUserId($this->body);
        }
    }

    function updateTodo(){
        if($this->isValidMethod('PUT')){
            echo $this->repository->updateTodo($this->body);
        }
    }

    function deleteTodo(){
        if($this->isValidMethod('DELETE')){
            echo $this->repository->deleteTodo($this->body);
        }
    }


}

$todoController = new TodoController();
$todoController->handleRequest();
