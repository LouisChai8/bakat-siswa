<?php
// Gunakan __DIR__ dan .. untuk naik satu folder
require_once __DIR__ . '/../app/core/Router.php';

use App\Core\Router;

$router = new Router();

// Register Routes
// Note: Route biasanya mengarah ke URL, bukan langsung ke path file
$router->add('GET', '/profile', 'StudentController', 'create');

$router->run();