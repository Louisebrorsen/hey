<?php

class MovieController
{
    public function index(): array
    {
        $movies = Movie::all();
        $nowPlaying = Movie::nowPlaying();
        $coming     = Movie::comingSoon(); 


        return [
            'view' => __DIR__ . '/../views/movies.php',
            'data' => [
                'movies' => $movies,
                'nowPlaying' => $nowPlaying,
                'comingSoon'     => $coming,
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
            'view' => __DIR__ . '/../views/movieDetail.php',
            'data' => [
                'movie' => $movie,
                'screenings' => $screenings,
            ],
        ];
    }
}