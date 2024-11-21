<?php
namespace todoRepository;


class TodoRepository{
    private $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function createTodo($data){
        $requireds = ['user_id', 'title', 'description'];
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

        $stmt = $this->pdo->prepare("INSERT INTO TODO (title, description, user_id) values (?,?,?)");
        $stmt->bindValue(1, $data['title'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $data['description'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $data['user_id'], \PDO::PARAM_STR);


        try {
            $stmt-> execute();
            $todoId = $this->pdo->lastInsertId();
            $newStmt = $this->pdo->prepare("SELECT * FROM TODO WHERE id = ?");
            $newStmt->bindValue(1, $todoId, \PDO::PARAM_INT);

            $newStmt ->execute();
            $todo = $newStmt->fetch(\PDO::FETCH_ASSOC);
            http_response_code(200);

            echo json_encode($todo);


        } catch (\Throwable $e) {
            echo json_encode(['message' => $e->getMessage()]);
        }
    }

    function getTodoByUserId($data){
        if (!isset($data['user_id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'User_ID is required']);
            return;
        }


        $stmt = $this->pdo->prepare("SELECT * FROM TODO WHERE user_id = ?");

        $stmt->bindValue(1, $data['user_id'], \PDO::PARAM_STR);

        try {
            $stmt->execute();
            $users = $stmt->fetchAll();
            echo json_encode($users);
        } catch (\Throwable $e) {
            echo json_encode(['message' => $e->getMessage()]);
            
        }
    }

    function updateTodo($data){
        $requireds = ['id', 'title', 'description', 'is_complete',];
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

        $stmt = $this->pdo->prepare('UPDATE TODO SET title = ?, description = ?, is_complete = ? , updated_at = ? WHERE id = ?');

        $stmt->bindValue(1, $data['title'], \PDO::PARAM_STR);

        $stmt->bindValue(2, $data['description'], \PDO::PARAM_STR);

        $stmt->bindValue(3, $data['is_complete'], \PDO::PARAM_BOOL);


        $stmt->bindValue(4, date('Y-m-d H:i:s'), \PDO::PARAM_STR);
        $stmt->bindValue(5, $data['id'], \PDO::PARAM_INT);


        
        try {
            $stmt->execute();
            echo json_encode(['message' => 'User updated successfully']);
        } catch (\Throwable $e) {
            echo json_encode(['message' => $e->getMessage()]);

        }

    }

    function deleteTodo($data){
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'id is required']);
            return;
        }

        $stmt = $this->pdo->prepare('DELETE FROM TODO WHERE id = ?');
        $stmt->bindValue(1, $data['id'], \PDO::PARAM_INT);
        

        try {
            $stmt->execute();
            echo json_encode(['message' => 'TODO Deleted']);

        } catch (\Throwable $e) {
            echo json_encode(['message' => $e->getMessage()]);

        }

    }

}