<?php

require_once 'config/config.php';
require_once 'controllers/MovieController.php';

header("Content-Type: application/json");

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET' && str_starts_with($path, '/movies')) {
    $type = $_GET['type'] ?? 'popular';
    MovieController::list($type);
    exit;
}

if ($method === 'POST' && $path === '/favorites') {
    MovieController::addFavorite();
    exit;
}

http_response_code(404);
echo json_encode(["error" => "Route inconnue"]);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


if ($uri === '/' || $uri === '/index') {
    require './templates/header.php';
    require './templates/home.php';
} elseif ($uri === '/contact') {
    echo "Page contact";
} else {
    http_response_code(404);
    echo "Page introuvable";
}

?>

