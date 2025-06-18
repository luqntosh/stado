<?php

// require "../lib/errors.php";
require "../lib/utils.php";
require "../lib/router.php";
require "../lib/database.php";

$routes = [
    "/" => ["controller" => "cows.php", "method" => "GET", "auth" => true],
    "/signup" => ["controller" => "signup.php", "method" => "GET", "auth" => false],
    "/account-signup" => ["controller" => "account-signup.php", "method" => "POST", "auth" => false],
    "/account-login" => ["controller" => "account-login.php", "method" => "POST", "auth" => false],
    "/login" => ["controller" => "login.php", "method" => "GET", "auth" => false],
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

if ($user == $route["auth"]) {
    require "../controllers/{$route["controller"]}";
} elseif ($route["auth"]) {
    redirect("/login");
} else {
    redirect("/");
}
