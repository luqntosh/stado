<?php
declare(strict_types=1);

require "../includes/filters.php";

function render_login(array $error_messages)
{
    require "../templates/login.php";
}

function handle_get_request()
{
    $msgs = get_flash_messages("login_errors");
    render_login($msgs);
}

function handle_post_request(PDO $connection)
{
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
        $_SESSION["signup_errors"] = [$msg];
        redirect("/login");
    }
    if (!password_verify($_POST["password"], $user["password"])) {
        $_SESSION["signup_errors"] = [$msg];
        redirect("/login");
    }
    $_SESSION["user"] = $_POST["email"];
    redirect("/");
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    handle_get_request();
} else {
    handle_post_request($connection);
}

?>
