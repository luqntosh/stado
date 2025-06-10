<?php

declare(strict_types=1);
session_start();

// require "../includes/errors.php";
require "../includes/request.php";
require "../includes/auth.php";
require "../includes/database.php";
require "../includes/session.php";

$routes = [
    "/" => [
        "controller" => "cows.php",
        "methods" => ["GET"],
        "auth" => true,
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
    "/login" => [
        "controller" => "login.php",
        "methods" => ["GET", "POST"],
        "auth" => false,
    ],
    "/signup" => [
        "controller" => "signup.php",
        "methods" => ["GET", "POST"],
        "auth" => false,
    ],
    "/logout" => [
        "controller" => "logout.php",
        "methods" => ["GET"],
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

$auth = auth();
if (!$auth and $route["auth"]) {
    redirect("/login");
} elseif ($auth and !$route["auth"]) {
    redirect("/");
}

$connection = get_connection();
if ($auth) {
    $user = get_user($connection);
} else {
    $user = null;
}

require "../routes/" . $route["controller"];
