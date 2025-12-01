<?php
$room = $data['room'] ?? null;

if (!$room) {
    echo "<p>Kunne ikke finde salen.</p>";
    return;
}
?>

<main class="admin-main container" style="padding:40px 20px;">
  <div class="admin-content">
    <h1>Rediger sal: <?= e($room['name'] ?? '') ?></h1>

    <!-- Rediger navn på sal -->
    <form method="post"
          action="?url=admin/rooms/update"
          class="admin-form">
      <?= csrf_input() ?>
      <input type="hidden" name="id" value="<?= (int)$room['auditoriumID'] ?>">

      <label>
        Navn på sal:
        <input type="text"
               name="room_name"
               value="<?= e($room['name'] ?? '') ?>"
               required>
      </label>

      <button class="btn btn--primary" type="submit">Gem ændringer</button>
      <a href="?url=admin/rooms" class="btn btn--ghost">Tilbage</a>
    </form>

    <hr style="margin:30px 0;">

    <!-- Generér sæder til denne sal -->
    <h2>Sæder til <?= e($room['name'] ?? '') ?></h2>

    <form method="post"
          action="?url=admin/rooms/generateSeats"
          class="admin-form">
      <?= csrf_input() ?>
      <input type="hidden" name="auditoriumID" value="<?= (int)$room['auditoriumID'] ?>">

      <label>
        Antal rækker:
        <input type="number" name="rows" min="1" max="40" required>
      </label>

      <label>
        Sæder pr. række:
        <input type="number" name="seats_per_row" min="1" max="40" required>
      </label>

      <button class="btn btn--primary" type="submit">Generér sæder</button>
    </form>
  </div>
</main>