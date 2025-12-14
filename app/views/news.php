<?php /** @var array $news */ ?>

<main class="container" style="padding: 2rem 0;">
  <header style="margin-bottom: 1.25rem;">
    <h1>Nyheder</h1>
    <p class="muted">Seneste nyt fra biografen.</p>
  </header>

  <?php if (!empty($news)): ?>
    <div class="list" role="list">
      <?php foreach ($news as $item): ?>
        <article class="row" role="listitem" style="align-items: start;">
          <div>
            <div class="title"><?= e($item['title'] ?? 'Nyhed') ?></div>
            <div class="meta">
              <?php if (!empty($item['created_at'])): ?>
                <?= e(date('d.m.Y', strtotime($item['created_at']))) ?>
              <?php endif; ?>
            </div>

            <?php if (!empty($item['body'])): ?>
              <p class="muted" style="margin-top: .6rem;">
                <?= nl2br(e($item['body'])) ?>
              </p>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p>Der er endnu ingen nyheder.</p>
  <?php endif; ?>
</main>
