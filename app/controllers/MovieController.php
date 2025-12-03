<?php
require_once __DIR__ . '/../core/bootstrap.php';
class MovieController
{
    private MovieRepository $movieRepository;
    private ScreeningRepository $screeningRepository;
    private AuditoriumRepository $auditoriumRepository;

    public function __construct()
    {
        $db = Database::connect(); // din Database singleton

        $this->movieRepository     = new MovieRepository($db);
        $this->screeningRepository = new ScreeningRepository($db);
    }

    public function index(): array
    {
        $screenings   = $this->screeningRepository->getAllScreeningsWithDetails();
        $nowPlaying   = $this->movieRepository->getNowPlaying();
        $comingSoon   = $this->movieRepository->getComingSoon();
        $auditoriums  = $this->auditoriumRepository->getAll();

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
    public function show(): array
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            die('Missing movie ID.');
        }

        $movie      = $this->movieRepository->getById((int)$id);
        $screenings = $this->screeningRepository->getByMovie((int)$id);

        return [
            'view' => __DIR__ . '/../views/movieDetail.php',
            'data' => [
                'movie'      => $movie,
                'screenings' => $screenings,
            ],
        ];
    }
}
