<?php
require_once './app/core/Router.php';

use App\Core\Router;

$router = new Router();

// Register Routes
$router ->add('GET' , '/views/profile.php' , 'StudentController' , 'create');
$router->run();
?>