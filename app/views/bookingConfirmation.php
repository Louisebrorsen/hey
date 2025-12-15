<?php
/** @var array      $screening */
/** @var int        $reservationID */
/** @var array      $ticketSummary */
/** @var int|float  $totalPrice */
/** @var array      $selectedSeats */
?>
<section class="booking-confirmation">
    <h1>Tak for din reservation 🎉</h1>

    <p>Din reservation er nu gemt i systemet. Nedenfor kan du se en oversigt:</p>

    <div class="booking-confirmation__grid">
        <!-- Film & forestilling -->
        <div class="booking-confirmation__box">
            <h2>Film &amp; forestilling</h2>

            <p>
                <strong>Film:</strong>
                <?= e($screening['title'] ?? '') ?>
            </p>

            <p>
                <strong>Dato:</strong>
                <?php
                if (!empty($screening['screening_time'])) {
                    $dt = new DateTime($screening['screening_time']);
                    echo e($dt->format('d.m.Y'));
                }
                ?>
            </p>

            <p>
                <strong>Tid:</strong>
                <?php
                if (!empty($screening['screening_time'])) {
                    $dt = new DateTime($screening['screening_time']);
                    echo e($dt->format('H:i'));
                }
                ?>
            </p>

            <p>
                <strong>Sal:</strong>
                <?= e($screening['auditoriumID'] ?? '') ?>
            </p>

            <p>
                <strong>Reservationsnr.:</strong>
                #<?= e($reservationID ?? '') ?>
            </p>
        </div>

        <!-- Billetter -->
        <div class="booking-confirmation__box">
            <h2>Billetter</h2>

            <ul>
                <?php if (!empty($ticketSummary['adults'])): ?>
                    <li><?= (int)$ticketSummary['adults'] ?> × Voksen</li>
                <?php endif; ?>

                <?php if (!empty($ticketSummary['children'])): ?>
                    <li><?= (int)$ticketSummary['children'] ?> × Barn</li>
                <?php endif; ?>

                <?php if (!empty($ticketSummary['seniors'])): ?>
                    <li><?= (int)$ticketSummary['seniors'] ?> × Pensionist</li>
                <?php endif; ?>
            </ul>

            <p>
                <strong>I alt:</strong>
                <?= e(number_format((float)$totalPrice, 0, ',', '.')) ?> kr.
            </p>
        </div>

        <!-- Sæder -->
        <div class="booking-confirmation__box">
            <h2>Valgte sæder</h2>

            <?php if (!empty($selectedSeats) && is_array($selectedSeats)): ?>
                <p><?= e(implode(', ', $selectedSeats)) ?></p>
            <?php else: ?>
                <p>Ingen sædeinformation tilgængelig.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="booking-confirmation__actions">
        <p>
            Dette er en simuleret betalingsside til eksamensprojektet.
            I en rigtig løsning ville du her blive sendt videre til en ekstern betalingsløsning.
        </p>

        <div>
            <a href="<?= url('profile') ?>" class="btn2">Gå til min profil</a>
            <a href="<?= url('') ?>" class="btn-link">Til forsiden</a>
        </div>
    </div>
</section>