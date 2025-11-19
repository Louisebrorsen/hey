<?php

class HomeController {
    public function index() {
        $_SESSION['hp_key'] = bin2hex(random_bytes(16));

        $nowPlaying = Movie::nowPlaying(6);
        $coming     = Movie::comingSoon(6);


        return [
            'view' => __DIR__ . '/../views/home.php',
            'data' => [
                'movies'     => Movie::all(),
                'nowPlaying' => $nowPlaying,
                'comingSoon'     => $coming,
            ],
        ];
    }
}