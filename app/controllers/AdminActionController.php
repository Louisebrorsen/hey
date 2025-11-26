<?php

class AdminActionsController
{
    private AuthService $auth;
    private MovieRepository $movieRepo;
    private ScreeningRepository $screeningRepo;

    public function __construct()
    {
        $db = Database::connect();

        $this->auth = new AuthService($db);
        if (!$this->auth->isAdmin()) {
            header("Location: ?url=login");
            exit;
        }

        $this->movieRepo     = new MovieRepository($db);
        $this->screeningRepo = new ScreeningRepository($db);
    }

    
   public function createMovie(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ?url=admin');
        exit;
    }

    $posterFile = $_FILES['poster'] ?? null;
    $posterName = null;

    if ($posterFile && $posterFile['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/pjpeg', 'image/jpg', 'image/webp'];
        
        if (!in_array($posterFile['type'], $allowedTypes)) {
            $_SESSION['message'] = 'Ugyldig filtype til plakat.';
            header('Location: ?url=admin');
            exit;
        }

        if ($posterFile['size'] > 3 * 1024 * 1024) {
            $_SESSION['message'] = 'Plakatfilen er for stor (maks 3MB).';
            header('Location: ?url=admin');
            exit;
        }

        $posterName = uniqid('poster_') . '_' . basename($posterFile['name']);

        $uploadDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $dest = $uploadDir . $posterName;
        move_uploaded_file($posterFile['tmp_name'], $dest);
    }

    
    $data = $_POST;
    $data['poster_url'] = $posterName; 

    $id = $this->movieRepo->create($data);

    if ($id > 0) {
        $_SESSION['message'] = 'Filmen blev oprettet.';
    } else {
        $_SESSION['message'] = 'Filmen kunne ikke oprettes.';
    }

    header('Location: ?url=admin/allMovies');
    exit;
}

    // Her kan du senere tilføje:
    // public function deleteMovie(): void { ... }
    // public function updateMovie(): void { ... }
    // public function createShowtime(): void { ... }
    // osv.
}