<?php

declare(strict_types=1);
// require "../includes/errors.php";
require "../routes/routes.php";

// session_start();
$routes = [
    "/" => [
        "controller" => "cows.php",
        "methods" => ["GET"],
        "auth" => false,
    ],
    "/cows" => [
        "controller" => "cows.php",
        "methods" => ["GET"],
        "auth" => true,
    ],
    "/cow" => [
        "controller" => "cow.php",
        "methods" => ["GET", "POST"],
        "auth" => true,
    ],
];

$path = parse_url($_SERVER["REQUEST_URI"])["path"];

$route = get_route($path, $routes);
if (!$route) {
    redirect("/");
}
if (!valid_request_method($route["methods"])) {
    redirect("/");
}

require "../routes/" . $route["controller"];
