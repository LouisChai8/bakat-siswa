<?php
require_once __DIR__ . '/../app/core/Router.php';

use App\Core\Router;

$router = new Router();

// ── Auth page routes ──
$router->add('GET',  '/login',    'AuthController', 'LoginView');
$router->add('POST', '/login',    'AuthController', 'login');
$router->add('GET',  '/register', 'AuthController', 'registerView');
$router->add('POST', '/register', 'AuthController', 'register');
$router->add('GET',  '/logout',   'AuthController', 'logout');

// ── App page routes ──
$router->add('GET', '/profile',     'AuthController', 'profile');
$router->add('GET', '/home',        'HomeController', 'home');
$router->add('GET', '/editprofile', 'AuthController', 'editProfile');
$router->add('GET', '/addpost',     'HomeController', 'addPost');

// ── Comment API routes ──
$router->add('GET',    '/comments',      'CommentController', 'index');
$router->add('POST',   '/comments',      'CommentController', 'store');
$router->add('DELETE', '/comments/{id}', 'CommentController', 'destroy');

// ── Post API routes ──
$router->add('POST', '/posts',      'PostController', 'store');
$router->add('PUT',  '/posts/{id}', 'PostController', 'update');

$router->run();