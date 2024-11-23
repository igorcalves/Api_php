<?php
namespace App\Repository;


class AccountRepository{
    private $pdo;


    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function createAccountByUserId($userId){
        try {
            $stmt = $this->pdo->prepare('INSERT INTO account (amount, user_id) values (0 , ?)');
            $stmt->bindParam(1,$userId, \PDO::PARAM_INT);
            if($stmt->execute()){
                $accountID = $this->pdo->lastInsertId();
                $sql = $this->pdo->prepare("SELECT * FROM account WHERE id = ?;");
                $sql->bindParam(1,$accountID,\PDO::PARAM_INT);
                $sql->execute();
                $account = $sql->fetch();

                if($account){
                    http_response_code(200);
                    echo json_encode($account);
                }else{
                    http_response_code(200);
                    echo json_encode(['message'=> 'error while fetch for new account']);
                }
                
            }else{
                http_response_code(404);
                echo json_encode(['message' => 'error with execute']);
              }
            
        } catch (\Throwable $th) {
            http_response_code(404);
            echo json_encode(['message' => $th]);
        }

    }

    function getAllAccounts(){
        $sql = 'SELECT * FROM account;';
        try {
            $users = $this->pdo->query($sql)->fetchAll();
            http_response_code(200);
            echo json_encode($users);

        } catch (\Throwable $th) {
            http_response_code(400);
            echo json_encode(['message error ' => "error $th"]);
        }
    }

    function getAccountByUserId($userId){

        
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM account WHERE user_id = ?');
            $stmt->bindParam(1,$userId, \PDO::PARAM_INT);
           if($stmt->execute()){
            $user = $stmt->fetch();
                if($user){
                http_response_code(200);
                echo json_encode($user);
                }
                else{
                    http_response_code(404);
                    echo json_encode(['message' => 'user not found']);
                  }
           }
           else{
            http_response_code(404);
            echo json_encode(['message' => 'error with execute']);
          }
          
        } catch (\Throwable $th) {
            echo json_encode(['message error ' => $th->getMessage()]);
        }
    }
}