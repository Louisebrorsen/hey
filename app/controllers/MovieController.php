<?php

class MovieController
{
    public function index(): array
    {
        $movies = Movie::all();

        return [
            'view' => __DIR__ . '/../views/movie.php',
            'data' => [
                'movies' => $movies,
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

        $movie = Movie::find((int)$id);
        $screenings = Screening::findByMovie((int)$id);

        return [
            'view' => __DIR__ . '/../views/movie.php',
            'data' => [
                'movie' => $movie,
                'screenings' => $screenings,
            ],
        ];
    }
}