<?php

require_once __DIR__ . '/../services/TMDBService.php';

class MovieController {

    public static function list($type, $page = 1) {
        $movies = TMDBService::getMovies($type, $page);
        echo json_encode($movies);
    }

    public static function getFavorites() {
        $file = __DIR__ . '/../data/favorites.json';

        if (!file_exists($file)) {
            echo json_encode([]);
            return;
        }

        $favorites = json_decode(file_get_contents($file), true);
        echo json_encode($favorites);
    }

    public static function addFavorite() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(["error" => "id obligatoire"]);
            return;
        }

        $file = __DIR__ . '/../data/favorites.json';

        if (!file_exists($file)) {
            file_put_contents($file, json_encode([]));
        }

        $favorites = json_decode(file_get_contents($file), true);

        if (!in_array($data['id'], $favorites)) {
            $favorites[] = $data['id'];
        }

        file_put_contents($file, json_encode($favorites));

        echo json_encode(["success" => true]);
    }
}