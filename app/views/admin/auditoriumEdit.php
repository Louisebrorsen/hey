<?php
/** @var array $data */
$room = $data['room'] ?? null;

if (!$room) {
    echo "<p>Kunne ikke finde salen.</p>";
    return;
}
?>

<main class="admin-main container" style="padding:40px 20px;">
  <div class="admin-content">
    <h1>Rediger sal</h1>

    <form method="post"
          action="?url=admin/rooms/update"
          style="display:grid;gap:12px;max-width:520px;">
      <?php if (function_exists('csrf_input')): ?>
        <?= csrf_input(); ?>
      <?php endif; ?>

      <input type="hidden" name="id" value="<?= (int)$room['auditoriumID'] ?>">

      <label>Navn på sal<br>
        <input type="text"
               name="room_name"
               value="<?= e($room['name']) ?>"
               required>
      </label>

      <div style="display:flex; gap:8px; margin-top:4px;">
        <button class="btn btn--primary" type="submit">Gem ændringer</button>
        <a href="?url=admin/rooms" class="btn btn--ghost">Tilbage</a>
      </div>
    </form>
  </div>
</main>