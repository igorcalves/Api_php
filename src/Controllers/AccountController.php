<?php

namespace App\Controllers;


use App\Repository\AccountRepository;
use App\Utils\UtilityFunctions;
use function App\Utils\connection;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

class AccountController {
    
    private $repository;
    private $body;

    public function __construct() {
        $this->repository = new AccountRepository(connection());
        $this->body = json_decode(file_get_contents('php://input'), true);
    }

    public function createAccount() {
        try {
            if(UtilityFunctions::fildsRequired(['user_id'], $this->body)){
                $this->repository->createAccountByUserId($this->body['user_id']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['message' => $th->getMessage()]);
        }
    }

    function getAllAccounts() {
        try {
            $this->repository->getAllAccounts();
        } catch (\Throwable $th) {
            echo json_encode(['message' => $th->getMessage()]);
        }
    }

    function getAccountByUserId() {
        try {
            if(!isset($_GET['user_id'])){
                echo json_encode(['message' => 'Missing user_id in query params']);
                return;
            }
            $userId = $_GET['user_id'];
            $this->repository->getAccountByUserId($userId);
        } catch (\Throwable $th) {
            echo json_encode(['message' => $th->getMessage()]);
        }
    }




}

