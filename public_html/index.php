<?php
session_start();
// Content Security Policy header
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; script-src 'self'; style-src 'self' 'unsafe-inline';");

require_once __DIR__ . '/../app/core/bootstrap.php';

$router = new Router();
$router->dispatch();

error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once __DIR__ . '/../app/core/bootstrap.php';

$router = new Router();


require_once __DIR__ . '/../app/core/routes.php';

$routeResult = $router->dispatch();

$view = $routeResult['view'] ?? null;
$data = $routeResult['data'] ?? [];

if (!$view) {
    http_response_code(404);
    echo '404 - View not found';
    exit;
}

extract($data);

$contentView = $view;

require __DIR__ . '/../app/views/layout.php';