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


        $posterRel = handle_poster_upload($title, $_FILES['poster'] ?? null);

        var_dump($_FILES['poster'] ?? null, $posterRel, PUBLIC_PATH);
exit;

        // Hvis upload fejler, skal poster_url IKKE være null (db-fejl)
        if ($posterRel === null) {
            $posterRel = ''; // tom streng godkendes af databasen
        }

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

        /* header('Location: ?url=admin/allMovies');
        exit; */
    }

    public function movieEditForm(): array
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['message'] = 'Ugyldigt film-ID.';
            header('Location: ?url=admin/allMovies');
            exit;
        }

        $movie = $this->movieRepo->getById($id);
        if (!$movie) {
            $_SESSION['message'] = 'Filmen blev ikke fundet.';
            header('Location: ?url=admin/allMovies');
            exit;
        }

        return [
            'view' => __DIR__ . '/../views/admin/movieEdit.php',
            'data' => [
                'movie' => $movie,
            ],
        ];
    }

    public function movieUpdate(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ?url=admin/allMovies');
        exit;
    }

    // Evt. verify_csrf(); hvis du vil have det med nu
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        $_SESSION['message'] = 'Ugyldigt film-ID.';
        header('Location: ?url=admin/allMovies');
        exit;
    }

    $movie = $this->movieRepo->getById($id);
    if (!$movie) {
        $_SESSION['message'] = 'Filmen findes ikke længere.';
        header('Location: ?url=admin/allMovies');
        exit;
    }

    $title   = trim($_POST['title'] ?? '');
    $runtime = (int)($_POST['duration_min'] ?? 0);

    if ($title === '' || $runtime <= 0) {
        $_SESSION['message'] = 'Titel og spilletid skal udfyldes.';
        header('Location: ?url=admin/movie/edit&id=' . $id);
        exit;
    }

    // Start med den gamle poster
    $posterRel = $movie['poster_url'] ?? '';

    // Tjek om der er uploadet en ny
    $newPoster = handle_poster_upload($title, $_FILES['poster'] ?? null);
    if ($newPoster) {
        // valgfrit: slet gammel fil fra disk
        if (!empty($posterRel) && is_file(PUBLIC_PATH . '/' . $posterRel)) {
            @unlink(PUBLIC_PATH . '/' . $posterRel);
        }
        $posterRel = $newPoster;
    }

    $data = [
        'title'        => $title,
        'poster_url'   => $posterRel,
        'description'  => trim($_POST['description'] ?? ''),
        'released'     => trim($_POST['released'] ?? ''),
        'duration_min' => $runtime,
        'age_limit'    => (int)($_POST['age_limit'] ?? 0),
    ];

    try {
        $ok = $this->movieRepo->update($id, $data);

        if ($ok) {
            $_SESSION['message'] = 'Filmen blev opdateret.';
        } else {
            $_SESSION['message'] = 'Filmen kunne ikke opdateres.';
        }
    } catch (Throwable $e) {
        $_SESSION['message'] = 'DB-fejl: ' . $e->getMessage();
    }

    header('Location: ?url=admin/allMovies');
    exit;
}




    
    // public function updateMovie(): void { ... }
    // public function createShowtime(): void { ... }
    // osv.
}
