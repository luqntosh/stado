<?php
declare(strict_types=1);
session_save_path("../tmp");
session_start();

// require "../lib/errors.php";
require "../lib/utils.php";
require "../lib/router.php";
require "../lib/session.php";
require "../lib/database.php";

$routes = [
    "/" => ["controller" => "cows.php", "method" => "GET", "auth" => true],
    "/signup" => ["controller" => "signup.php", "method" => "GET", "auth" => false],
    "/account" => ["controller" => "account.php", "method" => "GET", "auth" => true],
    "/account-create" => ["controller" => "account-create.php", "method" => "POST", "auth" => false],
    "/account-login" => ["controller" => "account-login.php", "method" => "POST", "auth" => false],
    "/login" => ["controller" => "login.php", "method" => "GET", "auth" => false],
    "/logout" => ["controller" => "logout.php", "method" => "GET", "auth" => true],
];

$path = parse_url($_SERVER["REQUEST_URI"])["path"];

$route = get_route($path, $routes);
if (!$route) {
    redirect("/");
}
if (!valid_request_method($route["method"])) {
    redirect("/");
}

$connection = get_connection();
$user = get_user($connection);
date_default_timezone_set("Europe/Warsaw");

if ($user == $route["auth"]) {
    require "../controllers/{$route["controller"]}";
} elseif ($route["auth"]) {
    redirect("/login");
} else {
    redirect("/");
}
