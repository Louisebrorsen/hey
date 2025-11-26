<main>
  <section>
     <div class="grid">
        <?php foreach ($movies as $movie): ?>
  <article class="card">
<?php if (!empty($movie['poster_url'])): ?>
          <img class="card__media"
               src="<?= e($movie['poster_url']) ?>"
               alt="Plakat for <?= e($movie['title']) ?>">
<?php else: ?>
          <div class="card__media" aria-hidden="true"></div>
<?php endif; ?>

    <div class="card__body">
      <span class="badge">
        <?= e($movie['duration_min']) ?> min · <?= e($movie ['age_limit']) ?>+
      </span>
      <div class="title"><?= e($movie['title']) ?></div>
      <div class="meta">
        <?= !empty($movie['released']) ? e(date('d.m.Y', strtotime($movie['released']))) : 'Ukendt premieredato' ?>
      </div>
    </div>

    <div class="card__actions">
      <a class="btn btn--primary" href="?url=admin/movie/edit&id=<?= (int)$movie['movieID'] ?>">Rediger</a>
      <a class="btn btn--ghost" href="<?= url('movieDetail', ['id'=>(int)$movie['movieID']]) ?>">Slet</a>
    </div>
  </article>
<?php endforeach; ?>
      </div>
</section>
</main>