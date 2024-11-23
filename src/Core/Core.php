<?php

namespace App\Core;


class Core{

  
  public static function dispatch(array $routes){
    $url = $_SERVER['REQUEST_URI'];

    if (preg_match('/^\/api(\/.*)?/', $url, $matches)) {
      $url = isset($matches[1]) ? $matches[1] : '/';
      
      $parsedUrl = parse_url($url);
      $url = isset($parsedUrl['path']) ? $parsedUrl['path'] : '/';
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

    echo "Rota não encontrada: $url";
  }
}