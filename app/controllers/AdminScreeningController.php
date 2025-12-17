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
        $nowPlaying  = $this->movieRepo->getNowPlaying();
        $comingSoon  = $this->movieRepo->getComingSoon();
        $auditoriums = $this->auditoriumRepo->getAll();
        $screenings  = $this->screeningRepo->getUpcomingScreeningsWithDetails();
        $pastScreenings = $this->screeningRepo->getPasttScreeningsWithDetails();

        return [
            'view' => __DIR__ . '/../views/admin/admin.php',
            'data' => [
                'tab'         => 'showtimes',
                'screenings'  => $screenings,
                'nowPlaying'  => $nowPlaying,
                'comingSoon'  => $comingSoon,
                'auditoriums' => $auditoriums,
                'pastScreenings' => $pastScreenings,
            ],
        ];
    }

    public function store(): array
    {
        $movieID        = (int)($_POST['movieID'] ?? 0);
        $auditoriumID   = (int)($_POST['auditoriumID'] ?? 0);
        $screening_time = $_POST['screening_time'] ?? '';
        $price          = (float)($_POST['price'] ?? 0);

        $error = null;

        if (!empty($screening_time)) {
            $screening_time = str_replace('T', ' ', $screening_time) . ':00';
        }

        if ($movieID && $auditoriumID && $screening_time && $price > 0) {
            $created = $this->screeningRepo->createScreening(
                $movieID,
                $auditoriumID,
                $screening_time,
                $price
            );

            if (!$created) {
                $error = 'Der findes allerede en forestilling i denne sal på dette tidspunkt.';
            }
        }

        // Hent opdaterede data
        $nowPlaying  = $this->movieRepo->getNowPlaying();
        $comingSoon  = $this->movieRepo->getComingSoon();
        $auditoriums = $this->auditoriumRepo->getAll();
        $screenings  = $this->screeningRepo->getUpcomingScreeningsWithDetails();
        $pastScreenings = $this->screeningRepo->getPasttScreeningsWithDetails();

        return [
            'view' => __DIR__ . '/../views/admin/admin.php',
            'data' => [
                'tab'         => 'showtimes',
                'screenings'  => $screenings,
                'nowPlaying'  => $nowPlaying,
                'comingSoon'  => $comingSoon,
                'auditoriums' => $auditoriums,
                'error'       => $error,
                'pastScreenings' => $pastScreenings,
            ],
        ];
    }
    public function delete(): array
    {
        $id = (int)($_POST['id'] ?? 0);

        if ($id > 0) {
            $this->screeningRepo->deleteScreening($id);
        }

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
                'error'       => null,
            ],
        ];
    }
}
