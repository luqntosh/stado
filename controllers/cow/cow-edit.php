<?php
require "../lib/validators.php";

function render_template(string $token, array $error_messages, array $cow, array $data)
{
    extract($data);
    require "../templates/cow-edit-template.php";
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
$msg = consume_flash_messages("cow_edit_errors");
$data = consume_form_data("cow_edit");

render_template($token, $msg, $cow, $data);
