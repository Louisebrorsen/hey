<?php
/** @var array $movie */
/** @var array $screenings */
?>

<main class="movie-detail container">

  <?php if (!$movie): ?>
    <section class="movie-detail__error">
      <h1>Film ikke fundet</h1>
      <p>Vi kunne desværre ikke finde den ønskede film.</p>
      <a class="btn btn--primary" href="<?= url('movies') ?>">Tilbage til alle film</a>
    </section>
  <?php else: ?>

    <section class="movie-detail__layout">

      <div class="movie-detail__poster">
        <?php if (!empty($movie['poster_url'])): ?>
          <img 
            src="<?= url($movie['poster_url']) ?>" 
            alt="Plakat for <?= e($movie['title']) ?>"
          >
        <?php else: ?>
          <div class="movie-detail__poster--placeholder">
            <span>Ingen plakat</span>
          </div>
        <?php endif; ?>
      </div>

      <div class="movie-detail__content">
        <a class="movie-detail__backlink" href="<?= url('movies') ?>">← Tilbage til alle film</a>

        <h1 class="movie-detail__title"><?= e($movie['title']) ?></h1>

        <div class="movie-detail__meta">
          <?php if (!empty($movie['duration_min'])): ?>
            <span><?= e($movie['duration_min']) ?> min</span>
          <?php endif; ?>

          <?php if (isset($movie['age_limit'])): ?>
            <span><?= e($movie['age_limit']) ?> år+</span>
          <?php endif; ?>

          <?php if (!empty($movie['released'])): ?>
            <span>
              Premiere: 
              <?= e(date('d.m.Y', strtotime($movie['released']))) ?>
            </span>
          <?php endif; ?>
        </div>

        <?php if (!empty($movie['description'])): ?>
          <p class="movie-detail__description">
            <?= nl2br(e($movie['description'])) ?>
          </p>
        <?php endif; ?>

        <div class="movie-detail__cta">
          <a class="btn btn--primary" href="#showtimes">Se spilletider</a>
        </div>
      </div>

    </section>

    <section id="showtimes" class="movie-detail__showtimes">
      <h2>Kommende forestillinger</h2>

      <?php if (!empty($screenings)): ?>
        <div class="showtimes-list">
          <?php foreach ($screenings as $s): ?>
            <article class="showtime-card">
              <div class="showtime-card__main">
                <div class="showtime-card__time">
                  <?php
                    $startsAt = isset($s['starts_at']) ? strtotime($s['starts_at']) : null;
                  ?>
                  <?php if ($startsAt): ?>
                    <span class="showtime-card__date">
                      <?= e(date('d.m.Y', $startsAt)) ?>
                    </span>
                    <span class="showtime-card__clock">
                      <?= e(date('H:i', $startsAt)) ?>
                    </span>
                  <?php endif; ?>
                </div>
                <div class="showtime-card__info">
                  <?php if (!empty($s['room'])): ?>
                    <div class="showtime-card__room">Sal <?= e($s['room']) ?></div>
                  <?php endif; ?>
                  <?php if (!empty($s['format'])): ?>
                    <div class="showtime-card__format"><?= e($s['format']) ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="showtime-card__actions">
                <?php if (isset($s['price'])): ?>
                  <span class="showtime-card__price">
                    <?= e(number_format($s['price'], 0)) ?> kr.
                  </span>
                <?php endif; ?>
                <a class="btn btn--primary btn--small" href="#">
                  Book billetter
                </a>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="movie-detail__no-showtimes">
          Der er ingen planlagte forestillinger for denne film lige nu.
        </p>
      <?php endif; ?>
    </section>

  <?php endif; ?>

</main>