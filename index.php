<?php 

require_once './vendor/autoload.php';
require_once './src/Http/Route.php';
require_once './src/routes/main.php';
require_once './src/Utils/Database.php';

use App\Core\Core;
use App\Http\Route;





ini_set('display_errors', 1);
error_reporting(E_ALL);


Core::dispatch(Route::getRoutes());

