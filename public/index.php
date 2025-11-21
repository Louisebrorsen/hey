<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once __DIR__ . '/../app/core/bootstrap.php';

$router = new Router();

// Hent alle routes fra en separat fil
require_once __DIR__ . '/../app/core/routes.php';

// Få info om hvilken controller/method der skal køres
$routeResult = $router->dispatch();

// Forvent at controller-metoden returnerer et array med 'view' og 'data'
$view = $routeResult['view'] ?? null;
$data = $routeResult['data'] ?? [];

// Hvis ingen view er defineret → 404
if (!$view) {
    http_response_code(404);
    echo '404 - View not found';
    exit;
}

// Gør data-keys til variabler: $movies, $movie, $screenings osv.
extract($data);

// Gem view-stien i en variabel layoutet kan bruge
$contentView = $view;

// Kald layoutet (som selv inkluderer header, footer og contentView)
require __DIR__ . '/../app/views/layout.php';