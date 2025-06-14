<?php

declare(strict_types=1);
session_start();

// require "../includes/errors.php";
require "../includes/utils.php";
require "../includes/request.php";
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
    "/add" => [
        "controller" => "add.php",
        "methods" => ["GET", "POST"],
        "auth" => true,
    ],
    "/del" => [
        "controller" => "del.php",
        "methods" => ["POST"],
        "auth" => true,
    ],
    "/login" => [
        "controller" => "login.php",
        "methods" => ["GET", "POST"],
        "auth" => false,
    ],
    "/account" => [
        "controller" => "account.php",
        "methods" => ["GET", "POST"],
        "auth" => true,
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

$connection = get_connection();
$connection->exec("PRAGMA foreign_keys=ON");
$user = get_user($connection);

if ($user == $route["auth"]) {
    require "../routes/" . $route["controller"];
} elseif ($route["auth"]) {
    redirect("/login");
} else {
    redirect("/");
}
