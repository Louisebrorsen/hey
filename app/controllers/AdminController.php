<?php
class AdminController
{
    private AuthService $auth;
    private MovieRepository $movieRepo;
    private ScreeningRepository $screeningRepo;

    public function __construct()
    {
        $db = Database::connect(); 

        $this->auth = new AuthService($db);

        // Admin protection
        if (!$this->auth->isAdmin()) {
            header("Location: ?url=login");
            exit;
        }

        $this->movieRepo     = new MovieRepository($db);
        $this->screeningRepo = new ScreeningRepository($db);
    }

    // Standard-tab: Film (opret ny)
    public function index(): array
    {
        return [
            'view' => __DIR__ . '/../views/admin/admin.php',
            'data' => [
                'tab'    => 'movie',
            ],
        ];
    }

    public function rooms(): array
    {
        return [
            'view' => __DIR__ . '/../views/admin/admin.php',
            'data' => [
                'tab' => 'rooms',
            ],
        ];
    }

    public function showtimes(): array
    {
        return [
            'view' => __DIR__ . '/../views/admin/admin.php',
            'data' => [
                'tab'       => 'showtimes',
                'showtimes' => $this->screeningRepo->getAll(), // hvis du bruger det
            ],
        ];
    }

    public function allMovies(): array
    {
        return [
            'view' => __DIR__ . '/../views/admin/admin.php',
            'data' => [
                'tab'    => 'allMovies',
                'movies' => $this->movieRepo->getAll(),
            ],
        ];
    }
}