<?php
class BookingController
{
    private ScreeningRepository $screeningRepository;
    private SeatRepository $seatRepository;

    public function __construct()
    {
        $db = Database::connect();
        $this->screeningRepository = new ScreeningRepository($db);
        $this->seatRepository      = new SeatRepository($db);
    }

    public function show(): array
    {
        $screeningID = $_GET['screeningID'] ?? null;

        if (!$screeningID) {
            http_response_code(400);
            die('Missing screening ID.');
        }

        $screening = $this->screeningRepository->getScreeningById((int)$screeningID);

        if (!$screening) {
            http_response_code(404);
            die('Screening not found.');
        }

        $auditoriumID    = (int)$screening['auditoriumID'];
        $seats           = $this->seatRepository->getByAuditorium($auditoriumID);
        $reservedSeatIds = $this->seatRepository->getReservedSeatIdsByScreening((int)$screeningID);

        return [
            'view' => __DIR__ . '/../views/booking.php',
            'data' => [
                'screening'       => $screening,
                'seats'           => $seats,
                'reservedSeatIds' => $reservedSeatIds,
            ],
        ];
    }

    public function bookSeats(): array
    {
        $screeningID   = isset($_POST['screeningID']) ? (int)$_POST['screeningID'] : 0;
        $selectedSeats = $_POST['seats'] ?? [];

        $adults   = isset($_POST['qty_adult']) ? (int)$_POST['qty_adult'] : 0;
        $children = isset($_POST['qty_child']) ? (int)$_POST['qty_child'] : 0;
        $seniors  = isset($_POST['qty_senior']) ? (int)$_POST['qty_senior'] : 0;

        $reservationID = null;
        $totalPrice    = 0;

        // find logged in user – tilpas til din sessionstruktur hvis nødvendigt
        $userID = $_SESSION['user']['userID'] ?? ($_SESSION['userID'] ?? null);

        if (!$screeningID) {
            http_response_code(400);
            $message = 'Der mangler en gyldig forestilling.';

            return [
                'view' => __DIR__ . '/../views/booking.php',
                'data' => [
                    'screening'       => null,
                    'seats'           => [],
                    'reservedSeatIds' => [],
                    'message'         => $message,
                    'adults'          => $adults,
                    'children'        => $children,
                    'seniors'         => $seniors,
                ],
            ];
        }

        $screening = $this->screeningRepository->getScreeningById($screeningID);

        if (!$screening) {
            http_response_code(404);
            $message = 'Den valgte forestilling blev ikke fundet.';

            return [
                'view' => __DIR__ . '/../views/booking.php',
                'data' => [
                    'screening'       => null,
                    'seats'           => [],
                    'reservedSeatIds' => [],
                    'message'         => $message,
                    'adults'          => $adults,
                    'children'        => $children,
                    'seniors'         => $seniors,
                ],
            ];
        }

        $auditoriumID    = (int)$screening['auditoriumID'];
        $seats           = $this->seatRepository->getByAuditorium($auditoriumID);
        $reservedSeatIds = $this->seatRepository->getReservedSeatIdsByScreening($screeningID);

        // normaliser valgte sæder til ints
        $selectedSeatIds = array_map('intval', $selectedSeats);

        // server-side validering
        $totalTickets = $adults + $children + $seniors;

        if ($totalTickets <= 0) {
            $message = 'Du skal vælge mindst én billet.';

            return [
                'view' => __DIR__ . '/../views/booking.php',
                'data' => [
                    'screening'       => $screening,
                    'seats'           => $seats,
                    'reservedSeatIds' => $reservedSeatIds,
                    'message'         => $message,
                    'adults'          => $adults,
                    'children'        => $children,
                    'seniors'         => $seniors,
                ],
            ];
        }

        if (empty($selectedSeatIds)) {
            $message = 'Du har ikke valgt nogen sæder. Vælg venligst mindst ét sæde.';

            return [
                'view' => __DIR__ . '/../views/booking.php',
                'data' => [
                    'screening'       => $screening,
                    'seats'           => $seats,
                    'reservedSeatIds' => $reservedSeatIds,
                    'message'         => $message,
                    'adults'          => $adults,
                    'children'        => $children,
                    'seniors'         => $seniors,
                ],
            ];
        }

        // tjek for dobbeltbookede sæder
        $conflicting = array_intersect($reservedSeatIds, $selectedSeatIds);

        if (!empty($conflicting)) {
            $message = 'Et eller flere af de valgte sæder er allerede reserveret. Vælg venligst andre pladser.';

            return [
                'view' => __DIR__ . '/../views/booking.php',
                'data' => [
                    'screening'       => $screening,
                    'seats'           => $seats,
                    'reservedSeatIds' => $reservedSeatIds,
                    'message'         => $message,
                    'adults'          => $adults,
                    'children'        => $children,
                    'seniors'         => $seniors,
                ],
            ];
        }

        if (!$userID) {
            $message = 'Du skal være logget ind for at reservere billetter.';

            return [
                'view' => __DIR__ . '/../views/booking.php',
                'data' => [
                    'screening'       => $screening,
                    'seats'           => $seats,
                    'reservedSeatIds' => $reservedSeatIds,
                    'message'         => $message,
                    'adults'          => $adults,
                    'children'        => $children,
                    'seniors'         => $seniors,
                ],
            ];
        }

        // beregn dynamiske priser baseret på screeningens pris
        $basePrice   = isset($screening['price']) ? (int)$screening['price'] : 0;
        $adultPrice  = $basePrice;
        $childPrice  = (int) round($basePrice * 0.75);
        $seniorPrice = (int) round($basePrice * 0.85);

        $totalPrice =
            $adults   * $adultPrice +
            $children * $childPrice +
            $seniors  * $seniorPrice;

        try {
            $pdo = Database::connect();
            $pdo->beginTransaction();

            // indsæt reservation
            $stmt = $pdo->prepare("
                INSERT INTO reservation (userID, screeningID, reservation_date, total_price)
                VALUES (:userID, :screeningID, NOW(), :total_price)
            ");
            $stmt->execute([
                ':userID'       => $userID,
                ':screeningID'  => $screeningID,
                ':total_price'  => $totalPrice,
            ]);

            $reservationID = (int)$pdo->lastInsertId();

            // indsæt seatReservation-rækker
            $seatStmt = $pdo->prepare("
                INSERT INTO seatReservation (reservationID, seatID)
                VALUES (:reservationID, :seatID)
            ");

            foreach ($selectedSeatIds as $seatID) {
                $seatStmt->execute([
                    ':reservationID' => $reservationID,
                    ':seatID'        => $seatID,
                ]);
            }

            $pdo->commit();

            // hent opdateret liste over reserverede sæder til visning
            $reservedSeatIds = $this->seatRepository->getReservedSeatIdsByScreening($screeningID);

            // byg ticket-summary til confirmation-view
            $ticketSummary = [
                'adults'   => $adults,
                'children' => $children,
                'seniors'  => $seniors,
            ];

            return [
                'view' => __DIR__ . '/../views/bookingConfirmation.php',
                'data' => [
                    'screening'       => $screening,
                    'seats'           => $seats,
                    'reservedSeatIds' => $reservedSeatIds,
                    'adults'          => $adults,
                    'children'        => $children,
                    'seniors'         => $seniors,
                    'reservationID'   => $reservationID,
                    'totalPrice'      => $totalPrice,
                    'ticketSummary'   => $ticketSummary,
                    'selectedSeats'   => $selectedSeatIds,
                ],
            ];
        } catch (\PDOException $e) {
            if (isset($pdo)) {
                $pdo->rollBack();
            }
            $message = 'Der opstod en fejl under gemning af reservationen. Prøv igen senere.';

            return [
                'view' => __DIR__ . '/../views/booking.php',
                'data' => [
                    'screening'       => $screening,
                    'seats'           => $seats,
                    'reservedSeatIds' => $reservedSeatIds,
                    'message'         => $message,
                    'adults'          => $adults,
                    'children'        => $children,
                    'seniors'         => $seniors,
                ],
            ];
        }
    }
}