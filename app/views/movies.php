<main class="admin-main">
  <section>
    <h2>Nu i biografen</h2>
    <div class="grid">
      <?php foreach ($nowPlaying as $np): ?>
        <article class="card">
          <?php if (!empty($np['poster_url'])): ?>
            <img class="card__media" src="<?= e($np['poster_url']) ?>" alt="Plakat for <?= e($np['title']) ?>">
          <?php else: ?>
            <div class="card__media" aria-hidden="true"></div>
          <?php endif; ?>

          <div class="card__body">
            <span class="badge">
              <?= e($np['duration_min']) ?> min · <?= e($np['age_limit']) ?>+
            </span>
            <div class="title"><?= e($np['title']) ?></div>
            <div class="meta">
              <?= !empty($np['released']) ? e(date('d.m.Y', strtotime($np['released']))) : 'Ukendt premieredato' ?>
            </div>
          </div>

          <div class="card__actions">
            <a class="btn btn--primary"
              href="<?= url('booking', ['screeningID' => (int)$screening['screeningID']]) ?>">
              Vælg billetter
            </a> <a class="btn btn--ghost" href="<?= url('movieDetail', ['id' => (int)$np['movieID']]) ?>">Detaljer</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section id="coming">
    <h2>Kommende</h2>
    <div class="grid">
      <?php foreach ($comingSoon as $cs): ?>
        <article class="card">
          <?php if (!empty($cs['poster_url'])): ?>
            <img class="card__media" src="<?= e($cs['poster_url']) ?>" alt="Plakat for <?= e($cs['title']) ?>">
          <?php else: ?>
            <div class="card__media" aria-hidden="true"></div>
          <?php endif; ?>

          <div class="card__body">
            <span class="badge">
              <?= e($cs['duration_min']) ?> min · <?= e($cs['age_limit']) ?>+
            </span>
            <div class="title"><?= e($cs['title']) ?></div>
            <div class="meta">
              <?= !empty($cs['released']) ? e(date('d.m.Y', strtotime($cs['released']))) : 'Ukendt premieredato' ?>
            </div>
          </div>

          <div class="card__actions">
            <a class="btn btn--primary" href="#today">Billetter</a>
            <a class="btn btn--ghost" href="<?= url('movieDetail', ['id' => (int)$cs['movieID']]) ?>">Detaljer</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>
</main>