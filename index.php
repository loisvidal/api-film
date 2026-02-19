<link rel="stylesheet" href="./css/style.css">
<?php

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

