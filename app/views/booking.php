<?php
/** @var array $screening */
/** @var array $seats */
/** @var array $reservedSeatIds */
?>

<main class="booking container">
  <h1>Vælg pladser</h1>

  <section class="booking__info">
    <h2><?= e($screening['movie_title']) ?></h2>
    <p>
      Sal <?= e($screening['auditorium_name']) ?><br>
      <?= e(date('d.m.Y H:i', strtotime($screening['screening_time']))) ?><br>
      Pris: DKK <?= e($screening['price']) ?>
    </p>
  </section>

  <form method="post" action="<?= url('booking') ?>" class="booking__form">
    <input type="hidden" name="screeningID" value="<?= (int)$screening['screeningID'] ?>">

    <div class="booking__seats">
      <div class="screen">LÆRRED</div>

      <?php
      // Gruppér sæder pr. række baseret på rowNo
      $rows = [];
      foreach ($seats as $seat) {
          $rows[$seat['rowNo']][] = $seat;
      }
      ?>

      <?php foreach ($rows as $rowNo => $rowSeats): ?>
        <div class="seat-row">
          <span class="seat-row__label">Række <?= e($rowNo) ?></span>

          <?php foreach ($rowSeats as $seat): ?>
            <?php $isReserved = in_array($seat['seatID'], $reservedSeatIds, true); ?>
            <label class="seat <?= $isReserved ? 'seat--reserved' : '' ?>">
              <input
                type="checkbox"
                name="seats[]"
                value="<?= (int)$seat['seatID'] ?>"
                <?= $isReserved ? 'disabled' : '' ?>
              >
              <span><?= e($seat['seatNo']) ?></span>
            </label>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="booking__actions">
      <button class="btn btn--primary" type="submit">Bekræft valg</button>
    </div>
  </form>
</main>