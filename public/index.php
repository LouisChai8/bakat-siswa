<?php
require_once __DIR__ . '/../app/core/Router.php';

use App\Core\Router;

$router = new Router();

$router->add('GET', '/profile', 'AuthController', 'profile');
$router->add('GET', '/login', 'AuthController', 'LoginView');
$router->add('GET', '/register', 'AuthController', 'registerView');
$router->add('GET', '/home', 'HomeController', 'home');

$router->run();