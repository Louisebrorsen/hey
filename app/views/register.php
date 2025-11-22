
<main class="container" style="max-width:520px;margin:auto;padding:24px;">
  <h1>Opret bruger</h1>
  <form method="post" style="display:grid;gap:12px;">
     <?= csrf_input() ?>
    <label>Fornavn
      <input name="firstName" value="<?= e($member['firstName']) ?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
      <?php if (!empty($errors['firstName'])) echo '<div class="err">'.e($errors['firstName']).'</div>'; ?>
    </label>
    <label>Efternavn
      <input name="lastName" value="<?= e($member['lastName']) ?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
      <?php if (!empty($errors['lastName'])) echo '<div class="err">'.e($errors['lastName']).'</div>'; ?>
    </label>
    <label>Fødselsdato
  <input type="date" name="DOB">
</label>

<label>Køn
  <select name="gender">
    <option value="U">Uoplyst</option>
    <option value="F">F</option>
    <option value="M">M</option>
  </select>
</label>
    <label>Email
      <input name="email" type="email" value="<?= e($member['email']) ?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
      <?php if (!empty($errors['email'])) echo '<div class="err">'.e($errors['email']).'</div>'; ?>
    </label>
    <label>Adgangskode
      <input name="password" type="password" autocomplete="new-password">
      <?php if (!empty($errors['password'])) echo '<div class="err">'.e($errors['password']).'</div>'; ?>
    </label>
    <label>Gentag adgangskode
      <input name="confirm" type="password" autocomplete="new-password">
      <?php if (!empty($errors['confirm'])) echo '<div class="err">'.e($errors['confirm']).'</div>'; ?>
    </label>
    <button class="btn btn--primary">Opret</button>
  </form>

  <?php if ($result && !empty($result['ok'])): ?>
    <p style="color:#0f0;">Bruger oprettet — du er nu logget ind.</p>
  <?php elseif ($result && !empty($result['error'])): ?>
    <p style="color:#f66;">Fejl: <?= e($result['error']) ?></p>
  <?php endif; ?>
</main>