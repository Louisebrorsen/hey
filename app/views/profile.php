<?php
$user = $data['user'] ?? [];
$role = $user['role'] ?? '';
$firstName = $user['firstName'] ?? '';
$lastName  = $user['lastName'] ?? '';
$name      = trim($firstName . ' ' . $lastName);
$email     = $user['email'] ?? '';
$bookings = $data['bookings'] ?? [];
$bookingStats = $data['bookingStats'] ?? ['upcoming' => 0, 'past' => 0];
?>

<main class="profile">
  <div class="wrap">
    <section class="p-grid">
      <div class="stack" style="display:grid; gap:18px;">
        <article class="p-card">
          <div class="p-card__body">
            <h2>Seneste bookinger</h2>
            <?php if (!empty($bookings)): ?>
              <div class="list" role="list" style="margin-top:10px;">
                <?php foreach ($bookings as $b): ?>
                  <?php
                  $dt = !empty($b['screening_time']) ? new DateTime($b['screening_time']) : null;
                  $when = $dt ? $dt->format('d.m.Y H:i') : 'Ukendt tidspunkt';
                  $status = $b['status'] ?? '';
                  $aud = $b['auditorium_name'] ?? '';
                  $price = $b['total_price'] ?? null;
                  ?>
                  <div class="row" role="listitem">
                    <?php if (!empty($b['movie_poster_url'])): ?>
                      <img
                        src="<?= e($b['movie_poster_url']) ?>"
                        alt="Plakat for <?= e($b['movie_title'] ?? '') ?>">
                    <?php endif; ?>
                    <div>
                      <div class="title"><?= e($b['movie_title'] ?? '—') ?></div>
                      <div class="meta"><?= e($when) ?><?= $aud ? ' · ' . e($aud) : '' ?></div>
                      <?php if ($status): ?>
                        <div class="meta" style="margin-top:4px;">
                          <span style="display:inline-block; padding:2px 10px; border:1px solid #ccc; border-radius:999px; font-size:12px;">
                            <?= e($status) ?>
                          </span>
                          <span style="margin-left:8px; font-size:12px; color:#666;">Reservation #<?= (int)($b['reservationID'] ?? 0) ?></span>
                        </div>
                      <?php endif; ?>
                    </div>
                    <div class="row__format"><?php if ($price !== null && $price !== ''): ?><?= e(number_format((float)$price, 0, ',', '.')) ?> kr.<?php else: ?>—<?php endif; ?></div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <div class="list" role="list" style="margin-top:10px;">
                <div class="row" role="listitem">
                  <div>
                    <div class="title">Ingen bookinger endnu</div>
                    <div class="meta">Når du køber billetter, dukker de op her.</div>
                  </div>
                  <div class="row__format">—</div>
                  <div class="row__time">—</div>
                </div>
              </div>
            <?php endif; ?>
            <div style="margin-top:12px;">
              <a class="btn btn--primary" href="<?= url('') ?>#today">Find forestillinger</a>
            </div>
          </div>
        </article>
      </div>

      <div class="stack" style="display:grid; gap:18px;">
        <article class="p-card">
          <div class="p-card__body">
            <h2>Konto</h2>
            <div class="kv">
              <div class="row">
                <div class="label">Navn</div>
                <div class="value"><?= e($name ?: '—') ?></div>
              </div>
              <div class="row">
                <div class="label">Email</div>
                <div class="value"><?= e($email ?: '—') ?></div>
              </div>

              <?php if ($role === 'admin'): ?>
                <div class="row">
                  <div class="label">Rolle</div>
                  <div class="value"><?= e(ucfirst($role ?: '—')) ?></div>
                  <a href="<?= url('admin') ?>" class="btn btn--primary" style="margin-left:8px;">Gå til admin</a>
                </div>
              <?php endif; ?>
            </div>
            <div class="p-card__body">
            <h2>Din status</h2>
            <div class="stats">
              <div class="stat">
                <div class="stat__num"><?= (int)($bookingStats['upcoming'] ?? 0) ?></div>
                <div class="stat__label">Kommende</div>
              </div>
              <div class="stat">
                <div class="stat__num"><?= (int)($bookingStats['past'] ?? 0) ?></div>
                <div class="stat__label">Tidligere</div>
              </div>
            </div>
          </div>
        </article>
      </div>
    </section>
  </div>
</main>