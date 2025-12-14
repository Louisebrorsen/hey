<?php
class AdminController
{
    private AuthService $auth;
    private MovieRepository $movieRepo;
    private ScreeningRepository $screeningRepo;

    private AuditoriumRepository $auditoriumRepo;

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
        $this->auditoriumRepo = new AuditoriumRepository($db);
    }


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
                'rooms' => $this->auditoriumRepo->getAll(),
            ],
        ];
    }

    public function showtimes(): array
    {
        return [
            'view' => __DIR__ . '/../views/admin/admin.php',
            'data' => [
                'tab'       => 'showtimes',
                'showtimes' => $this->screeningRepo->getAllScreeningsWithDetails(),
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

    public function cinemaInfo(): array
    {
        // Hent eksisterende biograf-info (1 række) så formularen kan udfyldes med aktuelle værdier
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM site_settings ORDER BY id ASC LIMIT 1");
        $settings = $stmt ? ($stmt->fetch(PDO::FETCH_ASSOC) ?: []) : [];

        return [
            'view' => __DIR__ . '/../views/admin/admin.php',
            'data' => [
                'tab'      => 'cinemaInfo',
                'settings' => $settings,
            ],
        ];
    }
    public function cinemaNews(): array
    {
        return [
            'view' => __DIR__ . '/../views/admin/admin.php',
            'data' => [
                'tab'    => 'cinemaNews',
            ],
        ];
    }
}
