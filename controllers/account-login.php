<?php

declare(strict_types=1);
require "../lib/validators.php";

if (!consume_token($_POST["token"])) {
    redirect("/login");
}
$errors = [];
$msg = "Email lub hasło nie jest poprawne.";
if (!validate_email($_POST["email"])) {
    $errors[] = $msg;
}
if (!validate_password($_POST["password"])) {
    $errors[] = $msg;
}
if (!empty($errors)) {
    $_SESSION["login_errors"] = $errors;
    redirect("/login");
}

$user = get_user($connection, $_POST["email"]);
if (!$user) {
    $_SESSION["login_errors"] = [$msg];
    redirect("/login");
}
if (!password_verify($_POST["password"], $user["password"])) {
    $_SESSION["signup_errors"] = [$msg];
    redirect("/login");
}
$_SESSION["user"] = $_POST["email"];
redirect("/");
