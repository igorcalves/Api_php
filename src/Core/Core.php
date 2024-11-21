<?php

namespace App\Core;

require_once './vendor/autoload.php';

class Core{

  
  public static function dispatch(array $routes){
    $url = $_SERVER['REQUEST_URI'];

    if (preg_match('/^\/api(\/.*)?/', $url, $matches)) {
        $url = isset($matches[1]) ? $matches[1] : '/';
    }

    foreach($routes as $route){
      if($route['method'] == $_SERVER['REQUEST_METHOD'] && $route['path'] == $url){
        $action = explode('@', $route['action']);
        $controller = 'App\\Controllers\\' . $action[0];
        $method = $action[1];
         $controller = new $controller();
         $controller->$method();
        return;
      }
    }

    // Se nenhuma rota for encontrada, exibe uma mensagem de erro
    echo "Rota não encontrada: $url";
  }
}