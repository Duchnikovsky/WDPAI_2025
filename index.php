<?php
session_start();

require 'Routing.php';

$path = trim($_SERVER["REQUEST_URI"], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('index', 'DefaultController');
Routing::get('dashboard', 'DefaultController');
Routing::get('signup', 'DefaultController');
Routing::get('logout', 'DefaultController');
Routing::post("login", 'AuthController');
Routing::post("register", 'AuthController');
Routing::run($path);