<?php

class MovieController
{
    public function index(): array
    {
        // HENT DE SORTEREDE FILM HER
        $nowPlaying = Movie::nowPlaying();   // Film der er udgivet
        $comingSoon = Movie::comingSoon();   // Film der endnu ikke er udgivet

        return [
            'view' => __DIR__ . '/../views/home.php',
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

        $movie = Movie::find((int)$id);
        $screenings = Screening::findByMovie((int)$id);

        return [
            'view' => __DIR__ . '/../views/home.php',
            'data' => [
                'movie' => $movie,
                'screenings' => $screenings,
            ],
        ];
    }
}