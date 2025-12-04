<?php
class MovieController
{
    private MovieRepository $movieRepository;
    private ScreeningRepository $screeningRepository;

    public function __construct()
    {
        $db = Database::connect(); // din Database singleton

        $this->movieRepository     = new MovieRepository($db);
        $this->screeningRepository = new ScreeningRepository($db);
    }

    public function index(): array
    {
        $nowPlaying = $this->movieRepository->getNowPlaying();
        $comingSoon = $this->movieRepository->getComingSoon();

        return [
            'view' => __DIR__ . '/../views/movies.php',
            'data' => [
                'nowPlaying' => $nowPlaying,
                'comingSoon' => $comingSoon,
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