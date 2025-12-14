<h1>Biograf information</h1>

<form method="post" action="?url=admin/cinemaInfo/update" class="admin-form">
  
  <div class="form-group">
    <label for="cinema_name">Biografens navn</label>
    <input type="text" id="cinema_name" name="cinema_name" required
           value="<?= e($settings['cinema_name'] ?? '') ?>">
  </div>

  <div class="form-group">
    <label for="description">Beskrivelse af biografen</label>
    <textarea id="description" name="description" rows="4" required><?= e($settings['description'] ?? '') ?></textarea>
  </div>

  <div class="form-group">
    <label for="opening_hours">Åbningstider</label>
    <textarea id="opening_hours" name="opening_hours" rows="3"
              placeholder="Man–Fre: 10–22&#10;Lør–Søn: 10–23"><?= e($settings['opening_hours'] ?? '') ?></textarea>
  </div>

  <div class="form-group">
    <label for="address">Adresse</label>
    <input type="text" id="address" name="address"
           value="<?= e($settings['address'] ?? '') ?>">
  </div>

  <div class="form-group">
    <label for="phone">Telefon</label>
    <input type="text" id="phone" name="phone"
           value="<?= e($settings['phone'] ?? '') ?>">
  </div>

  <div class="form-group">
    <label for="email">E-mail</label>
    <input type="email" id="email" name="email"
           value="<?= e($settings['email'] ?? '') ?>">
  </div>

  <button type="submit" class="btn btn--primary">Gem ændringer</button>
</form>