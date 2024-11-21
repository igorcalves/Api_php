<?php
namespace App\Controllers;
use App\Repository\UserRepository; 


header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

class UserController {
    
    private $repository;

    public function __construct() {
        $this->repository = new UserRepository();
    }

    function getUsers() {
        // echo json_encode(['message' => 'User created successfully']);
        $this->repository->getUsers();  
    }
}