<?php
declare(strict_types=1);
session_save_path("../tmp");
session_set_cookie_params(0);
session_start();

// require "../lib/errors.php";
require "../lib/utils.php";
require "../lib/router.php";
require "../lib/session.php";
require "../lib/database.php";

$routes = [
    "/" => ["controller" => "cow/cows.php", "method" => "GET", "auth" => true],
    "/signup" => ["controller" => "login/signup.php", "method" => "GET", "auth" => false],
    "/account" => ["controller" => "account/account.php", "method" => "GET", "auth" => true],
    "/account-create" => ["controller" => "account/account-create.php", "method" => "POST", "auth" => false],
    "/account-login" => ["controller" => "account/account-login.php", "method" => "POST", "auth" => false],
    "/login" => ["controller" => "login/login.php", "method" => "GET", "auth" => false],
    "/logout" => ["controller" => "login/logout.php", "method" => "GET", "auth" => true],
    "/cow" => ["controller" => "cow/cow.php", "method" => "GET", "auth" => true],
    "/cow-form" => ["controller" => "cow/cow-form.php", "method" => "GET", "auth" => true],
    "/cow-add" => ["controller" => "cow/cow-add.php", "method" => "POST", "auth" => true],
    "/cow-update" => ["controller" => "cow/cow-update.php", "method" => "POST", "auth" => true],
    "/cow-delete" => ["controller" => "cow/cow-delete.php", "method" => "POST", "auth" => true],
    "/cow-event" => ["controller" => "cow/cow-event.php", "method" => "POST", "auth" => true],
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

if ((bool) $user !== $route["auth"]) {
    if ($user) {
        redirect("/");
    } else {
        redirect("/login");
    }
}
require "../controllers/{$route["controller"]}";
