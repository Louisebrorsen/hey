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