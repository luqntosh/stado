<?php
require "../lib/validators.php";
require "../lib/lut.php";

$errors = [];
$cow_id = filter_input(INPUT_POST, "id", FILTER_CALLBACK, [
    "options" => "validate_cow_id",
]);
if ($cow_id === false || $cow_id === null) {
    $errors[] = "Numer indentyfikacyjny musi zawierać 14 znaków!";
    goto error_route;
}

$cow = get_cow($connection, $user["id"], $cow_id);
if ($cow) {
    $errors[] = "Krowa o podanym numerze już istnieje.";
    goto error_route;
}

$cow_data = [
    ":id" => $cow_id,
    ":name" => htmlspecialchars($_POST["name"]),
    ":ins_date" => "",
    ":status" => "Niezacielona",
    ":owner_id" => $user["id"],
    ":due_date" => "",
    ":next_event" => "",
];
$result = create_cow($connection, $cow_data);
if (!$result) {
    $errors[] = "Coś poszło nie tak! Spróbuj póżniej.";
    goto error_route;
}
redirect("/cow?id={$cow_id}");

error_route:
set_form_data("cow-form", ["id" => $_POST["id"], "name" => $_POST["name"]]);
set_flash_messages("cow_form_errors", $errors);
redirect("/cow-form");
