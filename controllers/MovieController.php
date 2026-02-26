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
        echo json_encode(is_array($favorites) ? $favorites : []);
    }

    public static function addFavorite() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        // Validation : on attend un objet film avec au moins un id
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(["error" => "Champ 'id' obligatoire"]);
            return;
        }

        $file = __DIR__ . '/../data/favorites.json';

        // Créer le fichier s'il n'existe pas
        if (!file_exists($file)) {
            // S'assurer que le dossier data/ existe
            $dir = dirname($file);
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            file_put_contents($file, json_encode([]));
        }

        $favorites = json_decode(file_get_contents($file), true);
        if (!is_array($favorites)) $favorites = [];

        // Eviter les doublons (comparaison par id)
        $alreadyExists = false;
        foreach ($favorites as $fav) {
            if (isset($fav['id']) && $fav['id'] === (int)$data['id']) {
                $alreadyExists = true;
                break;
            }
        }

        if (!$alreadyExists) {
            // On stocke l'objet film complet reçu du frontend
            $favorites[] = [
                'id'           => (int) $data['id'],
                'title'        => $data['title']        ?? '',
                'poster_path'  => $data['poster_path']  ?? null,
                'release_date' => $data['release_date'] ?? '',
                'vote_average' => $data['vote_average'] ?? 0,
                'overview'     => $data['overview']     ?? '',
            ];
        }

        file_put_contents($file, json_encode($favorites));
        echo json_encode(["success" => true, "favorites" => $favorites]);
    }

    public static function removeFavorite($movieId) {
        $file = __DIR__ . '/../data/favorites.json';
        if (!file_exists($file)) {
            echo json_encode(["success" => true, "favorites" => []]);
            return;
        }

        $favorites = json_decode(file_get_contents($file), true);
        if (!is_array($favorites)) $favorites = [];

        $favorites = array_values(array_filter($favorites, function($fav) use ($movieId) {
            return isset($fav['id']) && $fav['id'] !== (int)$movieId;
        }));

        file_put_contents($file, json_encode($favorites));
        echo json_encode(["success" => true, "favorites" => $favorites]);
    }

    public static function clearFavorites() {
        $file = __DIR__ . '/../data/favorites.json';
        file_put_contents($file, json_encode([]));
        echo json_encode(["success" => true, "favorites" => []]);
    }
}
