<?php

require_once__DIR__ .'/../services/TMDBService.php';

classMovieController {
publicstaticfunctionlist($type) {
$movies =TMDBService::getMovies($type);
echojson_encode($movies);
 }
}