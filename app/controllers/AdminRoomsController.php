<?php

class AdminRoomsController
{
    private AuditoriumRepository $auditoriumRepo;
    private SeatRepository $seatRepo;

    public function __construct()
    {
        $pdo = Database::connect();
        $this->auditoriumRepo = new AuditoriumRepository($pdo);
        $this->seatRepo       = new SeatRepository($pdo);
    }

    /** Opret sal (kaldes fra form i auditorium.php) */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=admin/rooms');
            exit;
        }

        $name = trim($_POST['room_name'] ?? '');

        if ($name === '') {
            $_SESSION['message'] = 'Skriv et navn på salen.';
            header('Location: ?url=admin/rooms');
            exit;
        }

        // Opret ny sal
        $this->auditoriumRepo->create($name);

        $_SESSION['message'] = 'Sal oprettet.';
        header('Location: ?url=admin/rooms');
        exit;
    }

    /** Vis rediger-form for en sal */
    public function edit(): array
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['message'] = 'Ugyldigt sal-ID.';
            header('Location: ?url=admin/rooms');
            exit;
        }

        $room = $this->auditoriumRepo->getById($id);
        if (!$room) {
            $_SESSION['message'] = 'Salen blev ikke fundet.';
            header('Location: ?url=admin/rooms');
            exit;
        }

        // Hvis du på et tidspunkt vil vise sæder her:
        // $seats = $this->seatRepo->getByAuditorium($id);

        return [
            'view' => __DIR__ . '/../views/admin/auditoriumEdit.php',
            'data' => [
                'room' => $room,
                // 'seats' => $seats ?? []
            ],
        ];
    }

    /** Gem ændringer til sal */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=admin/rooms');
            exit;
        }

        $id   = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['room_name'] ?? '');

        if ($id <= 0 || $name === '') {
            $_SESSION['message'] = 'Ugyldigt input.';
            header('Location: ?url=admin/rooms');
            exit;
        }

        $this->auditoriumRepo->update($id, $name);
        $_SESSION['message'] = 'Salen blev opdateret.';

        header('Location: ?url=admin/rooms');
        exit;
    }

    /** Slet sal */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=admin/rooms');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['message'] = 'Ugyldigt sal-ID.';
            header('Location: ?url=admin/rooms');
            exit;
        }

        // Hvis du vil være ekstra flink: slet også sæder
        $this->seatRepo->deleteByAuditorium($id);

        $this->auditoriumRepo->delete($id);
        $_SESSION['message'] = 'Salen blev slettet.';

        header('Location: ?url=admin/rooms');
        exit;
    }

    /** Generér sæder til en sal (rækker x sæder pr række) */
    public function generateSeats()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=admin/rooms');
            exit;
        }

        $auditoriumID = (int)($_POST['auditoriumID'] ?? 0);
        $rows         = (int)($_POST['rows'] ?? 0);
        $perRow       = (int)($_POST['seats_per_row'] ?? 0);

        if ($auditoriumID <= 0 || $rows <= 0 || $perRow <= 0) {
            $_SESSION['message'] = 'Ugyldigt input til sæder.';
            header('Location: ?url=admin/rooms');
            exit;
        }

        $this->seatRepo->deleteByAuditorium($auditoriumID);

        for ($r = 1; $r <= $rows; $r++) {
            for ($s = 1; $s <= $perRow; $s++) {
                $this->seatRepo->create($auditoriumID, $r, $s);
            }
        }

        $_SESSION['message'] = "Sæder genereret: {$rows} rækker × {$perRow} sæder.";
        header('Location: ?url=admin/rooms');
        exit;
    }

    public function view()
{
    $id = (int)($_GET['id'] ?? 0);

    if ($id <= 0) {
        header("Location: ?url=admin/rooms");
        exit;
    }

    $room = $this->auditoriumRepo->find($id);
    $seats = $this->seatRepo->getByAuditorium($id);

    if (!$room) {
        $_SESSION['message'] = "Sal findes ikke.";
        header("Location: ?url=admin/rooms");
        exit;
    }

    return [
        'view' => __DIR__ . '/../views/admin/auditoriumView.php',
        'data' => [
            'room'  => $room,
            'seats' => $seats
        ]
    ];
}
}
