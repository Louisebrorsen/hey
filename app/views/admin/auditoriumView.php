<?php
$rows = 0;
$seatsPerRow = 0;
$rowCounts = [];

foreach ($seats as $seat) {
    $row = (int)$seat['rowNo'];         
    $rowCounts[$row] = ($rowCounts[$row] ?? 0) + 1;
}

if (!empty($rowCounts)) {
    $rows = max(array_keys($rowCounts));     
    $seatsPerRow = max($rowCounts);         
}
?>

<main class="admin-main container" style="padding:40px 20px;">
  <div class="admin-content">
    <h1> <?= e($room['name'] ?? '') ?></h1>

    <p>
      <a href="?url=admin/rooms/edit&id=<?= (int)$room['auditoriumID'] ?>" class="btn btn--primary">Rediger sal</a>
      <a href="?url=admin/rooms" class="btn btn--ghost">Tilbage til saloversigt</a>
    </p>
  </div>

<h2>Sædeoversigt</h2>

<?php

$seatRows = [];

foreach ($seats as $seat) {
    $rowNumber = (int)$seat['rowNo'];
    $seatRows[$rowNumber][] = $seat;
}

ksort($seatRows); // R1, R2, R3 ...
?>

<div class="auditorium-layout">
    <div class="auditorium-info">
        <p>Rækker: <?= $rows ?></p>
        <p>Sæder pr. række: <?= $seatsPerRow ?></p>
        <p>I alt: <?= count($seats) ?> sæder</p>
    </div>

    <div class="auditorium">
        <div class="auditorium-screen">Lærred</div>

        <?php foreach ($seatRows as $rowNumber => $rowSeats): ?>
            <div class="auditorium-row">
                <div class="auditorium-row-label">R<?= $rowNumber ?></div>

                <div class="auditorium-row-seats">
                    <?php foreach ($rowSeats as $seat): ?>
                        <div class="auditorium-seat">
                            <?= (int)$seat['seatNo'] ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<a href="?url=admin/rooms" class="btn btn--secondary" style="margin-top:20px;">Tilbage</a>

