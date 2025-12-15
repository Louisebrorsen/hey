<?php
// Tab kan komme enten fra controllerens $data eller direkte fra querystring (?tab=...)
$tab  = $_GET['tab'] ?? ($data['tab'] ?? 'movie');
$base = __DIR__ . '/';
?>

<main class="admin-main container" style="padding:40px 20px;">
  <div class="admin-content">
    <h1>Admin</h1>

    <nav class="tabs">
      <a class="tablink <?= $tab === 'movie' ? 'is-active' : '' ?>" href="?url=admin">Film</a>
      <a class="tablink <?= $tab === 'rooms' ? 'is-active' : '' ?>" href="?url=admin/rooms">Sale & sæder</a>
      <a class="tablink <?= $tab === 'showtimes' ? 'is-active' : '' ?>" href="?url=admin/showtimes">Showtimes</a>
      <a class="tablink <?= $tab === 'allMovies' ? 'is-active' : '' ?>" href="?url=admin/allMovies">Alle film</a>
      <a class="tablink <?= $tab === 'cinemaInfo' ? 'is-active' : '' ?>" href="?url=admin/cinemaInfo">Biograf informationer</a>
      <a class="tablink <?= $tab === 'cinemaNews' ? 'is-active' : '' ?>" href="?url=admin/cinemaNews">Nyheder</a>
      <a class="tablink <?= $tab === 'invoice' ? 'is-active' : '' ?>" href="?url=admin&tab=invoice">Faktura</a>
    </nav>

    <?php
      switch ($tab) {
        case 'movie':
          include $base . 'movieAdd.php';
          break;

        case 'rooms':
          include $base . 'auditorium.php';
          break;

        case 'showtimes':
          include $base . 'screening.php';
          break;

        case 'allMovies':
          include $base . 'moviesList.php';
          break;

        case 'cinemaInfo':
          include $base . 'cinemaInfo.php';
          break;

        case 'cinemaNews':
          include $base . 'cinemaNews.php';
          break;

        case 'invoice':
          include $base . 'cinemaInvoice.php';
          break;
      }
    ?>
  </div>
</main>