<?php
class TMDBService {
    public static function getMovies($type) {
        $validTypes = ['popular', 'top_rated', 'upcoming', 'now_playing'];
        if (!in_array($type, $validTypes)) {
            return null;
        }
        $url = TMDB_BASE_URL . "/movie/$type?api_key=" . TMDB_API_KEY . "&language=fr-FR";
        $response = @file_get_contents($url);
        if ($response === false) {
            return null;
        }
        return json_decode($response, true);
    }

    public static function getMovieById($id) {
        $url = TMDB_BASE_URL . "/movie/$id?api_key=" . TMDB_API_KEY . "&language=fr-FR";
        $response = @file_get_contents($url);
        if ($response === false) {
            return null;
        }
        return json_decode($response, true);
    }
}
