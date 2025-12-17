<?php

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function get(string $route, string $action): void
    {
        $this->routes['GET'][$route] = $action;
    }

    public function post(string $route, string $action): void
    {
        $this->routes['POST'][$route] = $action;
    }

    public function dispatch(): array
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_GET['url'] ?? '';
        $url = trim($url, '/');

        $action = $this->routes[$method][$url] ?? null;

        if (!$action) {
            http_response_code(404);
            return [
                'view' => null,
                'data' => [],
            ];
        }

        [$controllerName, $methodName] = explode('@', $action);

        if (!class_exists($controllerName)) {
            die("Controller '$controllerName' not found.");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $methodName)) {
            die("Method '$methodName' not found in controller '$controllerName'.");
        }

        $result = $controller->$methodName();

        if (!is_array($result)) {
            die("Controller method must return an array with 'view' and 'data'.");
        }

        return $result;
    }
}