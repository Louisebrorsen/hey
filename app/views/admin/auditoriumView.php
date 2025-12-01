<h1>Sal: <?= e($room['name']) ?></h1>

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

<p>
    Rækker: <?= $rows ?><br>
    Sæder pr. række: <?= $seatsPerRow ?><br>
    I alt: <?= count($seats) ?> sæder
</p>

<hr>

<h2>Sædeoversigt</h2>

<div class="seat-grid">
<?php
$currentRow = 1;

foreach ($seats as $seat):
    if ($seat['rowNo'] != $currentRow):
        echo "<br>"; // ny række
        $currentRow = $seat['rowNo'];
    endif;

    echo "<span class='seat'>".
         $seat['rowNo'] . "-" . $seat['seatNo'].
         "</span>";
endforeach;
?>
</div>

<a href="?url=admin/rooms" class="btn btn--secondary">Tilbage</a>



