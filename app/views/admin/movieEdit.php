<?php 
$movie = $data['movie'] ?? null;

if (!$movie) {
    echo "<p>Kunne ikke finde filmen.</p>";
    return;
}
?>

<section id="admin-movies" style="margin-top:30px;">
  <!-- Rediger film -->
  <h2>Rediger film</h2>

  <form method="post"
        action="?url=admin/movie/update"
        enctype="multipart/form-data"
        style="display:grid; gap:12px; max-width:640px;">

    <?php if (function_exists('csrf_input')): ?>
      <?= csrf_input(); ?>
    <?php endif; ?>
    <input type="hidden" name="id" value="<?= (int)$movie['movieID'] ?>">

    <label>Titel<br>
      <input type="text"
             name="title"
             value="<?= e($movie['title']) ?>"
             required
             style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
    </label>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
      <label>Spilletid (minutter)<br>
        <input type="number"
               name="duration_min"
               min="1"
               value="<?= (int)$movie['duration_min'] ?>"
               required
               style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
      </label>
      <label>Aldersgrænse (heltal)<br>
        <input type="number"
               name="age_limit"
               min="0"
               step="1"
               value="<?= (int)$movie['age_limit'] ?>"
               style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
      </label>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
      <label>Udgivelsesdato<br>
        <input type="date"
               name="released"
               value="<?= !empty($movie['released']) ? e(substr($movie['released'], 0, 10)) : '' ?>"
               style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
      </label>
     
    </div>

    <label>Beskrivelse<br>
      <textarea name="description"
                rows="4"
                style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;"><?= e($movie['description'] ?? '') ?></textarea>
    </label>

    <div style="display:flex; gap:8px; margin-top:4px;">
      <button class="btn btn--primary" type="submit">Gem ændringer</button>
      <a href="?url=admin/allMovies" class="btn btn--ghost">Annuller</a>
    </div>
  </form>

  <hr style="margin:28px 0; border-color:rgba(255,255,255,.1);">
</section>