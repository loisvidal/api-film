<?php

require_once'config/config.php';
require_once'controllers/MovieController.php';
header("Content-Type: application/json");
$path =$_SERVER['REQUEST_URI'];
if (str_starts_with($path,'/movies')) {
$type =$_GET['type'] ??'popular';
MovieController::list($type);
}else {
http_response_code(404);
echojson_encode(["error" =>"Route inconnue"]);
}