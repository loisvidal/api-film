# api-film
les deux commandes atm
GET http://localhost:8000/movies?type=popular

type possible - popular
- upcoming
- top_rated
- now_playing

POST http://localhost:8000/favorites
{
  "movie_id": 550
}