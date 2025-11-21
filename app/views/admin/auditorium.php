<section id="admin-rooms" style="margin-top:30px;">
    <h2>Sale &amp; sæder</h2>
    <p class="muted small">
      Her kan du senere oprette sale og sædekort. Vi kan lave et simpelt CRUD for sale og et grid-UI til sæder.
    </p>
    <form method="post" action="?page=admin&action=create_room" style="display:grid;gap:12px;max-width:520px;">
      <label>Navn på sal<br><input type="text" name="room_name" required></label>
      <label>Kort kode (fx S1)<br><input type="text" name="room_code" maxlength="8" required></label>
      <label>Rækker × Sæder pr. række (valgfrit til senere sædekort)
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <input type="number" name="rows" min="1" value="10">
          <input type="number" name="seats_per_row" min="1" value="12">
        </div>
      </label>
      <button class="btn btn--primary" type="submit">Opret sal</button>
    </form>
  </section>