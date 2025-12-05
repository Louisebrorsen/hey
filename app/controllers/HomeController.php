<?php

class HomeController {
    public function index() {
        $_SESSION['hp_key'] = bin2hex(random_bytes(16));

        // Hent film til forsiden (som før)
        $nowPlaying = Movie::nowPlaying(6);
        $coming     = Movie::comingSoon(6);
        

        // Hent dagens forestillinger via ScreeningRepository
        $db = Database::connect();
        $screeningRepo   = new ScreeningRepository($db);
        $todayScreenings = $screeningRepo->getTodayScreenings();
        

        return [
            'view' => __DIR__ . '/../views/home.php',
            'data' => [
                'movies'          => Movie::all(),
                'nowPlaying'      => $nowPlaying,
                'comingSoon'      => $coming,
                'todayScreenings' => $todayScreenings,
            ],
        ];
    }
}