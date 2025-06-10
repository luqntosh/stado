<?php
declare(strict_types=1);
require "../includes/filters.php";
require "../includes/session.php";
require "../includes/database.php";

function render_signup(array $error_messages)
{
    require "../templates/signup.php";
}

function handle_get_request()
{
    $msgs = get_flash_messages("signup_errors");
    render_signup($msgs);
}

function handle_post_request()
{
    $errors = [];
    if (!validate_email($_POST["email"])) {
        $errors[] = "Adress email nie jest poprawny.";
    }
    if (!validate_password($_POST["password"])) {
        $errors[] = "Hasło musi zawierać co najmniej 8 znaków.";
    }
    if (!empty($errors)) {
        $_SESSION["signup_errors"] = $errors;
        redirect("/signup");
    }

    $connection = get_connection();
    $user = get_user($connection, $_POST["email"]);
    if ($user) {
        $_SESSION["signup_errors"] = [
            "Konto o tym adresie e-mail juz instnieje.",
        ];
        redirect("/signup");
    }

    $user = require "../includes/account_defaults.php";
    $user["email"] = $_POST["email"];
    $user["password"] = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $user["last_update"] = time();

    $success = create_user($connection, $user);
    if (!$success) {
        $_SESSION["signup_errors"] = [
            "Błąd podczas tworzenia konta. Spróbój ponownie później.",
        ];
        redirect("/signup");
    }
    $_SESSION["user"] = $_POST["email"];
    redirect("/");
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    handle_get_request();
} else {
    handle_post_request();
}

?>
