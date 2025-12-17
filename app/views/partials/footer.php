<?php
if (!isset($settings) || !is_array($settings)) {
  try {
    $db = Database::connect();
    $stmt = $db->query("SELECT * FROM site_settings ORDER BY id ASC LIMIT 1");
    $settings = $stmt ? ($stmt->fetch(PDO::FETCH_ASSOC) ?: []) : [];
  } catch (Throwable $e) {
    $settings = [];
  }
}

$cinemaName   = $settings['cinema_name'] ?? 'Cinema';
$description  = $settings['description'] ?? 'Din lokale biograf. Moderne sale, god lyd og kolde sodavand. Book online eller i kiosken.';
$address      = $settings['address'] ?? 'Torvegade 1\n6760 Ribe';
$phone        = $settings['phone'] ?? '+45 12 34 56 78';
$email        = $settings['email'] ?? 'hello@cinema.dk';
?>
<footer id="about">
  <div class="container fgrid">

    <div>
      <div class="brand" style="margin-bottom:10px;">
        <span class="brand__logo" aria-hidden="true"></span>
        <strong><?= e($cinemaName) ?></strong>
      </div>
      <p class="muted">
        <?= nl2br(e($description)) ?>
      </p>
    </div>

    <div>
      <strong>Hurtige links</strong>
      <div class="small" style="margin-top:10px; display:grid; gap:8px;">
        <a href="/#showing">I biografen</a>
        <a href="/#today">Dagens tider</a>
        <a href="/#coming">Kommende</a>
        <a href="#contact">Kontakt</a>
      </div>
    </div>

    <div id="contact">
      <strong>Kontakt</strong>
      <p class="small muted" style="margin-top:10px;">
        <?= nl2br(e($address)) ?><br />
        <?= e($phone) ?><br />
        <?= e($email) ?>
      </p>
    </div>

  </div>
</footer>
