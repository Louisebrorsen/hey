
<?php
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function url(string $route, array $params = []): string
{
    $query = http_build_query(array_merge(['url' => $route], $params));
    return 'index.php?' . $query;
}

function cleanInput(string $data): string {
    $data = trim($data);
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    return $data;
}

