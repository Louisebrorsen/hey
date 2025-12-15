<?php

/** @var array $movie */
/** @var array $screenings */
// Normalisér $screenings så viewet altid arbejder med en liste af screenings.
// Nogle controllers kan komme til at sende én screening som assoc array (fx fra getScreeningById / getNextScreeningForMovie).
if (!is_array($screenings)) {
  $screenings = [];
} elseif (isset($screenings['screeningID'])) {
  // Én screening som assoc array → gør den til en liste
  $screenings = [$screenings];
}
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
          <img class="card__media" src="<?= e($movie['poster_url']) ?>" alt="Plakat for <?= e($movie['title']) ?>">
        <?php else: ?>
          <div class="card__media" aria-hidden="true"></div>
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

      <div class="list" role="list">
        <?php if (!empty($screenings)): ?>
          <?php foreach ($screenings as $screening): ?>
            <?php if (!is_array($screening) || empty($screening['screeningID'])) continue; ?>
            <article class="row" role="listitem">
              <div>
                <div class="title">
                  <?= e($movie['title']) ?>
                </div>
                <div class="meta">
                  <?php
                  $auditoriumLabel = (is_array($screening) && isset($screening['auditorium_name']))
                      ? $screening['auditorium_name']
                      : null;
                  ?>
                  <?php if ($auditoriumLabel): ?>
                    Sal <?= e($auditoriumLabel) ?> ·
                  <?php endif; ?>
                  <?php
                  $screeningTime = $screening['screening_time'] ?? null;
                  if ($screeningTime) {
                      echo e(date('d.m.Y H:i', strtotime($screeningTime)));
                  } else {
                      echo 'Ukendt tidspunkt';
                  }
                  ?>
                </div>
              </div>

              <div class="row__format">
                <?php if (isset($screening['price']) && $screening['price'] !== null && $screening['price'] !== ''): ?>
                  DKK <?= e((string)$screening['price']) ?>
                <?php else: ?>
                  <span class="row__price-missing">Pris ikke tilgængelig</span>
                <?php endif; ?>
              </div>

              <?= renderBookingAction(
                (int)$screening['screeningID'],
                $screening['is_sold_out'] ?? 0
              ) ?>
            </article>
          
          <?php endforeach; ?>
        <?php else: ?>
          <p class="movie-detail__no-showtimes">
            Der er ingen planlagte forestillinger for denne film lige nu.
          </p>
        <?php endif; ?>
      </div>
    </section>

  <?php endif; ?>

</main>