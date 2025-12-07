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

        if (!$screeningID) {
            http_response_code(400);
            die('Missing screening ID.');
        }

        $screening = $this->screeningRepository->getScreeningById($screeningID);

        if (!$screening) {
            http_response_code(404);
            die('Screening not found.');
        }

        $auditoriumID    = (int)$screening['auditoriumID'];
        $seats           = $this->seatRepository->getByAuditorium($auditoriumID);
        $reservedSeatIds = $this->seatRepository->getReservedSeatIdsByScreening($screeningID);

        // Her ville du normalt gemme reservationen i databasen og opdatere reserverede sæder.
        // I denne version nøjes vi med at vise en bekræftelsesbesked i UI'et.
        if (empty($selectedSeats)) {
            $message = 'Du har ikke valgt nogen sæder. Vælg venligst mindst ét sæde.';
        } else {
            $message = 'Din reservation er registreret (demo). Du har valgt sæder: ' . implode(', ', $selectedSeats);
        }

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