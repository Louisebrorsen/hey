<?php

class AdminScreeningController
{
    private ScreeningRepository $screeningRepo;
    private MovieRepository $movieRepo;
    private AuditoriumRepository $auditoriumRepo;

    public function __construct()
    {
        $db = Database::connect();

        $this->screeningRepo  = new ScreeningRepository($db);
        $this->movieRepo      = new MovieRepository($db);
        $this->auditoriumRepo = new AuditoriumRepository($db);
    }

    public function index(): array
    {
        $screenings  = $this->screeningRepo->getAllScreeningsWithDetails();
        $nowPlaying  = $this->movieRepo->getNowPlaying();
        $comingSoon  = $this->movieRepo->getComingSoon();
        $auditoriums = $this->auditoriumRepo->getAll();

        return [
            'view' => __DIR__ . '/../views/admin/admin.php',
            'data' => [
                'tab'         => 'showtimes',
                'screenings'  => $screenings,
                'nowPlaying'  => $nowPlaying,
                'comingSoon'  => $comingSoon,
                'auditoriums' => $auditoriums,
            ],
        ];
    }

    public function store(): array
    {
        $movieID        = (int)($_POST['movieID'] ?? 0);
    $auditoriumID   = (int)($_POST['auditoriumID'] ?? 0);
    $screening_time = $_POST['screening_time'] ?? '';
    $price          = (float)($_POST['price'] ?? 0);

    if (!empty($screening_time)) {
        $screening_time = str_replace('T', ' ', $screening_time) . ':00';
    }

    if ($movieID && $auditoriumID && $screening_time && $price > 0) {
        if (!$this->screeningRepo->hasConflict($auditoriumID, $screening_time)) {
            $this->screeningRepo->createScreening($movieID, $auditoriumID, $screening_time, $price);
        } else {
            // Handle conflict, e.g., set an error message or log it
        }
    }

        // Hent opdaterede data efter oprettelse
        $screenings  = $this->screeningRepo->getAllScreeningsWithDetails();
        $nowPlaying  = $this->movieRepo->getNowPlaying();
        $comingSoon  = $this->movieRepo->getComingSoon();
        $auditoriums = $this->auditoriumRepo->getAll();

        return [
            'view' => __DIR__ . '/../views/admin/admin.php',
            'data' => [
                'tab'         => 'showtimes',
                'screenings'  => $screenings,
                'nowPlaying'  => $nowPlaying,
                'comingSoon'  => $comingSoon,
                'auditoriums' => $auditoriums,
            ],
        ];
    }
}