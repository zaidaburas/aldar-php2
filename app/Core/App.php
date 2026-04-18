<?php

namespace App\Core;

class App
{
    public function __construct(private array $routes)
    {
    }

    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes as [$routeMethod, $routeUri, $action]) {
            $normalizedRoute = rtrim($routeUri, '/') ?: '/';

            if ($method === $routeMethod && $uri === $normalizedRoute) {
                [$controller, $handler] = explode('@', $action);
                $class = 'App\\Controllers\\' . $controller;

                if (!class_exists($class)) {
                    http_response_code(500);
                    exit('Controller not found.');
                }

                $instance = new $class();
                $instance->$handler();
                return;
            }
        }

        http_response_code(404);
        echo '404 | الصفحة غير موجودة';
    }
}
