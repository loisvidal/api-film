<?php
require_once 'config/config.php';
require_once 'controllers/MovieController.php';
require_once 'controllers/FavoritesController.php';

header("Content-Type: application/json");

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($path === '/' || $path === '/index.php') {
    echo json_encode(["message" => "API Films operationnelle"]);
    exit;
}

if (preg_match('#^/movies/(\d+)$#', $path, $matches)) {
    if ($method === 'GET') {
        MovieController::getOne($matches[1]);
    } else {
        http_response_code(405);
        echo json_encode(["error" => "Methode non autorisee"]);
    }
    exit;
}

if ($path === '/movies') {
    if ($method === 'GET') {
        $type = $_GET['type'] ?? 'popular';
        MovieController::list($type);
    } else {
        http_response_code(405);
        echo json_encode(["error" => "Methode non autorisee"]);
    }
    exit;
}

if (preg_match('#^/favorites/(\d+)$#', $path, $matches)) {
    if ($method === 'DELETE') {
        FavoritesController::delete($matches[1]);
    } else {
        http_response_code(405);
        echo json_encode(["error" => "Methode non autorisee"]);
    }
    exit;
}

if ($path === '/favorites') {
    if ($method === 'GET') {
        FavoritesController::getAll();
    } elseif ($method === 'POST') {
        FavoritesController::add();
    } else {
        http_response_code(405);
        echo json_encode(["error" => "Methode non autorisee"]);
    }
    exit;
}

http_response_code(404);
echo json_encode(["error" => "Route inconnue"]);
