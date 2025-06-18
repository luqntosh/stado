<?php
declare(strict_types=1);

require "../lib/validators.php";

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

$user = get_user($connection, $_POST["email"]);
if ($user) {
    $_SESSION["signup_errors"] = ["Konto o tym adresie e-mail juz instnieje."];
    redirect("/signup");
}

$user = [
    "preg_check" => 75,
    "dry_check" => 80,
    "due_check" => 5,
];
$user["email"] = $_POST["email"];
$user["password"] = password_hash($_POST["password"], PASSWORD_BCRYPT);
$user["last_update"] = time();

$success = create_user($connection, $user);
if (!$success) {
    $_SESSION["signup_errors"] = ["Błąd podczas tworzenia konta! Spróbuj ponownie później."];
    redirect("/signup");
}
$_SESSION["user"] = $_POST["email"];
redirect("/");
