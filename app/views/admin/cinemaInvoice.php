<h2>Fakturaer</h2>

<form method="get" action="">
  <input type="hidden" name="url" value="admin">
  <input type="hidden" name="tab" value="invoice">

  <label>
    Søg på reservationsnr.
    <input type="number" name="reservationID" placeholder="skriv reservationsnr">
  </label>

  <button class="btn">Åbn faktura</button>
</form>

<?php if (!empty($_GET['reservationID'])): ?>
  <p style="margin-top:12px;">
    <a class="btn btn--primary"
       href="?url=admin/invoice&reservationID=<?= (int)$_GET['reservationID'] ?>">
       Se faktura for reservation #<?= (int)$_GET['reservationID'] ?>
    </a>
  </p>
<?php endif; ?>