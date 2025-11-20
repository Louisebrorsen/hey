<!DOCTYPE html>
<html lang="da">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cinema – Biograf</title>
  <meta name="description" content="Biografbeskrivelse" />
  <link rel="stylesheet" href="<?= asset('style.css') ?>">
</head>
<body>
 <?php require __DIR__ . '/partials/header.php'; ?>

    <main>
        <?php
        if (isset($contentView) && file_exists($contentView)) {
            require $contentView;
        } else {
            echo '<p>View ikke fundet.</p>';
        }
        ?>
    </main>

    <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>