<?php
require_once __DIR__ . '/../config/config.php';

class TMDBService {

    public static function getMovies($type = 'popular') {
        $validTypes = ['popular', 'top_rated', 'now_playing', 'upcoming'];
        if (!in_array($type, $validTypes)) {
            return ["error" => "Type invalide"];
        }
        $url = TMDB_BASE_URL . "/movie/$type?api_key=" . TMDB_API_KEY . "&language=fr-FR";
        return self::fetch($url);
    }

    public static function searchMovies($query) {
        if (empty(trim($query))) {
            return ["results" => []];
        }
        $url = TMDB_BASE_URL . "/search/movie?api_key=" . TMDB_API_KEY
             . "&language=fr-FR"
             . "&query=" . urlencode($query)
             . "&include_adult=false";
        return self::fetch($url);
    }

    private static function fetch($url) {
        $context = stream_context_create(['http' => ['timeout' => 5]]);
        $response = @file_get_contents($url, false, $context);
        if ($response === false) {
            return ["error" => "Impossible de contacter l'API TMDB"];
        }
        return json_decode($response, true);
    }
}
