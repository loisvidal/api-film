<?php

require_once __DIR__ . '/../config/config.php';

class TMDBService {

    public static function getMovies($type = 'popular') {

        $url = TMDB_BASE_URL . "/movie/$type?api_key=" . TMDB_API_KEY . "&language=fr-FR";

        $response = file_get_contents($url);

        if (!$response) {
            return ["error" => "Impossible de contacter l'API TMDB"];
        }

        return json_decode($response, true);
    }
}