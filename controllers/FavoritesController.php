<?php
class FavoritesController {
    public static function getAll() {
        $favs = self::readFile();
        echo json_encode($favs);
    }

    public static function add() {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        if (!$data || !isset($data['id']) || !isset($data['title'])) {
            http_response_code(400);
            echo json_encode(["error" => "id et title requis"]);
            return;
        }

        $favs = self::readFile();

        foreach ($favs as $fav) {
            if ($fav['id'] == $data['id']) {
                http_response_code(409);
                echo json_encode(["error" => "Film deja en favoris"]);
                return;
            }
        }

        $favs[] = ["id" => $data['id'], "title" => $data['title']];
        file_put_contents(FAVORITES_FILE, json_encode($favs));

        http_response_code(201);
        echo json_encode(["message" => "Ajoute aux favoris"]);
    }

    public static function delete($id) {
        $favs = self::readFile();
        $newFavs = array_values(array_filter($favs, fn($f) => $f['id'] != $id));

        if (count($newFavs) === count($favs)) {
            http_response_code(404);
            echo json_encode(["error" => "Favori non trouve"]);
            return;
        }

        file_put_contents(FAVORITES_FILE, json_encode($newFavs));
        echo json_encode(["message" => "Supprime des favoris"]);
    }

    private static function readFile() {
        if (!file_exists(FAVORITES_FILE)) {
            return [];
        }
        $content = file_get_contents(FAVORITES_FILE);
        return json_decode($content, true) ?? [];
    }
}
