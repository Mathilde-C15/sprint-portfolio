<?php


use Services\Router;

session_start();

spl_autoload_register(function (string $classname): void {
    $path = lcfirst(str_replace('\\', '/', $classname));
    $filename = __DIR__ . '/' . $path . '.php';

    if (file_exists($filename)) {
        require_once $filename;
    }
});

$page = $_GET['page'] ?? '/';

$router = new Router($page);
$router->dispatch();
