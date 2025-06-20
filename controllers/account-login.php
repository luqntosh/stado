<?php

declare(strict_types=1);
require "../lib/validators.php";

if (!consume_token($_POST["token"])) {
    redirect("/login");
}
$error = ["Email lub hasło nie jest poprawne."];
if (!validate_email($_POST["email"])) {
    goto error_route;
}
if (!validate_password($_POST["password"])) {
    goto error_route;
}
if (!empty($errors)) {
    goto error_route;
}

$user = get_user($connection, $_POST["email"]);
if (!$user) {
    goto error_route;
}
if (!password_verify($_POST["password"], $user["password"])) {
    goto error_route;
}
$_SESSION["user"] = $_POST["email"];
redirect("/");

error_route:
set_form_data("login", ["email" => $_POST["email"]]);
set_flash_messages("login_errors", $error);
redirect("/login");
