<?php
declare(strict_types=1);

function get_connection(): PDO
{
    return new PDO("sqlite:" . __DIR__ . "/../app.db");
}

function get_user(PDO $connection, ?string $email = null): array|false
{
    if ($email === null) {
        if (!isset($_SESSION["user"])) {
            return false;
        }
        $email = $_SESSION["user"];
    }
    $statment = $connection->prepare("SELECT * FROM users where email = :email");
    $statment->execute(["email" => $email]);
    return $statment->fetch(PDO::FETCH_ASSOC);
}

function create_user(PDO $connection, array $data)
{
    extract($data);
    $statement = $connection->prepare(
        "INSERT INTO users(email, password, last_update, preg_check, dry_check, due_check) VALUES(:email, :password, :last_update, :preg_check, :dry_check, :due_check)"
    );
    return $statement->execute([
        ":email" => $email,
        ":password" => $password,
        ":last_update" => $last_update,
        ":preg_check" => $preg_check,
        ":dry_check" => $dry_check,
        ":due_check" => $due_check,
    ]);
}
