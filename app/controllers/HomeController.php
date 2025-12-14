<?php

class HomeController {
    public function index() {
        $_SESSION['hp_key'] = bin2hex(random_bytes(16));

        $nowPlaying = Movie::nowPlaying(6);
        $coming     = Movie::comingSoon(6);
        
        $db = Database::connect();
        $screeningRepo   = new ScreeningRepository($db);
        $todayScreenings = $screeningRepo->getTodayScreenings();
        $news = new NewsRepository($db);


        return [
            'view' => __DIR__ . '/../views/home.php',
            'data' => [
                'movies'          => Movie::all(),
                'nowPlaying'      => $nowPlaying,
                'comingSoon'      => $coming,
                'todayScreenings' => $todayScreenings,
                'news'            => $news->getAllNews(3),
            ],
        ];
    }
}