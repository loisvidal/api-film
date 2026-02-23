<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet API Film</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #141414; color: #c7d5e0; margin: 0; padding: 20px; text-align: center; }
        
        
        .grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-top: 20px; }
        .card { width: 200px; background-color: #171a21; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.5); transition: transform 0.2s; cursor: pointer; }
        .card:hover { transform: scale(1.05); border: 2px solid #66c0f4; }
        .card img { width: 100%; height: 300px; object-fit: cover; }
        .card h3 { font-size: 1rem; margin: 10px; }

        .modal { display: none;  position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); }
        .modal-content { background-color: #2a475e; margin: 10% auto; padding: 20px; border-radius: 10px; width: 80%; max-width: 600px; text-align: left; position: relative; display: flex; gap: 20px; }
        .modal-content img { width: 200px; border-radius: 8px; }
        .close-btn { color: #2a475e; position: absolute; top: 10px; right: 20px; font-size: 28px; font-weight: bold; cursor: pointer; }
        .close-btn:hover { color: #66c0f4; }
        .movie-info h2 { margin-top: 0; color: #2a475e; }
        .badge { background-color: #66c0f4; padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-right: 10px; }
    </style>
</head>
<body>

    <h1>Films Populaires</h1>
    <div class="grid" id="movies-container">
        <p>Chargement des films...</p>
    </div>

    <div id="movie-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <img id="modal-img" src="" alt="Affiche">
            <div class="movie-info">
                <h2 id="modal-title">Titre du film</h2>
                <p><span class="badge" id="modal-rating">⭐ 0/10</span> <span id="modal-date">Date</span></p>
                <p id="modal-desc">Description du film ici...</p>
            </div>
        </div>
    </div>

    <script>
        let allMovies = []; 

        async function loadMovies() {
            try {
                const response = await fetch('http://localhost:8000/movies?type=popular');
                const data = await response.json();
                
                const container = document.getElementById('movies-container');
                container.innerHTML = ''; 
                
                allMovies = data.results; 

                allMovies.forEach(movie => {
                    const posterUrl = movie.poster_path 
                        ? 'https://image.tmdb.org/t/p/w500' + movie.poster_path 
                        : 'https://via.placeholder.com/500x750?text=Pas+d\'affiche';

                    container.innerHTML += `
                        <div class="card" onclick="showDetails(${movie.id})">
                            <img src="${posterUrl}" alt="${movie.title}">
                            <h3>${movie.title}</h3>
                        </div>
                    `;
                });

            } catch (error) {
                console.error('Erreur:', error);
                document.getElementById('movies-container').innerHTML = '<p style="color:red;">Erreur de connexion à l\'API.</p>';
            }
        }

        function showDetails(movieId) {
            const movie = allMovies.find(m => m.id === movieId);
            
            if (movie) {
                document.getElementById('modal-title').innerText = movie.title;
                document.getElementById('modal-desc').innerText = movie.overview || "Aucun synopsis disponible pour ce film.";
                document.getElementById('modal-rating').innerText = `⭐ ${Math.round(movie.vote_average * 10) / 10}/10`;
                document.getElementById('modal-date').innerText = `Sortie : ${movie.release_date}`;
                
                const posterUrl = movie.poster_path ? 'https://image.tmdb.org/t/p/w500' + movie.poster_path : 'https://via.placeholder.com/500x750?text=Pas+d\'affiche';
                document.getElementById('modal-img').src = posterUrl;

                document.getElementById('movie-modal').style.display = 'block';
            }
        }

        function closeModal() {
            document.getElementById('movie-modal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('movie-modal');
            if (event.target === modal) {
                closeModal();
            }
        }

        loadMovies();
    </script>

</body>
</html>