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

  public function movieCreateForm(): array
    {
        return [
            'view' => __DIR__ . '/../views/admin/movieAdd.php',
            'data' => []
        ];
    }

     public function movieCreate(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ?url=admin/allMovies');
        exit;
    }

    $title   = trim($_POST['title'] ?? '');
    $runtime = (int)($_POST['duration_min'] ?? 0);

    if ($title === '' || $runtime <= 0) {
        $_SESSION['message'] = 'Titel og spilletid skal udfyldes.';
        header('Location: ?url=admin');
        exit;
    }

    
    $posterRel = '';

    $data = [
        'title'        => $title,
        'poster_url'   => $posterRel,
        'description'  => trim($_POST['description'] ?? ''),
        'released'     => trim($_POST['released'] ?? ''),
        'duration_min' => $runtime,
        'age_limit'    => (int)($_POST['age_limit'] ?? 0),
    ];

   try {
    $id = $this->movieRepo->create($data);

    if ($id > 0) {
        $_SESSION['message'] = 'Filmen blev oprettet.';
    } else {
        $_SESSION['message'] = 'Filmen blev IKKE oprettet.';
    }
} catch (Throwable $e) {
    $_SESSION['message'] = 'DB-fejl: ' . $e->getMessage();
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