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

    public function bookSeats(): void
    {
        $screeningID = $_POST['screeningID'] ?? null;
        $selectedSeats = $_POST['seats'] ?? [];

        if (!$screeningID || empty($selectedSeats)) {
            http_response_code(400);
            die('Missing screening ID or no seats selected.');
        }

        // Her ville du normalt gemme reservationen i databasen.
        // For nu, bare bekræft valget.

        echo "Du har reserveret følgende sæder for screening ID " . e($screeningID) . ": " . e(implode(', ', $selectedSeats));
    }
}