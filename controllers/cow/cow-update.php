<?php
require "../lib/validators.php";
require "../lib/lut.php";

$errors = [];

$old_id = filter_input(INPUT_POST, "old_id", FILTER_CALLBACK, ["options" => "validate_cow_id"]);
if ($old_id === false || $old_id === null) {
    $errors[] = "Numer indentyfikacyjny musi zawierać 14 znaków!";
    redirect("/cows");
}

$cow_id = filter_input(INPUT_POST, "id", FILTER_CALLBACK, ["options" => "validate_cow_id"]);
if ($cow_id === false || $cow_id === null) {
    $errors[] = "Numer indentyfikacyjny musi zawierać 14 znaków!";
    goto error_route;
}

$cow = get_cow($connection, $user["id"], $old_id);
if ($cow && $cow["cow_id"] !== $_POST["old_id"]) {
    $errors[] = "Krowa o podanym numerze już istnieje.";
    goto error_route;
}

$cow_data = [
    "name" => htmlspecialchars($_POST["name"]),
    ":cow_id" => $cow_id,
    ":id" => $cow["id"],
];

$result = update_cow_id($connection, $cow_data);
if (!$result) {
    $errors[] = "Coś poszło nie tak! Spróbuj póżniej.";
    goto error_route;
}
redirect("/cow?id={$cow_id}");

error_route:
set_form_data("cow-edit", ["name" => $_POST["name"]]);
set_flash_messages("cow_edit_errors", $errors);
redirect("/cow-edit?id={$old_id}");
