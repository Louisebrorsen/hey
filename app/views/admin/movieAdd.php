<section id="admin-movies" style="margin-top:30px;">
    <!-- Opret ny film -->
    <h2>Opret ny film</h2>
    <form method="post" action="?url=admin/create" enctype="multipart/form-data" style="display:grid; gap:12px; max-width:640px;">

      <label>Titel<br>
        <input type="text" name="title" required style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
      </label>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
        <label>Spilletid (minutter)<br>
          <input type="number" name="duration_min" min="1" required style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
        </label>
        <label>Aldersgrænse (heltal)<br>
          <input type="number" name="age_limit" min="0" step="1" value="0" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
        </label>
      </div>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
        <label>Udgivelsesdato<br>
          <input type="date" name="released" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
        </label>
        <label>Plakat – valgfri<br>
          <input type="file" name="poster" accept="image/jpeg,image/png,image/pjpeg,image/jpg,image/webp">
        </label>
      </div>

      <label>Beskrivelse<br>
        <textarea name="description" rows="4" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;"></textarea>
      </label>

      <button class="btn btn--primary" type="submit">Gem film</button>
    </form>

    <hr style="margin:28px 0; border-color:rgba(255,255,255,.1);">
  </section>