<?php
declare(strict_types=1);

require "../includes/filters.php";
require "../includes/lut.php";

function render_add(array $error_messages, $statuses)
{
    require "../templates/add.php";
}

function handle_get_request()
{
    $msgs = get_flash_messages("add_errors");
    $statuses = get_statuses();
    render_add($msgs, $statuses);
}

function handle_post_request(PDO $connection, array $user)
{
    $errors = [];
    $cow_id = filter_input(INPUT_POST, "id", FILTER_CALLBACK, [
        "options" => "validate_cow_id",
    ]);
    if ($cow_id === false || $cow_id === null) {
        $errors[] = "Numer indentyfikacyjny musi zaiwerać 4 cyfry.";
    }

    if ($_POST["ins_date"]) {
        $date = validate_date($_POST["ins_date"]);
        if (!$date) {
            $errors[] = "Data nie jest poprawna.";
        }
    }

    $statuses = get_statuses();
    if (!in_array($_POST["status"], $statuses)) {
        $erros[] = "Nie ma takiego statusu.";
    }

    if ($errors) {
        $_SESSION["add_errors"] = $errors;
        redirect("/add");
    }

    if (array_search($_POST["status"], $statuses) > 0 && !$_POST["ins_date"]) {
        $_SESSION["add_errors"] = ["Dla wybranego statusu wymagana jest data."];
        redirect("/add");
    }

    $statement = $connection->prepare(
        "SELECT cow_id, owner_id FROM cows WHERE cow_id = :id and owner_id = :owner_id"
    );
    $statement->execute([":id" => $cow_id, ":owner_id" => $user["id"]]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $_SESSION["add_errors"] = ["Krowa o podanym numerze już istnieje."];
        redirect("/add");
    }
    $cows_due = "";
    $next_event = "";

    $statement = $connection->prepare(
        "INSERT INTO cows(cow_id, ins_date, state, owner_id, due_date, next_event) VALUES(:id, :ins_date, :state, :owner_id, :due_date, :next_event)"
    );
    $statement->execute([
        ":id" => $cow_id,
        ":ins_date" => $_POST["ins_date"],
        ":state" => $_POST["status"],
        ":owner_id" => $user["id"],
        ":due_date" => $cows_due,
        ":next_event" => $next_event,
    ]);
    redirect("/cows");
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    handle_get_request();
} else {
    handle_post_request($connection, $user);
}

?>
