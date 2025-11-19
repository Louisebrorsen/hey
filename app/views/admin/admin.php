<main class="admin-main container" style="padding:40px 20px;">

  <!-- Flash-besked (eksempel) -->
  <div style="margin:12px 0; padding:12px; border-radius:10px; background:#103f2c; color:#d7ffef;">
    Din besked vises her (fx "Filmen er oprettet").
  </div>

  <!-- Tabs -->
  <nav class="tabs">
    <a class="tablink is-active" href="?page=admin&tab=movies">Film</a>
    <a class="tablink" href="?page=admin&tab=rooms">Sale &amp; sæder</a>
    <a class="tablink" href="?page=admin&tab=showtimes">Showtimes</a>
    <a class="tablink" href="?page=admin&tab=allMovies">Alle film</a>
  </nav>

  <!-- Evt. status-besked -->
  <div style="margin:12px 0; padding:12px; border-radius:10px; background:#103f2c;color:#d7ffef;">
    Her kan en succes- eller fejlbesked stå.
  </div>

  <!-- == FILM (standard-visning) == -->
  <section id="admin-movies" style="margin-top:30px;">
    <h1>Admin – Film</h1>

    <!-- Opret ny film -->
    <h2>Opret ny film</h2>
    <form method="post" enctype="multipart/form-data" action="?page=admin&action=create" style="display:grid; gap:12px; max-width:640px;">

      <label>Titel<br>
        <input type="text" name="title" required style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
      </label>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
        <label>Spilletid (minutter)<br>
          <input type="number" name="duration_min" min="1" required style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
        </label>
        <label>Aldersgrænse (heltal)<br>
          <input type="number" name="age_limit" min="0" step="1" value="0" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
        </label>
      </div>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
        <label>Udgivelsesdato<br>
          <input type="date" name="released" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
        </label>
        <label>Plakat (jpg/png/webp) – valgfri<br>
          <input type="file" name="poster" accept="image/jpeg,image/png,image/webp">
        </label>
      </div>

      <label>Beskrivelse<br>
        <textarea name="description" rows="4" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;"></textarea>
      </label>

      <button class="btn btn--primary" type="submit">Gem film</button>
    </form>

    <hr style="margin:28px 0; border-color:rgba(255,255,255,.1);">
  </section>

  <!-- == SALE & SÆDER == -->
  <section id="admin-rooms" style="margin-top:30px;">
    <h2>Sale &amp; sæder</h2>
    <p class="muted small">
      Her kan du senere oprette sale og sædekort. Vi kan lave et simpelt CRUD for sale og et grid-UI til sæder.
    </p>
    <form method="post" action="?page=admin&action=create_room" style="display:grid;gap:12px;max-width:520px;">
      <label>Navn på sal<br><input type="text" name="room_name" required></label>
      <label>Kort kode (fx S1)<br><input type="text" name="room_code" maxlength="8" required></label>
      <label>Rækker × Sæder pr. række (valgfrit til senere sædekort)
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <input type="number" name="rows" min="1" value="10">
          <input type="number" name="seats_per_row" min="1" value="12">
        </div>
      </label>
      <button class="btn btn--primary" type="submit">Opret sal</button>
    </form>
  </section>

  <!-- == SHOWTIMES == -->
  <section id="admin-showtimes" style="margin-top:30px;">
    <h2>Planlæg forestilling</h2>
    <form method="post" action="?page=admin&action=create_showtime" style="display:grid;gap:12px;max-width:520px;">
      <label>Film<br>
        <select name="movie_id" required>
          <option value="1">Eksempel film 1</option>
          <option value="2">Eksempel film 2</option>
        </select>
      </label>
      <label>Sal/rum<br><input type="text" name="room" required></label>
      <label>Start (dato+tid)<br><input type="datetime-local" name="starts_at" required></label>
      <label>Pris<br><input type="number" name="price" step="1" value="110"></label>
      <button class="btn btn--primary" type="submit">Opret forestilling</button>
    </form>

    <hr style="margin:28px 0;border-color:rgba(255,255,255,.1);">

    <h3>Kommende forestillinger</h3>
    <div class="list">
      <div class="row">
        <div>
          <div class="title">Eksempel film 1</div>
          <div class="meta">Sal 1 · 24.12.2025 19:30</div>
        </div>
        <div class="row__format">DKK 110</div>
        <form method="post" action="?page=admin&action=delete_showtime">
          <input type="hidden" name="id" value="1">
          <button class="btn btn--primary" type="submit" style="background:#ff6b6b;color:#fff;">Slet</button>
        </form>
      </div>
    </div>
  </section>

  <!-- == ALLE FILM == -->
  <section id="admin-all-movies" style="margin-top:30px;">
    <h2>Alle film</h2>
    <div class="grid">
      <article class="card">
        <img class="card__media" src="uploads/posters/example-1.jpg" alt="Poster for Eksempel film 1">
        <div class="card__body">
          <span class="badge">120 min · 11+</span>
          <div class="title">Eksempel film 1</div>
          <div class="meta">01.10.2025</div>
        </div>
        <div class="card__actions" style="display:flex; gap:8px; padding:14px;">
          <a class="btn btn--ghost" href="?page=admin&action=edit&id=1">Redigér</a>
          <form method="post" action="?page=admin&action=delete">
            <input type="hidden" name="id" value="1">
            <button class="btn btn--primary" type="submit" style="background:#ff6b6b; color:#fff;">Slet</button>
          </form>
        </div>
      </article>

      <article class="card">
        <img class="card__media" src="uploads/posters/example-2.jpg" alt="Poster for Eksempel film 2">
        <div class="card__body">
          <span class="badge">95 min · 7+</span>
          <div class="title">Eksempel film 2</div>
          <div class="meta">15.11.2025</div>
        </div>
        <div class="card__actions" style="display:flex; gap:8px; padding:14px;">
          <a class="btn btn--ghost" href="?page=admin&action=edit&id=2">Redigér</a>
          <form method="post" action="?page=admin&action=delete">
            <input type="hidden" name="id" value="2">
            <button class="btn btn--primary" type="submit" style="background:#ff6b6b; color:#fff;">Slet</button>
          </form>
        </div>
      </article>
    </div>
  </section>

</main>