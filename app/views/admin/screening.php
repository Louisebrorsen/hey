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
