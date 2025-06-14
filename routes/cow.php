<?php
declare(strict_types=1);

require "../includes/filters.php";
require "../includes/lut.php";

function render_cow(array $cow, array $history, array $events)
{
    require "../templates/cow.php";
}

function handle_get_request(PDO $connection, array $user)
{
    $cow_id = filter_input(INPUT_GET, "id", FILTER_CALLBACK, [
        "options" => "validate_cow_id",
    ]);

    if ($cow_id === false || $cow_id === null) {
        redirect("/cows");
    }

    $statement = $connection->prepare(
        "SELECT id, cow_id, ins_date, status, due_date, owner_id FROM cows WHERE cow_id = :id AND owner_id = :owner_id"
    );
    $statement->bindValue(":id", $cow_id, PDO::PARAM_STR);
    $statement->bindValue(":owner_id", $user["id"], PDO::PARAM_INT);
    $statement->execute();
    $cow = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$cow) {
        redirect("/cows");
    }
    $cow = array_map("htmlspecialchars", $cow);

    $statement = $connection->prepare(
        "SELECT id, cow_id, date, event, text FROM history WHERE cow_id = :id"
    );
    $statement->bindValue(":id", $cow["id"], PDO::PARAM_STR);
    $statement->execute();
    $history = $statement->fetchAll(PDO::FETCH_ASSOC);
    $history = array_map(
        fn($data) => array_map("htmlspecialchars", $data),
        $history
    );

    $events = get_events();
    render_cow($cow, $history, $events);
}

function handle_post_request(PDO $connection, array $user)
{
    $date = validate_date($_POST["event_date"]);
    if (!$date) {
        redirect("/cow?" . $_POST["cow_id"]);
    }
    $date = date("d-m-Y");
    $events = get_events();
    if (!in_array($_POST["event"], $events)) {
        redirect("/cow?" . $_POST["cow_id"]);
    }

    $statement = $connection->prepare(
        "SELECT id, cow_id, owner_id FROM cows WHERE id = :id and owner_id = :owner_id"
    );
    $statement->execute([
        ":id" => $_POST["cow_id"],
        ":owner_id" => $user["id"],
    ]);
    $cow = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$cow) {
        redirect("/cow?id={$cow["cow_id"]}");
    }

    $timestamp = strtotime($_POST["event_date"]);
    $date = date("d-m-Y", $timestamp);
    $statement = $connection->prepare(
        "INSERT INTO history(cow_id, date, event, text) VALUES(:cow_id, :date, :event, :text)"
    );
    $statement->execute([
        ":cow_id" => $_POST["cow_id"],
        ":date" => $date,
        ":event" => $_POST["event"],
        ":text" => htmlspecialchars($_POST["text"]),
    ]);
    redirect("/cow?id={$cow["cow_id"]}");
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    handle_get_request($connection, $user);
} else {
    handle_post_request($connection, $user);
}
