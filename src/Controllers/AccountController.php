<?php

namespace App\Controllers;

use App\Repositories\AccountRepository;
use App\Utils\connection;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

class AccountController {
    
    private $repository;
    private $pathRoute;
    private $method;
    private $body;

    public function __construct() {
        $this->repository = new AccountRepository();
        $this->pathRoute = isset($_GET['route']) ? trim($_GET['route']) : null;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->body = json_decode(file_get_contents('php://input'), true);
    }

    public function handleRequest() {
        if ($this->method === 'OPTIONS') {
            http_response_code(200); 
            exit; 
        }

        switch($this->pathRoute){
            case 'getAllAccounts':
                $this->getAllAccounts();
                break;
            case 'getAccountByUSerId':
                $this->getAccountByUSerId();
                break;
            case 'createAccountByUserId':
                $this->createAccountByUserId();
                break;
            default:
                http_response_code(404);
                echo json_encode(["message" => "Route Not Allowed for $this->pathRoute" ]);
                break;
        }
    }    

    private function isValidMethod($validMethod) {
        if ($this->method !== $validMethod) {
            http_response_code(405);
            echo json_encode(["message" => "Method Not Allowed"]);
            return false;
        }
        return true;
    }

    function getAllAccounts() {
        if ($this->isValidMethod('GET')) {
            $this->repository->getAllAccount();
        }
    }

    function getAccountByUSerId() {
        if ($this->isValidMethod('GET')) {
            $this->repository->getAccountByUSerId($this->body);
        }
    }

    function createAccountByUserId() {
        if ($this->isValidMethod('POST')) {
            $this->repository->createAccountByUserId($this->body);
        }
    }
}

$controller = new AccountController();
$controller->handleRequest();