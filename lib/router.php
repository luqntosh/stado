<?php

declare(strict_types=1);

function get_route(string $path, array $routes): array
{
    if (array_key_exists($path, $routes)) {
        return $routes[$path];
    } else {
        return [];
    }
}

function redirect(string $path)
{
    header("Location: " . $path);
    die();
}

function valid_request_method(string $method): bool
{
    return isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === $method;
}
