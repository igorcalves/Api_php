<?php
    namespace App\Utils;

    class UtilityFunctions{

        static function fildsRequired($requireds, $data){
            if(!$data){
                http_response_code(400);
                echo json_encode(['message' => 'Invalid JSON']);
                return false;
            }
    
            $erros = [];
            foreach($requireds as $require){
                if(!array_key_exists($require, $data)){
                    $erros[] = $require;
                }
            }
        
            if(count($erros) > 0){
                http_response_code(400);
                echo json_encode(['missing attributes'=> $erros]);
                return false;
            }
            return true;
        }

    }