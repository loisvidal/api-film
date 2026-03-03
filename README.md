# API Films

API REST en PHP qui consomme l'API TMDB.

## Installation

1. Cloner / télécharger le projet (si besoin changer la cle api qui est dans config.php sur le site de TMDB)
2. Lancer le serveur PHP :

```bash
php -S localhost:8000 index.php
```

3. Tester sur `http://localhost:8000`

---

## Routes disponibles

| Méthode | Route | Description |
|--------|-------|-------------|
| GET | `/` | Vérifie que l'API tourne |
| GET | `/movies?type=popular` | Liste de films selon le type |
| GET | `/movies/{id}` | Détail d'un film par son ID TMDB |
| GET | `/favorites` | Récupère les favoris |
| POST | `/favorites` | Ajoute un film aux favoris |
| DELETE | `/favorites/{id}` | Supprime un favori |

### Types de films disponibles

- `popular` (défaut)
- `top_rated`
- `upcoming`
- `now_playing`

---

## Exemples de requêtes

### GET /movies
```
GET http://localhost:8000/movies?type=popular
```

### GET /movies/{id}
```
GET http://localhost:8000/movies/550
```

### GET /favorites
```
GET http://localhost:8000/favorites
```

### POST /favorites
```
POST http://localhost:8000/favorites
Content-Type: application/json

{
  "id": 550,
  "title": "Fight Club"
}
```

### DELETE /favorites/{id}
```
DELETE http://localhost:8000/favorites/550
```

---

## Codes de réponse

- `200` OK
- `201` Créé
- `400` Mauvaise requête
- `404` Non trouvé
- `405` Méthode non autorisée
- `409` Conflit (favori déjà existant)
- `500` Erreur serveur

---

## Structure du projet

```
api-films/
├── index.php
├── favorites.json          (créé automatiquement)
├── config/
│   └── config.php
├── services/
│   └── TMDBService.php
├── controllers/
│   ├── MovieController.php
│   └── FavoritesController.php
└── README.md
```
