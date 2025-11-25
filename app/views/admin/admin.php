<?php

$tab = $data['tab'] ?? 'movie';
$base = __DIR__ . '/';
?>
 
<main class="admin-main container" style="padding:40px 20px;">
  <div class="admin-content">
    <h1>Admin </h1>

    <nav class="tabs">
  <a class="tablink <?= $tab === 'movie' ? 'is-active' : '' ?>" href="?url=admin">Film</a>

  <a class="tablink <?= $tab === 'rooms' ? 'is-active' : '' ?>" href="?url=admin/rooms">Sale & sæder</a>

  <a class="tablink <?= $tab === 'showtimes' ? 'is-active' : '' ?>" href="?url=admin/showtimes">Showtimes</a>

  <a class="tablink <?= $tab === 'allMovies' ? 'is-active' : '' ?>" href="?url=admin/allMovies">Alle film</a>
</nav>


    <?php if ($tab === 'movie'): ?>
            <?php include $base . 'movieAdd.php'; ?>

        <?php elseif ($tab === 'rooms'): ?>
            <?php include $base . 'auditorium.php'; ?>

        <?php elseif ($tab === 'showtimes'): ?>
            <?php include $base . 'screening.php'; ?>

        <?php elseif ($tab === 'allMovies'): ?>
            <?php include $base . 'moviesList.php'; ?>

        <?php else: ?>
            <p>Ukendt tab.</p>
        <?php endif; ?>
  </div>
</main>
   


  

 



<!-- <div style="margin:12px 0; padding:12px; border-radius:10px; background:#103f2c; color:#d7ffef;">
    Din besked vises her (fx "Filmen er oprettet").
  </div>

  
  <div style="margin:12px 0; padding:12px; border-radius:10px; background:#103f2c;color:#d7ffef;">
    Her kan en succes- eller fejlbesked stå.
  </div>
 -->