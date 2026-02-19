<?php
class TMDBService {
publicstaticfunctiongetMovies($type) {
$url = TMDB_BASE_URL ."/movie/$type?api_key=" . TMDB_API_KEY ."&language=fr-FR";
$response =file_get_contents($url);
returnjson_decode($response,true);
 }
}