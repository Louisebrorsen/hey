<?php

class AdminRoomsController
{
    private AuditoriumRepository $auditoriumRepo;

    public function __construct()
    {
        // Hent PDO via din Database-helper
        $pdo = Database::connect();
        $this->auditoriumRepo = new AuditoriumRepository($pdo);
    }

    public function rooms(): array
    {
        $rooms = $this->auditoriumRepo->getAll();

        return [
            'view' => __DIR__ . '/../views/admin/auditorium.php',
            'data' => ['rooms' => $rooms],
        ];
    }

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

        $this->auditoriumRepo->create($name);
        $_SESSION['message'] = 'Sal oprettet.';

        header('Location: ?url=admin/rooms');
        exit;
    }

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

        return [
            'view' => __DIR__ . '/../views/admin/auditoriumEdit.php',
            'data' => ['room' => $room],
        ];
    }

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

        $this->auditoriumRepo->delete($id);
        $_SESSION['message'] = 'Salen blev slettet.';

        header('Location: ?url=admin/rooms');
        exit;
    }
}
