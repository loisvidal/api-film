<?php

require_once __DIR__ . '/../services/TMDBService.php';

class MovieController {

    public static function list($type) {
        $movies = TMDBService::getMovies($type);
        echo json_encode($movies);
    }

    public static function addFavorite() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if (!isset($data['movie_id'])) {
            http_response_code(400);
            echo json_encode(["error" => "movie_id obligatoire"]);
            return;
        }

        $file = __DIR__ . '/../data/favorites.json';

        if (!file_exists($file)) {
            file_put_contents($file, json_encode([]));
        }

        $favorites = json_decode(file_get_contents($file), true);

        if (!in_array($data['movie_id'], $favorites)) {
            $favorites[] = $data['movie_id'];
        }

        file_put_contents($file, json_encode($favorites));

        echo json_encode(["success" => true, "favorites" => $favorites]);
    }
}
