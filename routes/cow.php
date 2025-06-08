<?php
declare(strict_types=1);

require "../includes/database.php";
require "../includes/filters.php";
require "../includes/lut.php";

function render_cow(array $cow, array $history, array $events)
{
    require "../templates/cow.php";
}

function handle_get_request()
{
    $cow_id = filter_input(INPUT_GET, "id", FILTER_CALLBACK, [
        "options" => "validate_cow_id",
    ]);

    if ($cow_id === false || $cow_id === null) {
        redirect("/cows");
    }

    $connection = get_connection();

    $statement = $connection->prepare(
        "SELECT id, ins_date, state, due_date FROM cows WHERE id = :id"
    );
    $statement->bindValue(":id", $cow_id, PDO::PARAM_STR);
    $statement->execute();
    $cow = $statement->fetch(PDO::FETCH_ASSOC);
    $cow = array_map("htmlspecialchars", $cow);

    if (!$cow) {
        redirect("/cows");
    }

    $statement = $connection->prepare(
        "SELECT id, cow_id, date, event FROM history WHERE cow_id = :id"
    );
    $statement->bindValue(":id", $cow_id, PDO::PARAM_STR);
    $statement->execute();
    $history = $statement->fetchAll(PDO::FETCH_ASSOC);
    $history = array_map(
        fn($data) => array_map("htmlspecialchars", $data),
        $history
    );
    $events = get_events();

    render_cow($cow, $history, $events);
}

function handle_post_request()
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
    var_dump($_POST);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    handle_get_request();
} else {
    handle_post_request();
}
