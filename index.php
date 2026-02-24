<?php

require_once 'config/config.php';
require_once 'controllers/MovieController.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

// ----------- ROUTES API -----------
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if (str_starts_with($path, '/movies') && $method === 'GET') {
    $type = $_GET['type'] ?? 'popular';
    MovieController::list($type);
    exit;
}

if ($method === 'POST' && $path === '/favorites') {
    MovieController::addFavorite();
    exit;
}

// ----------- ROUTES FRONT HTML -----------
if ($path === '/' || $path === '/index') {
    header("Content-Type: text/html");
    //require './templates/header.php';
    require './templates/home.php';
    exit;
}

if ($path === '/contact') {
    header("Content-Type: text/html");
    echo "Page contact";
    exit;
}

http_response_code(404);
echo json_encode(["error" => "Route inconnue"]);