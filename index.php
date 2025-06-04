<?php
session_start();

require 'Routing.php';

$path = trim($_SERVER["REQUEST_URI"], '/');
$path = parse_url($path, PHP_URL_PATH);

//Pages routes
Routing::get('index', 'DefaultController');
Routing::get('dashboard', 'DefaultController');
Routing::get('signup', 'DefaultController');
Routing::get('categories', 'DefaultController');
Routing::get('bestsellers', 'DefaultController');
Routing::get('management', 'DefaultController');

//API routes
Routing::get('logout', 'DefaultController');
Routing::post("login", 'AuthController');
Routing::post("register", 'AuthController');
Routing::post('books', 'BookController');
Routing::post("addBook", 'BookController');
Routing::post("addCategory", 'CategoryController');
Routing::post("generateCodes", 'AuthController');

Routing::run($path);
