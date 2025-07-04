<?php
declare(strict_types=1);

require "../lib/validators.php";

if (!consume_token($_POST["token"])) {
    redirect("/signup");
}

$errors = [];
if (!validate_email($_POST["email"])) {
    $errors[] = "Adress email nie jest poprawny.";
}
if (!validate_password($_POST["password"])) {
    $errors[] = "Hasło musi zawierać co najmniej 8 znaków.";
}
if (!empty($errors)) {
    goto error_route;
}

$user = get_user($connection, $_POST["email"]);
if ($user) {
    $errors[] = "Konto o tym adresie e-mail juz instnieje.";
    goto error_route;
}

$user = [
    "ges_period" => 281,
    "preg_check" => 75,
    "dry_check" => 90,
    "due_check" => 14,
];
$user["email"] = $_POST["email"];
$user["password"] = password_hash($_POST["password"], PASSWORD_BCRYPT);
$user["last_update"] = time();

$user_data = [];

foreach ($user as $k => $v) {
    $user_data[":" . $k] = $v;
}

$success = create_user($connection, $user_data);
if (!$success) {
    $errors[] = "Błąd podczas tworzenia konta! Spróbuj ponownie później.";
    goto error_route;
}
$_SESSION["user"] = $_POST["email"];
redirect("/");

error_route:
set_flash_messages("signup_errors", $errors);
set_form_data("signup", ["email" => $_POST["email"]]);
redirect("/signup");
