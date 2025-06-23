<?php
declare(strict_types=1);

function get_connection(): PDO
{
    return new PDO("sqlite:" . __DIR__ . "/../app.db");
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

function create_cow(PDO $connection, array $cow_data)
{
    $statement = $connection->prepare(
        "INSERT INTO cows(cow_id, name, ins_date, status, owner_id, due_date, next_event) VALUES(:id, :name, :ins_date, :status, :owner_id, :due_date, :next_event)"
    );
    return $statement->execute($cow_data);
}

function get_cow(PDO $connection, int $user_id, string $cow_id): array
{
    $statement = $connection->prepare("SELECT * FROM cows WHERE cow_id = :id and owner_id = :owner_id");
    $statement->execute([":id" => $cow_id, ":owner_id" => $user_id]);
    $cow = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$cow) {
        return [];
    }
    return $cow;
}

function get_cows(PDO $connection, int $user_id): array
{
    $statement = $connection->prepare("SELECT * FROM cows WHERE owner_id = :user_id");
    $statement->execute([":user_id" => $user_id]);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (!$result) {
        return [];
    }
    return $result;
}

function update_cow(PDO $connection, array $cow_data): bool
{
    unset($cow_data[":cow_id"]);
    unset($cow_data[":name"]);
    $statement = $connection->prepare(
        "UPDATE cows SET ins_date = :ins_date, status= :status, due_date= :due_date, next_event= :next_event WHERE id = :id and owner_id = :owner_id"
    );
    return $statement->execute($cow_data);
}

function get_cows_info(PDO $connection, int $user_id) {}

function add_event(PDO $connection, array $event_data): bool
{
    $statement = $connection->prepare(
        "INSERT INTO events(cow_id, date, event, text) VALUES(:cow_id, :date, :event, :text)"
    );
    return $statement->execute($event_data);
}

function get_old_events(PDO $connection, int $cow_id): array
{
    $statement = $connection->prepare(
        "SELECT id, cow_id, date, event, text FROM events WHERE cow_id = :id ORDER BY id DESC"
    );
    $statement->execute(["id" => $cow_id]);
    $events = $statement->fetchAll(PDO::FETCH_ASSOC);
    return array_map(fn($data) => array_map("htmlspecialchars", $data), $events);
}
