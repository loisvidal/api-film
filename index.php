<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$title = "Accueil";

if ($uri === '/' || $uri === '/index') {
    require 'templates/header.php';
    echo "Projet API Film";
} elseif ($uri === '/contact') {
    echo "Page contact";
} else {
    http_response_code(404);
    echo "Page introuvable";
}


