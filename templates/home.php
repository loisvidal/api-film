<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>API Film</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg: #000000;
      --surface: #12121a;
      --surface2: #1c1c28;
      --gold: #c9a84c;
      --gold-light: #e8c96a;
      --text: #f0ede8;
      --muted: #7a7870;
      --accent: #e05c5c;
      --radius: 4px;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      overflow-x: hidden;
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 9999;
      opacity: 0.4;
    }

    header {
      position: sticky;
      top: 0;
      z-index: 100;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1.2rem 3rem;
      background: rgba(10,10,15,0.85);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(201,168,76,0.15);
    }

    .logo {
      font-family: 'Playfair Display', serif;
      font-size: 1.7rem;
      font-weight: 700;
      letter-spacing: -0.02em;
      color: var(--gold);
    }
    .logo span { color: var(--text); font-style: italic; }

    nav { display: flex; gap: 2rem; align-items: center; }
    nav a {
      color: var(--muted);
      text-decoration: none;
      font-size: 0.85rem;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      transition: color 0.2s;
    }
    nav a:hover { color: var(--gold); }

    .fav-badge {
      background: var(--accent);
      color: #fff;
      border-radius: 50%;
      font-size: 0.7rem;
      width: 18px; height: 18px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-left: 6px;
    }

    .tabs {
      display: flex;
      gap: 0.5rem;
      padding: 1.5rem 3rem;
      border-bottom: 1px solid rgba(255,255,255,0.06);
    }

    .tab-btn {
      padding: 0.5rem 1.4rem;
      border: 1px solid rgba(255,255,255,0.1);
      background: transparent;
      color: var(--muted);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.82rem;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      cursor: pointer;
      border-radius: var(--radius);
      transition: all 0.2s;
    }
    .tab-btn:hover { border-color: var(--gold); color: var(--gold); }
    .tab-btn.active { background: var(--gold); color: #0a0a0f; border-color: var(--gold); font-weight: 500; }

    .movies-section { padding: 2.5rem 3rem 4rem; }

    .movies-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 1.5rem;
    }

    .movie-card {
      position: relative;
      cursor: pointer;
      border-radius: var(--radius);
      overflow: hidden;
      background: var(--surface);
      transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      animation: fadeUp 0.5s ease both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .movie-card:hover { transform: translateY(-6px); }
    .movie-card:hover .card-overlay { opacity: 1; }
    .movie-card:hover .card-poster { transform: scale(1.04); }

    .poster-wrap { position: relative; aspect-ratio: 2/3; overflow: hidden; }

    .card-poster {
      width: 100%; height: 100%;
      object-fit: cover; display: block;
      transition: transform 0.4s ease;
    }

    .poster-placeholder {
      width: 100%; height: 100%;
      background: var(--surface2);
      display: flex; align-items: center; justify-content: center;
      color: var(--muted); font-size: 2.5rem;
    }

    .card-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(to top, rgba(10,10,15,0.95) 0%, rgba(10,10,15,0.4) 50%, transparent 100%);
      opacity: 0;
      transition: opacity 0.3s;
      display: flex; flex-direction: column;
      justify-content: flex-end;
      padding: 1rem; gap: 0.5rem;
    }

    .overlay-synopsis {
      font-size: 0.75rem;
      color: rgba(240,237,232,0.8);
      line-height: 1.5;
      display: -webkit-box;
      -webkit-line-clamp: 4;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .overlay-actions { display: flex; gap: 0.5rem; }

    .btn-fav {
      flex: 1; padding: 0.45rem;
      border: 1px solid var(--gold);
      background: transparent; color: var(--gold);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.75rem; letter-spacing: 0.06em;
      text-transform: uppercase; cursor: pointer;
      border-radius: var(--radius);
      transition: all 0.2s;
    }
    .btn-fav:hover, .btn-fav.saved { background: var(--gold); color: #0a0a0f; }
    .btn-fav:disabled { opacity: 0.5; cursor: wait; }

    .card-info { padding: 0.75rem; }
    .card-title {
      font-family: 'Playfair Display', serif;
      font-size: 0.95rem; line-height: 1.3;
      margin-bottom: 0.3rem;
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .card-meta { display: flex; justify-content: space-between; align-items: center; }
    .card-date { font-size: 0.72rem; color: var(--muted); }
    .card-rating { display: flex; align-items: center; gap: 0.3rem; font-size: 0.75rem; color: var(--gold); font-weight: 500; }
    .card-rating::before { content: '★'; }

    .loader {
      display: flex; justify-content: center; align-items: center;
      height: 300px; gap: 8px;
    }
    .loader-dot {
      width: 8px; height: 8px; border-radius: 50%;
      background: var(--gold);
      animation: pulse 1.2s ease-in-out infinite;
    }
    .loader-dot:nth-child(2) { animation-delay: 0.2s; }
    .loader-dot:nth-child(3) { animation-delay: 0.4s; }

    @keyframes pulse {
      0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
      40% { transform: scale(1); opacity: 1; }
    }

    .error-box { text-align: center; padding: 4rem; color: var(--muted); }
    .error-box strong { color: var(--accent); display: block; font-size: 1.2rem; margin-bottom: 0.5rem; }

    .toast {
      position: fixed; bottom: 2rem; right: 2rem;
      background: var(--surface2); border: 1px solid var(--gold);
      color: var(--gold); padding: 0.75rem 1.5rem;
      border-radius: var(--radius); font-size: 0.85rem;
      transform: translateY(80px); opacity: 0;
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      z-index: 200;
    }
    .toast.show { transform: translateY(0); opacity: 1; }

    .favorites-panel { display: none; padding: 2.5rem 3rem 4rem; }
    .favorites-panel.active { display: block; }

    .fav-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 1.5rem;
    }

    .fav-card {
      position: relative; border-radius: var(--radius);
      overflow: hidden; background: var(--surface);
      animation: fadeUp 0.4s ease both;
      transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .fav-card:hover { transform: translateY(-5px); }
    .fav-card:hover .fav-card-overlay { opacity: 1; }
    .fav-card:hover .card-poster { transform: scale(1.04); }

    .fav-card-overlay {
      position: absolute; inset: 0;
      background: rgba(10,10,15,0.7);
      display: flex; align-items: center; justify-content: center;
      opacity: 0; transition: opacity 0.25s;
    }

    .btn-remove {
      padding: 0.5rem 1.2rem;
      border: 1px solid var(--accent); background: transparent; color: var(--accent);
      font-family: 'DM Sans', sans-serif; font-size: 0.78rem;
      letter-spacing: 0.06em; text-transform: uppercase;
      cursor: pointer; border-radius: var(--radius); transition: all 0.2s;
    }
    .btn-remove:hover { background: var(--accent); color: #fff; }

    .fav-meta-bar {
      display: flex; justify-content: space-between;
      align-items: center; margin-bottom: 1.5rem;
    }
    .fav-count-label { color: var(--muted); font-size: 0.85rem; }

    .btn-clear {
      padding: 0.4rem 1rem;
      border: 1px solid rgba(224,92,92,0.4); background: transparent; color: var(--accent);
      font-family: 'DM Sans', sans-serif; font-size: 0.75rem;
      letter-spacing: 0.06em; text-transform: uppercase;
      cursor: pointer; border-radius: var(--radius); transition: all 0.2s;
    }
    .btn-clear:hover { background: var(--accent); color: #fff; border-color: var(--accent); }

    .fav-card-info { padding: 0.75rem; }
    .fav-card-title {
      font-family: 'Playfair Display', serif;
      font-size: 0.92rem; line-height: 1.3; margin-bottom: 0.3rem;
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .fav-card-meta { display: flex; justify-content: space-between; align-items: center; }

    .empty-fav {
      color: var(--muted); font-style: italic;
      font-family: 'Playfair Display', serif;
      font-size: 1.1rem; padding: 3rem 0;
    }

    .search-wrap {
      padding: 1.2rem 3rem 0;
      display: flex;
      gap: 0.6rem;
    }

    .search-input {
      flex: 1;
      background: var(--surface);
      border: 1px solid rgba(255,255,255,0.08);
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.88rem;
      padding: 0.65rem 1.1rem;
      border-radius: var(--radius);
      outline: none;
      transition: border-color 0.2s;
    }
    .search-input::placeholder { color: var(--muted); }
    .search-input:focus { border-color: var(--gold); }

    .search-btn {
      padding: 0.65rem 1.4rem;
      background: var(--gold);
      border: none;
      color: #0a0a0f;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.82rem;
      font-weight: 500;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      cursor: pointer;
      border-radius: var(--radius);
      transition: background 0.2s;
    }
    .search-btn:hover { background: var(--gold-light); }

    .search-clear {
      padding: 0.65rem 1rem;
      background: transparent;
      border: 1px solid rgba(255,255,255,0.1);
      color: var(--muted);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.82rem;
      cursor: pointer;
      border-radius: var(--radius);
      transition: all 0.2s;
      display: none;
    }
    .search-clear.visible { display: block; }
    .search-clear:hover { border-color: var(--accent); color: var(--accent); }

    .search-results-label {
      padding: 1rem 3rem 0;
      font-size: 0.72rem;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--muted);
    }

    @media (max-width: 768px) {
      header { padding: 1rem 1.5rem; }
      .tabs, .movies-section, .favorites-panel { padding-left: 1.5rem; padding-right: 1.5rem; }
      .movies-grid, .fav-grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; }
    }
  </style>
</head>
<body>

<header>
  <div class="logo">API <span>Film</span></div>
  <nav>
    <a href="#" onclick="showSection('movies')">Films</a>
    <a href="#" onclick="showSection('favorites')">
      Favoris <span class="fav-badge" id="fav-count">0</span>
    </a>
  </nav>
</header>

<div class="search-wrap" id="search-wrap">
  <input
    class="search-input"
    id="search-input"
    type="text"
    placeholder="Rechercher un film..."
    onkeydown="if(event.key==='Enter') doSearch()"
  />
  <button class="search-btn" onclick="doSearch()">Rechercher</button>
  <button class="search-clear" id="search-clear" onclick="clearSearch()">✕ Effacer</button>
</div>
<div class="search-results-label" id="search-results-label" style="display:none"></div>

<div class="tabs" id="tabs-bar">
  <button class="tab-btn active" onclick="loadMovies('popular', this)">Populaires</button>
  <button class="tab-btn" onclick="loadMovies('top_rated', this)">Top Noté</button>
  <button class="tab-btn" onclick="loadMovies('now_playing', this)">À l'affiche</button>
  <button class="tab-btn" onclick="loadMovies('upcoming', this)">Prochainement</button>
</div>

<section class="movies-section" id="movies-section">
  <div id="movies-container" class="movies-grid"></div>
</section>

<section class="favorites-panel" id="favorites-section">
  <div id="fav-content"></div>
</section>

<div class="toast" id="toast"></div>

<script>
  const API_BASE = '';
  let favIds = new Set();
  let currentMoviesData = {};

  async function init() {
    await syncFavIds();
    loadMovies('popular');
  }

  async function syncFavIds() {
    try {
      const res = await fetch(`${API_BASE}/favorites`);
      if (!res.ok) return;
      const favs = await res.json();
      favIds = new Set(favs.map(f => f.id));
      updateFavCount();
    } catch (e) {
      console.warn('Impossible de charger les favoris depuis le serveur:', e);
    }
  }

  function updateFavCount() {
    document.getElementById('fav-count').textContent = favIds.size;
  }

  function showSection(section) {
    const isMovies = section === 'movies';
    document.getElementById('movies-section').style.display = isMovies ? 'block' : 'none';
    document.getElementById('favorites-section').classList.toggle('active', !isMovies);
    document.getElementById('tabs-bar').style.display = isMovies ? 'flex' : 'none';
    document.getElementById('search-wrap').style.display = isMovies ? 'flex' : 'none';
    document.getElementById('search-results-label').style.display = 'none';
    if (!isMovies) renderFavorites();
  }

  async function loadMovies(type = 'popular', tabEl = null) {
    if (tabEl) {
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      tabEl.classList.add('active');
    }
    showSection('movies');
    const container = document.getElementById('movies-container');
    container.innerHTML = `<div class="loader" style="grid-column:1/-1">
      <div class="loader-dot"></div><div class="loader-dot"></div><div class="loader-dot"></div>
    </div>`;
    try {
      const res = await fetch(`${API_BASE}/movies?type=${type}`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      if (data.error) throw new Error(data.error);
      renderMovies(data.results || []);
    } catch (err) {
      container.innerHTML = `<div class="error-box" style="grid-column:1/-1">
        <strong>Erreur de chargement</strong>
        ${err.message}<br><small>Vérifiez que votre backend PHP est en cours d'exécution.</small>
      </div>`;
    }
  }

  function buildCardHTML(movie, i = 0, removable = false) {
    const poster = movie.poster_path
      ? `<img class="card-poster" src="https://image.tmdb.org/t/p/w342${movie.poster_path}" alt="${movie.title}" loading="lazy"/>`
      : `<div class="poster-placeholder">🎬</div>`;
    const year = movie.release_date ? movie.release_date.slice(0, 4) : '—';
    const rating = movie.vote_average ? (+movie.vote_average).toFixed(1) : '—';
    const isFav = favIds.has(movie.id);
    const synopsis = movie.overview || 'Aucun résumé disponible.';

    if (removable) {
      return `
        <div class="fav-card" style="animation-delay:${i * 0.04}s" data-id="${movie.id}">
          <div class="poster-wrap">
            ${poster}
            <div class="fav-card-overlay">
              <button class="btn-remove" onclick="removeFav(${movie.id})">✕ Retirer</button>
            </div>
          </div>
          <div class="fav-card-info">
            <div class="fav-card-title" title="${movie.title}">${movie.title}</div>
            <div class="fav-card-meta">
              <span class="card-date">${year}</span>
              <span class="card-rating">${rating}</span>
            </div>
          </div>
        </div>`;
    }

    return `
      <div class="movie-card" style="animation-delay:${i * 0.04}s" data-id="${movie.id}">
        <div class="poster-wrap">
          ${poster}
          <div class="card-overlay">
            <p class="overlay-synopsis">${synopsis}</p>
            <div class="overlay-actions">
              <button class="btn-fav ${isFav ? 'saved' : ''}" onclick="toggleFav(${movie.id}, this)" data-id="${movie.id}">
                ${isFav ? '✓ Sauvegardé' : '+ Favoris'}
              </button>
            </div>
          </div>
        </div>
        <div class="card-info">
          <div class="card-title" title="${movie.title}">${movie.title}</div>
          <div class="card-meta">
            <span class="card-date">${year}</span>
            <span class="card-rating">${rating}</span>
          </div>
        </div>
      </div>`;
  }

  function renderMovies(movies) {
    const container = document.getElementById('movies-container');
    if (!movies.length) {
      container.innerHTML = `<div class="error-box" style="grid-column:1/-1"><strong>Aucun film trouvé</strong></div>`;
      return;
    }
    movies.forEach(m => { currentMoviesData[m.id] = m; });
    container.innerHTML = movies.map((movie, i) => buildCardHTML(movie, i, false)).join('');
  }

  async function doSearch() {
    const query = document.getElementById('search-input').value.trim();
    if (!query) return;

    showSection('movies');
    document.getElementById('search-clear').classList.add('visible');

    const label = document.getElementById('search-results-label');
    label.style.display = 'block';
    label.textContent = `Résultats pour "${query}"`;

    const container = document.getElementById('movies-container');
    container.innerHTML = `<div class="loader" style="grid-column:1/-1">
      <div class="loader-dot"></div><div class="loader-dot"></div><div class="loader-dot"></div>
    </div>`;

    try {
      const res = await fetch(`${API_BASE}/search?q=${encodeURIComponent(query)}`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      if (data.error) throw new Error(data.error);
      const results = data.results || [];
      if (!results.length) {
        container.innerHTML = `<div class="error-box" style="grid-column:1/-1"><strong>Aucun résultat</strong>Aucun film trouvé pour "${query}"</div>`;
        return;
      }
      renderMovies(results);
    } catch (err) {
      container.innerHTML = `<div class="error-box" style="grid-column:1/-1"><strong>Erreur</strong>${err.message}</div>`;
    }
  }

  function clearSearch() {
    document.getElementById('search-input').value = '';
    document.getElementById('search-clear').classList.remove('visible');
    document.getElementById('search-results-label').style.display = 'none';
    const activeTab = document.querySelector('.tab-btn.active');
    const type = activeTab ? activeTab.textContent.trim() : 'popular';
    loadMovies('popular', document.querySelector('.tab-btn'));
  }

  async function toggleFav(movieId, btn) {
    btn.disabled = true;
    const isSaved = favIds.has(movieId);

    if (isSaved) {
      await removeFavFromServer(movieId);
      favIds.delete(movieId);
      btn.textContent = '+ Favoris';
      btn.classList.remove('saved');
      showToast('Retiré des favoris');
    } else {
      const movieData = currentMoviesData[movieId];
      if (!movieData) { btn.disabled = false; return; }

      try {
        const res = await fetch(`${API_BASE}/favorites`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            id:           movieData.id,
            title:        movieData.title,
            poster_path:  movieData.poster_path  || null,
            release_date: movieData.release_date || '',
            vote_average: movieData.vote_average || 0,
            overview:     movieData.overview     || ''
          })
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        favIds.add(movieId);
        btn.textContent = '✓ Sauvegardé';
        btn.classList.add('saved');
        showToast('Ajouté aux favoris ✓');
      } catch (e) {
        showToast('Erreur serveur — réessayez');
        console.error(e);
      }
    }

    updateFavCount();
    btn.disabled = false;
  }

  async function removeFavFromServer(movieId) {
    try {
      const res = await fetch(`${API_BASE}/favorites/${movieId}`, { method: 'DELETE' });
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
    } catch (e) {
      console.error('Erreur suppression favori:', e);
    }
  }

  async function removeFav(movieId) {
    await removeFavFromServer(movieId);
    favIds.delete(movieId);
    updateFavCount();
    showToast('Retiré des favoris');
    renderFavorites();
    const btn = document.querySelector(`.btn-fav[data-id="${movieId}"]`);
    if (btn) { btn.textContent = '+ Favoris'; btn.classList.remove('saved'); }
  }

  async function renderFavorites() {
    const el = document.getElementById('fav-content');
    el.innerHTML = `<div class="loader"><div class="loader-dot"></div><div class="loader-dot"></div><div class="loader-dot"></div></div>`;
    try {
      const res = await fetch(`${API_BASE}/favorites`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const favorites = await res.json();

      if (!favorites.length) {
        el.innerHTML = `<p class="empty-fav">Aucun film en favori pour le moment.<br><small style="font-size:0.75rem;font-style:normal;color:var(--muted)">Survolez un film et cliquez sur "+ Favoris"</small></p>`;
        return;
      }

      el.innerHTML = `
        <div class="fav-meta-bar">
          <span class="fav-count-label">${favorites.length} film${favorites.length > 1 ? 's' : ''} sauvegardé${favorites.length > 1 ? 's' : ''}</span>
          <button class="btn-clear" onclick="clearFavorites()">Tout effacer</button>
        </div>
        <div class="fav-grid">
          ${favorites.map((movie, i) => buildCardHTML(movie, i, true)).join('')}
        </div>`;
    } catch (e) {
      el.innerHTML = `<div class="error-box"><strong>Erreur de chargement</strong>${e.message}</div>`;
    }
  }

  async function clearFavorites() {
    try {
      const res = await fetch(`${API_BASE}/favorites`, { method: 'DELETE' });
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
    } catch (e) {
      showToast('Erreur serveur');
      return;
    }
    favIds.clear();
    updateFavCount();
    renderFavorites();
    document.querySelectorAll('.btn-fav.saved').forEach(btn => {
      btn.textContent = '+ Favoris';
      btn.classList.remove('saved');
    });
    showToast('Favoris effacés');
  }

  function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2500);
  }

  init();
</script>
</body>
</html>
