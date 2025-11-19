<?php

class HomeController {
    public function index() {
        $_SESSION['hp_key'] = bin2hex(random_bytes(16));

        $nowPlaying = Movie::nowPlaying();
        $coming     = Movie::comingSoon();

        require_once __DIR__ . '/../views/home.php';
    }
}