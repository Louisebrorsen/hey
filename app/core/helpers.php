
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
