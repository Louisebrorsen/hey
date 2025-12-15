<?php
/** @var array $invoice */
if (!$invoice) {
  echo '<p>Ingen faktura fundet.</p>';
  return;
}

$seatLabels = [];
foreach (($invoice['seats'] ?? []) as $seat) {
  $rowNo  = $seat['rowNo']  ?? null;
  $seatNo = $seat['seatNo'] ?? null;

  // Vis som fx: R1 - 4
  if ($rowNo !== null && $seatNo !== null) {
    $seatLabels[] = 'R' . (int)$rowNo . ' - ' . (int)$seatNo;
    continue;
  }

  // Fallback hvis data kommer i anden form
  if (!empty($seat['label'])) {
    $seatLabels[] = (string)$seat['label'];
  }
}

$totalSeatsSelected = count($invoice['seats'] ?? []);

$adults   = (int)($invoice['adults'] ?? $invoice['qty_adult'] ?? $invoice['adult_qty'] ?? $invoice['adult_tickets'] ?? $invoice['adultTickets'] ?? 0);
$children = (int)($invoice['children'] ?? $invoice['qty_child'] ?? $invoice['child_qty'] ?? $invoice['child_tickets'] ?? $invoice['childTickets'] ?? 0);
$seniors  = (int)($invoice['seniors'] ?? $invoice['qty_senior'] ?? $invoice['senior_qty'] ?? $invoice['senior_tickets'] ?? $invoice['seniorTickets'] ?? 0);

// Hvis DB ikke gemmer billet-typerne endnu, så brug antal valgte sæder som fallback
if ($adults + $children + $seniors === 0) {
  $adults = (int)($invoice['ticket_count'] ?? $totalSeatsSelected);
}
?>

<div class="invoice">
  <div class="invoice__header">
    <div>
      <h1>Faktura / Kvittering</h1>
      <p class="invoice__meta">
        Reservationsnr.: <strong>#<?= (int)$invoice['reservationID'] ?></strong><br>
        Reservationsdato: <?= date('d.m.Y H:i', strtotime((string)$invoice['reservation_date'])) ?>
      </p>
    </div>

    <div class="invoice__headerActions">
      
<a class="btn btn--ghost" href="?url=admin&tab=invoice">Tilbage</a>    </div>
  </div>

  <div class="invoice__grid">
    <div class="invoice__card">
      <h2>Film & forestilling</h2>

      <div class="invoice__kv">
        <div class="invoice__kvRow">
          <span class="invoice__label">Film</span>
          <span class="invoice__value"><?= htmlspecialchars((string)($invoice['title'] ?? '')) ?></span>
        </div>

        <div class="invoice__kvRow">
          <span class="invoice__label">Tidspunkt</span>
          <span class="invoice__value">
            <?= !empty($invoice['start_time']) ? date('d.m.Y H:i', strtotime((string)$invoice['start_time'])) : '—' ?>
          </span>
        </div>

        <div class="invoice__kvRow">
          <span class="invoice__label">Sal</span>
          <span class="invoice__value"><?= htmlspecialchars((string)($invoice['auditoriumNo'] ?? '—')) ?></span>
        </div>
      </div>
    </div>

    <div class="invoice__card">
      <h2>Billetter</h2>

      <div class="invoice__table">
        <div class="invoice__tRow invoice__tHead">
          <span>Type</span>
          <span class="invoice__tRight">Antal</span>
        </div>

        <div class="invoice__tRow">
          <span>Voksne</span>
          <span class="invoice__tRight"><?= $adults ?></span>
        </div>

        <div class="invoice__tRow">
          <span>Børn</span>
          <span class="invoice__tRight"><?= $children ?></span>
        </div>

        <div class="invoice__tRow">
          <span>Pensionister</span>
          <span class="invoice__tRight"><?= $seniors ?></span>
        </div>

        <div class="invoice__tRow">
          <span>Billetter i alt</span>
          <span class="invoice__tRight"><?= (int)($adults + $children + $seniors) ?></span>
        </div>

        <div class="invoice__tRow invoice__tTotal">
          <span>Total</span>
          <span class="invoice__tRight"><?= number_format((float)($invoice['total_price'] ?? 0), 2, ',', '.') ?> kr.</span>
        </div>
      </div>
    </div>

    <div class="invoice__card invoice__card--full">
      <h2>Valgte sæder</h2>
      <p class="invoice__seats"><?= implode(', ', $seatLabels) ?: 'Ingen sæder gemt på reservationen' ?></p>
      <p class="muted small" style="margin:10px 0 0;">
        Dette er en simuleret faktura/kvittering til eksamensprojektet.
      </p>
    </div>
  </div>
</div>