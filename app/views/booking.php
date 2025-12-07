    <section id="showtimes" class="movie-detail__showtimes">
      <h2>Kommende forestillinger</h2>

      <div class="list" role="list">
        <?php if (!empty($screenings) && is_array($screenings)): ?>
          <?php foreach ($screenings as $screening): ?>
            <?php
              $auditoriumName = $screening['auditorium_name'] ?? '';
              $timeRaw        = $screening['screening_time'] ?? null;
              $price          = $screening['price'] ?? '';
              $dateFormatted  = $timeRaw ? date('d.m.Y H:i', strtotime($timeRaw)) : '';
            ?>
            <article class="row" role="listitem">
              <div>
                <div class="title">
                  <?= e($movie['title'] ?? '') ?>
                </div>
                <div class="meta">
                  Sal <?= e($auditoriumName) ?>
                  <?php if ($dateFormatted): ?>
                    · <?= e($dateFormatted) ?>
                  <?php endif; ?>
                </div>
              </div>

              <div class="row__format">
                <?php if ($price !== ''): ?>
                  DKK <?= e((string)$price) ?>
                <?php endif; ?>
              </div>

              <a class="btn btn--primary"
                 href="<?= url('booking', ['screeningID' => (int)($screening['screeningID'] ?? 0)]) ?>">
                Vælg billetter
              </a>
            </article>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="movie-detail__no-showtimes">
            Der er ingen planlagte forestillinger for denne film lige nu.
          </p>
        <?php endif; ?>
      </div>
    </section>