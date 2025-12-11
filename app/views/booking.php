<?php

/** @var array $screening */
/** @var array $seats */
/** @var array $reservedSeatIds */
/** @var string|null $message */
/** @var int|null $adults */
/** @var int|null $children */
/** @var int|null $seniors */

$basePrice   = isset($screening['price']) ? (int)$screening['price'] : 0;
// Du kan justere de her multiplikatorer, hvis du vil have andre rabatter
$adultPrice  = $basePrice;                 // fuld pris
$childPrice  = (int) round($basePrice * 0.75); // fx 25% rabat
$seniorPrice = (int) round($basePrice * 0.85); // fx 15% rabat
?>
<main id="main-content"
  data-adult-price="<?= $adultPrice ?>"
  data-child-price="<?= $childPrice ?>"
  data-senior-price="<?= $seniorPrice ?>">
  <?php if (!empty($message)): ?>
    <div class="alert alert--success">
      <?= e($message) ?>
    </div>
  <?php endif; ?>

  <form class="booking-form" action="<?= url('booking') ?>" method="post">
    <input type="hidden" name="screeningID" value="<?= (int)$screening['screeningID'] ?>">

    <!-- Film + forestillingsinfo -->
    <div>
      <div class="movie-info">
        <h2 class="movie-title"><?= e($screening['movie_title']) ?></h2>
        <p class="showtime-info">
          <?= e(date('d.m.Y', strtotime($screening['screening_time']))) ?>
          kl. <?= e(date('H:i', strtotime($screening['screening_time']))) ?> –
          Sal <?= e($screening['auditorium_name']) ?>
        </p>
      </div>

      <!-- Billetter -->
      <fieldset>
        <legend>Vælg billetter</legend>

        <div class="form-group">
          <label for="qty_adult">Voksne (<?= $adultPrice ?> kr.)</label>
          <select id="qty_adult" name="qty_adult">
            <?php
            $adultVal = isset($adults) ? (int)$adults : 1;
            for ($i = 0; $i <= 10; $i++): ?>
              <option value="<?= $i ?>" <?= $i === $adultVal ? 'selected' : '' ?>>
                <?= $i ?>
              </option>
            <?php endfor; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="qty_child">Børn (<?= $childPrice ?> kr.)</label>
          <select id="qty_child" name="qty_child">
            <?php
            $childVal = isset($children) ? (int)$children : 0;
            for ($i = 0; $i <= 10; $i++): ?>
              <option value="<?= $i ?>" <?= $i === $childVal ? 'selected' : '' ?>>
                <?= $i ?>
              </option>
            <?php endfor; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="qty_senior">Pensionister (<?= $seniorPrice ?> kr.)</label>
          <select id="qty_senior" name="qty_senior">
            <?php
            $seniorVal = isset($seniors) ? (int)$seniors : 0;
            for ($i = 0; $i <= 10; $i++): ?>
              <option value="<?= $i ?>" <?= $i === $seniorVal ? 'selected' : '' ?>>
                <?= $i ?>
              </option>
            <?php endfor; ?>
          </select>
        </div>
      </fieldset>

      <!-- Sæder -->
      <?php
      // Gruppér sæder per row
      $seatRows = [];

      foreach ($seats as $seat) {
        $rowNumber = (int)$seat['rowNo'];
        $seatRows[$rowNumber][] = $seat;
      }

      ksort($seatRows); // sortér rækker i rækkefølge
      ?>

      <div class="auditorium">
        <div class="seat-selection-info">
          <p id="seat-counter">Du har endnu ikke valgt nogen sæder.</p>
        </div>
        <div class="auditorium-screen">Skærm</div>

        <?php foreach ($seatRows as $rowNumber => $rowSeats): ?>
          <div class="auditorium-row">
            <div class="auditorium-row-label">R<?= $rowNumber ?></div>

            <div class="auditorium-row-seats">
              <?php foreach ($rowSeats as $seat): ?>
                <?php
                $seatId = (int)$seat['seatID'];
                $seatNo = (int)$seat['seatNo'];
                $isReserved = in_array($seatId, $reservedSeatIds ?? []);
                ?>

                <div class="auditorium-seat">
                  <input
                    type="checkbox"
                    id="seat-<?= $seatId ?>"
                    name="seats[]"
                    value="<?= $seatId ?>"
                    <?= $isReserved ? 'disabled' : '' ?>>
                  <label for="seat-<?= $seatId ?>"><?= $seatNo ?></label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Ordreoversigt -->
    <div class="summary">
      <h2>Ordreoversigt</h2>

      <?php
      $adultCount  = isset($adults) ? (int)$adults : 1;
      $childCount  = isset($children) ? (int)$children : 0;
      $seniorCount = isset($seniors) ? (int)$seniors : 0;

      $total =
        $adultCount  * $adultPrice +
        $childCount  * $childPrice +
        $seniorCount * $seniorPrice;
      ?>

      <div class="summary-item">
        <span>Voksne:</span>
        <span id="summary-adults"><?= $adultCount ?> x <?= $adultPrice ?> kr.</span>
      </div>
      <div class="summary-item">
        <span>Børn:</span>
        <span id="summary-children"><?= $childCount ?> x <?= $childPrice ?> kr.</span>
      </div>
      <div class="summary-item">
        <span>Pensionister:</span>
        <span id="summary-seniors"><?= $seniorCount ?> x <?= $seniorPrice ?> kr.</span>
      </div>

      <div class="summary-item total">
        <span>I alt:</span>
        <span id="summary-total"><?= $total ?> kr.</span>
      </div>

      <button type="submit" class="btn2">Bekræft booking</button>
    </div>
  </form>

</main>