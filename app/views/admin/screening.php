<section id="admin-showtimes" style="margin-top:30px;">
  <h2>Planlæg forestilling</h2>
  <form method="post" action="?url=admin/showtimes" style="display:grid;gap:12px;max-width:520px;">
    <div>
      <label for="movieID">Film</label><br>
      <?php
      $today = new DateTime();
      $currentMovies = [];
      $upcomingMovies = [];
      ?>
      <?php if (!empty($error)): ?>
        <div style="margin-bottom:12px;padding:10px;border-radius:4px;background:#4b1f24;color:#ffb3b3;">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>
      <select name="movieID" id="movieID" required>
        <option value="">Vælg film</option>

        <?php if (!empty($nowPlaying)): ?>
          <optgroup label="Aktuelle film">
            <?php foreach ($nowPlaying as $movie): ?>
              <option value="<?= htmlspecialchars($movie['movieID']) ?>">
                <?= htmlspecialchars($movie['title']) ?>
              </option>
            <?php endforeach; ?>
          </optgroup>
        <?php endif; ?>

        <?php if (!empty($comingSoon)): ?>
          <optgroup label="Kommende film">
            <?php foreach ($comingSoon as $movie): ?>
              <option value="<?= htmlspecialchars($movie['movieID']) ?>">
                <?= htmlspecialchars($movie['title']) ?>
              </option>
            <?php endforeach; ?>
          </optgroup>
        <?php endif; ?>
      </select>
    </div>

    <div>
      <label for="auditoriumID">Sal/rum</label><br>
      <select name="auditoriumID" id="auditoriumID" required>
        <option value="">Vælg sal</option>
        <?php foreach ($auditoriums as $auditorium): ?>
          <option value="<?= htmlspecialchars($auditorium['auditoriumID']) ?>">
            <?= htmlspecialchars($auditorium['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label for="screening_time">Start (dato og tid)</label><br>
      <input type="datetime-local" name="screening_time" id="screening_time" required>
      <small>Brug formatet åååå-mm-dd tt:mm (f.eks. 2025-12-24 19:30).</small>
    </div>

    <div>
      <label for="price">Pris (DKK)</label><br>
      <input type="number" name="price" id="price" step="1" min="0" value="110">
    </div>

    <button class="btn btn--primary" type="submit">Opret forestilling</button>
  </form>

  <hr style="margin:28px 0;border-color:rgba(255,255,255,.1);">

  <h3>Kommende forestillinger</h3>

  <?php if (!empty($screenings)): ?>
    <div class="list">
      <div class="row" style="font-weight:bold;border-bottom:1px solid rgba(255,255,255,.2);padding-bottom:6px;margin-bottom:6px;">
        <div>Film &amp; sal</div>
        <div class="row__format">Pris</div>
        <div>Handling</div>
      </div>

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
          <form method="post" action="?url=admin/showtimes/delete">
            <input type="hidden" name="id" value="<?= htmlspecialchars($screening['screeningID']) ?>">
            <button class="btn btn--primary" type="submit" style="background:#ff6b6b;color:#fff;">Slet</button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p style="margin-top:8px;">Der er endnu ingen planlagte forestillinger. Opret den første forestilling i formularen ovenfor.</p>
  <?php endif; ?>


  <h3 style="margin-top:40px;">Tidligere forestillinger</h3>
  <?php if (!empty($pastScreenings)): ?>
    <div class="list">
      <div class="row" style="font-weight:bold;border-bottom:1px solid rgba(255,255,255,.2);padding-bottom:6px;margin-bottom:6px;">
        <div>Film &amp; sal</div>
        <div class="row__format">Pris</div>

      </div>

      <?php foreach ($pastScreenings as $screening): ?>
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
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p style="margin-top:8px;">Der er ingen tidligere forestillinger.</p>
  <?php endif; ?>
</section>