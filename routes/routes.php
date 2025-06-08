<?php
declare(strict_types=1);

function get_route($path, $routes): ?array
{
    if (array_key_exists($path, $routes)) {
        return $routes[$path];
    } else {
        return null;
    }
}

function redirect(string $path)
{
    header("Location: " . $path);
    die();
}

function valid_request_method($methods): bool
{
    if (
        isset($_SERVER["REQUEST_METHOD"]) &&
        in_array($_SERVER["REQUEST_METHOD"], $methods)
    ) {
        return true;
    }
    return false;
}
