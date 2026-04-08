<?php

namespace Services;

require_once __DIR__ . '/../configs/settings.php';

class Router
{
    private string $controller;
    private string $method;

    public function __construct(string $page) {
        if (!array_key_exists($page, AVAILABLE_ROUTES)) {
            $page = '404';
        }

        $this->controller = AVAILABLE_ROUTES[$page]['controller'];
        $this->method = AVAILABLE_ROUTES[$page]['method'];
    }

    public function dispatch(): void {
        $instance = 'Controllers\\' . $this->controller;
        $controller = new $instance();
        $method = $this->method;
        $controller->$method();
    }
}
