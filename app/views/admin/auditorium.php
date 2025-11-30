<section id="admin-main" style="margin-top:30px;">
  <h2>Sale & sæder</h2>
  <p class="muted small">
    Her kan du oprette biografsale. Senere kan vi knytte sæder og visninger (showtimes) til hver sal.
  </p>

  <!-- Opret ny sal -->
  <form method="post"
        action="?url=admin/rooms/create"
        style="display:grid;gap:12px;max-width:520px;">
    <?php if (function_exists('csrf_input')): ?>
      <?= csrf_input(); ?>
    <?php endif; ?>

    <label>Navn på sal<br>
      <input type="text" name="room_name" required>
    </label>

    <button class="btn btn--primary" type="submit">Opret sal</button>
  </form>

  <!-- Liste over eksisterende sale -->
  <?php if (!empty($rooms)): ?>
    <h3 style="margin-top:24px;">Eksisterende sale</h3>
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Navn</th>
          <th>Handlinger</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rooms as $room): ?>
          <tr>
            <td><?= (int)$room['auditoriumID'] ?></td>
            <td><?= e($room['name']) ?></td>
            <td style="display:flex; gap:8px;">
              <a class="btn btn--ghost"
                 href="?url=admin/rooms/edit&id=<?= (int)$room['auditoriumID'] ?>">
                Rediger
              </a>
              <form method="post"
                    action="?url=admin/rooms/delete"
                    onsubmit="return confirm('Vil du slette denne sal?')">
                <?php if (function_exists('csrf_input')): ?>
                  <?= csrf_input(); ?>
                <?php endif; ?>
                <input type="hidden" name="id" value="<?= (int)$room['auditoriumID'] ?>">
                <button type="submit" class="btn btn--danger">Slet</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</section>