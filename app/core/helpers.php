<?php
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function url(string $route, array $params = []): string
{
    $query = http_build_query(array_merge(['url' => $route], $params));
    return 'index.php?' . $query;
}

function asset(string $path): string
{
   //gør assets mappen tilgængelig både lokalt og på simply
    return 'assets/' . ltrim($path, '/');
}

function cleanInput(string $data): string {
    $data = trim($data);
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    return $data;
}

function generateCSRFToken() 
{ if (empty($_SESSION['csrf_token'])) 
    { 
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
    } 
    return $_SESSION['csrf_token']; 
}

function csrf_input() {
    return '<input type="hidden" name="csrf_token" value="' . e(generateCSRFToken()) . '">';
}

define('PUBLIC_PATH', dirname(__DIR__, 2) . '/public_html');

function handle_poster_upload(string $title, ?array $file): ?string {
    // Ingen fil valgt
    if (!$file || empty($file['name'])) {
        return null;
    }

    $okTypes = [
        'image/jpeg'  => 'jpg',
        'image/jpg'   => 'jpg',
        'image/pjpeg' => 'jpg',
        'image/png'   => 'png',
        'image/webp'  => 'webp',
    ];

    $tmp = $file['tmp_name'] ?? '';
    if (!is_uploaded_file($tmp)) {
        return null;
    }

    // Prøv at finde rigtig mime-type, ellers brug $_FILES['type']
    $type = mime_content_type($tmp) ?: ($file['type'] ?? '');
    if (!isset($okTypes[$type])) {
        return null;
    }

    $ext = $okTypes[$type];

    // Mappe til plakater
    $dir = PUBLIC_PATH . '/uploads/posters';
    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }

    $safe = preg_replace('/[^a-z0-9_-]+/i', '-', strtolower($title));
    $safe = trim($safe, '-') ?: 'poster';

    $name = $safe . '-' . substr(sha1(uniqid('', true)), 0, 8) . '.' . $ext;
    $dest = $dir . '/' . $name;

    if (!move_uploaded_file($tmp, $dest)) {
        return null;
    }

    // relativ sti til brug i <img src="">
    return 'uploads/posters/' . $name;
}