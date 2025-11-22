
<main class="container" style="padding:40px 20px; max-width:480px; margin:auto; text-align:left;">
    
  <h1>Login</h1>
  <p>Indtast din email og adgangskode for at logge ind.</p>
    
  <?php if (!empty($_SESSION['flash_error'])): ?>
    <div style="margin:12px 0; padding:12px; border-radius:10px; background:#402020; color:#ffd6d6;">
      <?= e($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
    </div>
  <?php endif; ?>

  <form method="post" style="display:grid; gap:12px;">
    <?= csrf_input() ?>
    <input type="hidden" name="form" value="login">

    <label>
      Email<br>
      <input type="email" name="email" placeholder="email" required style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
    </label>

    <label>
      Adgangskode<br>
      <input type="password" name="password" placeholder="adgangskode" required style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(255,255,255,.2); background:rgba(0,0,0,.1); color:inherit;">
    </label>

    <button type="submit" class="btn btn--primary">Log ind</button>

  </form>

    <div style="margin-top: 16px; text-align:center;">
      <a href="?url=register" class="btn btn--secondary" style="display:inline-block; padding:10px 20px; border-radius:10px; background:rgba(255,255,255,0.1); color:#fff; text-decoration:none;">Har du ikke en bruger? Opret her</a>
    </div>


</main>