<?php
$user = $data['user'] ?? [];
$role=$user['role'] ?? '';
$firstName = $user['firstName'] ?? '';
$lastName  = $user['lastName'] ?? '';
$name      = trim($firstName . ' ' . $lastName);
$email     = $user['email'] ?? '';
var_dump($_SESSION['user']);
?>

<main class="profile">
  <div class="wrap">
    <section class="p-grid">
      <div class="stack" style="display:grid; gap:18px;">
        <article class="p-card">
          <div class="p-card__body">
            <h2>Konto</h2>
            <div class="kv">
              <div class="row"><div class="label">Navn</div><div class="value"><?= e($name ?: '—') ?></div></div>
              <div class="row"><div class="label">Email</div><div class="value"><?= e($email ?: '—') ?></div></div>
            </div>
            
          </div>
        </article>

        <article class="p-card">
          <div class="p-card__body">
            <h2>Seneste bookinger</h2>
            <?php /* Placeholder — kan udskiftes med rigtig liste */ ?>
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
            <div style="margin-top:12px;">
              <a class="btn btn--primary" href="<?= url('?page=home#today') ?>">Find forestillinger</a>
            </div>
          </div>
        </article>
      </div>

      <!-- Right column: Stats + Preferences -->
      <div class="stack" style="display:grid; gap:18px;">
        <article class="p-card">
          <div class="p-card__body">
            <h2>Din status</h2>
            <div class="stats">
              <div class="stat"><div class="stat__num">0</div><div class="stat__label">Aktive</div></div>
              <div class="stat"><div class="stat__num">0</div><div class="stat__label">Kommende</div></div>
              <div class="stat"><div class="stat__num">0</div><div class="stat__label">Tidligere</div></div>
            </div>
          </div>
        </article>

        <article class="p-card">
          <div class="p-card__body">
            <h2>Præferencer</h2>
            <form method="post" action="#" class="pref-form">
              <?= csrf_input() ?>
              <div class="pref-grid">
                <label>
                  Foretrukket sprog<br>
                  <select name="pref_lang">
                    <option value="auto">Auto</option>
                    <option <?= !empty($_SESSION['pref_lang']) && $_SESSION['pref_lang']==='Dansk' ? 'selected' : '' ?>>Dansk</option>
                    <option <?= !empty($_SESSION['pref_lang']) && $_SESSION['pref_lang']==='Engelsk' ? 'selected' : '' ?>>Engelsk</option>
                  </select>
                </label>
                <label>
                  Notifikationer<br>
                  <select name="pref_notif">
                    <option value="email" <?= (($_SESSION['pref_notif'] ?? 'email')==='email') ? 'selected' : '' ?>>Email</option>
                    <option value="none"  <?= (($_SESSION['pref_notif'] ?? 'email')==='none')  ? 'selected' : '' ?>>Ingen</option>
                  </select>
                </label>
              </div>
              <button class="btn btn--ghost" type="submit">Gem præferencer</button>
            </form>
          </div>
        </article>
      </div>
    </section>
  </div>
</main>