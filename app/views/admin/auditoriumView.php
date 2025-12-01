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

// Gruppér sæder per række (rowNo)
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

<style>
.auditorium-layout {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 60px;
    width: 90%;
    max-width: 1200px;
    margin: 20px auto 40px;
}

.auditorium-info {
    width: 220px;
    padding-top: 10px;
    font-size: 14px;
    line-height: 1.6;
}

.auditorium {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.auditorium-screen {
    width: 70%;
    max-width: 500px;
    text-align: center;
    padding: 6px 0;
    border-radius: 999px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.2);
    font-size: 13px;
    opacity: 0.8;
}

.auditorium-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 4px;
}

.auditorium-row-label {
    width: 40px;
    text-align: right;
    font-size: 13px;
    opacity: 0.7;
}

.auditorium-row-seats {
    display: flex;
    gap: 4px;
    flex-wrap: nowrap;
}

.auditorium-seat {
    width: 26px;
    height: 26px;
    border-radius: 6px;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
}
</style>