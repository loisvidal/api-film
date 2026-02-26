<?php
require_once 'config/config.php';
require_once 'controllers/MovieController.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$path   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// GET /movies
if (str_starts_with($path, '/movies') && $method === 'GET') {
    $type = $_GET['type'] ?? 'popular';
    MovieController::list($type);
    exit;
}

// GET /search?q=...
if ($path === '/search' && $method === 'GET') {
    $query = $_GET['q'] ?? '';
    MovieController::search($query);
    exit;
}

// GET /favorites — récupère tous les favoris
if ($path === '/favorites' && $method === 'GET') {
    MovieController::getFavorites();
    exit;
}

// POST /favorites — ajoute un film aux favoris
if ($path === '/favorites' && $method === 'POST') {
    MovieController::addFavorite();
    exit;
}

// DELETE /favorites/:id — supprime un favori précis
if (preg_match('#^/favorites/(\d+)$#', $path, $matches) && $method === 'DELETE') {
    MovieController::removeFavorite((int)$matches[1]);
    exit;
}

// DELETE /favorites — vide tous les favoris
if ($path === '/favorites' && $method === 'DELETE') {
    MovieController::clearFavorites();
    exit;
}

// Pages HTML
if ($path === '/' || $path === '/index') {
    header("Content-Type: text/html");
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
