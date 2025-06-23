<?php
require "../lib/validators.php";
require "../lib/lut.php";

function render_template(string $token, array $error_messages, array $cow, array $old_events, array $events)
{
    require "../templates/cow-template.php";
}

$cow_id = filter_input(INPUT_GET, "id", FILTER_CALLBACK, [
    "options" => "validate_cow_id",
]);
if ($cow_id === false || $cow_id === null) {
    redirect("/cows");
}

$cow = get_cow($connection, $user["id"], $cow_id);
if (!$cow) {
    redirect("/cows");
}

$token = get_token();
$msg = consume_flash_messages("cow_errors");
$old_events = get_old_events($connection, $cow["id"]);
$events = get_events();

render_template($token, $msg, $cow, $old_events, $events);
