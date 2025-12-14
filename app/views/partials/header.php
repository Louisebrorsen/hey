<header>
  <div class="container nav">
    <a href="<?= url('') ?>" class="brand" aria-label="Forside">
      <span class="brand__logo" aria-hidden="true"></span>
      <span>Cinema</span>
    </a>

    <nav aria-label="Hovednavigation" class="menu">
      <a href="<?= url('') ?>">I biografen</a>
      <a href="<?= url('') ?>#today">Dagens forestillinger</a>
      <a href="<?= url('') ?>#coming">Kommende film</a>
      <a href="<?= url('') ?>#contact">Kontakt</a>
      <a href="<?= url('news') ?>">Nyheder</a>
      <?php if (isset($_SESSION['user'])): ?>
        <a href="?url=profile">Min profil</a>
        <a href="?url=logout">Log ud</a>
      <?php else: ?>
        <a href="?url=login">Log ind</a>
      <?php endif; ?>
    </nav>

    <details class="navdrop">
      <summary aria-label="Åbn menu">
        <span class="hamb"><span></span></span>
      </summary>

      <div class="drawer" role="menu">
        <a role="menuitem" href="<?= url('') ?>">I biografen</a>
        <a role="menuitem" href="<?= url('') ?>#today">Dagens forestillinger</a>
        <a role="menuitem" href="<?= url('') ?>#coming">Kommende film</a>
        <a role="menuitem" href="<?= url('') ?>#contact">Kontakt</a>
        <?php if (isset($_SESSION['user'])): ?>
          <a href="?url=profile">Min profil</a>
          <a href="?url=logout">Log ud</a>
        <?php else: ?>
          <a href="?url=login">Log ind</a>
        <?php endif; ?>
      </div>
    </details>
  </div>
</header>