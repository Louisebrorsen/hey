<section id="admin-showtimes" style="margin-top:30px;">
    <h2>Planlæg forestilling</h2>
    <form method="post" action="?url=admin/showtimes" style="display:grid;gap:12px;max-width:520px;">
      <label>Film<br>
        <select name="movieID" required>
          <option value="">Vælg film</option>
          <?php foreach ($movies as $movie): ?>
            <option value="<?= htmlspecialchars($movie['movieID']) ?>">
              <?= htmlspecialchars($movie['title']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
      <label>Sal/rum<br>
        <select name="auditoriumID" required>
          <option value="">Vælg sal</option>
          <?php foreach ($auditoriums as $auditorium): ?>
            <option value="<?= htmlspecialchars($auditorium['auditoriumID']) ?>">
              <?= htmlspecialchars($auditorium['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
      <label>Start (dato+tid)<br><input type="datetime-local" name="screening_time" required></label>
      <label>Pris<br><input type="number" name="price" step="1" value="110"></label>
      <button class="btn btn--primary" type="submit">Opret forestilling</button>
    </form>

    <hr style="margin:28px 0;border-color:rgba(255,255,255,.1);">

    <h3>Kommende forestillinger</h3>

    <?php if (!empty($screenings)): ?>
      <div class="list">
        <?php foreach ($screenings as $screening): ?>
          <div class="row">
            <div>
              <div class="title">
                <?= htmlspecialchars($screening['movie_title']) ?>
              </div>
              <div class="meta">
                Sal <?= htmlspecialchars($screening['auditorium_name']) ?> ·
                <?= htmlspecialchars(date('d.m.Y H:i', strtotime($screening['screening_time']))) ?>
              </div>
            </div>
            <div class="row__format">
              DKK <?= htmlspecialchars($screening['price']) ?>
            </div>
            <form method="post" action="?page=admin&action=delete_showtime">
              <input type="hidden" name="id" value="<?= htmlspecialchars($screening['screeningID']) ?>">
              <button class="btn btn--primary" type="submit" style="background:#ff6b6b;color:#fff;">Slet</button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>Der er endnu ingen planlagte forestillinger.</p>
    <?php endif; ?>
  </section>
