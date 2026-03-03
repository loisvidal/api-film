<?php
require_once __DIR__ . '/../services/TMDBService.php';

class MovieController {
    public static function list($type) {
        try {
            $movies = TMDBService::getMovies($type);
            if ($movies === null) {
                http_response_code(400);
                echo json_encode(["error" => "Type invalide ou erreur TMDB"]);
                return;
            }
            echo json_encode($movies);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "Erreur serveur"]);
        }
    }

    public static function getOne($id) {
        try {
            $movie = TMDBService::getMovieById($id);
            if ($movie === null) {
                http_response_code(404);
                echo json_encode(["error" => "Film non trouvé"]);
                return;
            }
            echo json_encode($movie);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "Erreur serveur"]);
        }
    }
}
