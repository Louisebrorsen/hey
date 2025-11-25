<?php
require_once __DIR__ . '/../core/bootstrap.php';
class AdminMovieController
{
    private MovieRepository $movieRepo;

    public function __construct()
    {
        $db = Database::connect();
        $this->movieRepo = new MovieRepository($db);
    }

    public function index(): array
    {
        $movies = $this->movieRepo->getAll();

        return [
            'view' => __DIR__ . '/../views/admin/movies.php',
            'data' => ['movies' => $movies],
        ];
    }

}