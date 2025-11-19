
<?php
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function url(string $path): string {
    // Sørger for at path altid starter med /
    $path = ltrim($path, '/');
    return '/' . $path;
}

function cleanInput(string $data): string {
    $data = trim($data);
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    return $data;
}