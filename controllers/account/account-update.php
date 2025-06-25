<?php

$ok = consume_token($_POST["token"]);
if (!$ok) {
    goto redirect;
}

$ges_period = filter_input(INPUT_POST, "ges_period", FILTER_VALIDATE_INT, [
    "options" => ["min_range" => 250, "max_range" => 330],
]);
if (!$ges_period) {
    goto redirect;
}

$preg_check = filter_input(INPUT_POST, "preg_check", FILTER_VALIDATE_INT, [
    "options" => ["min_range" => 25, "max_range" => 300],
]);
if (!$preg_check) {
    goto redirect;
}

$dry_check = filter_input(INPUT_POST, "dry_check", FILTER_VALIDATE_INT, [
    "options" => ["min_range" => 0, "max_range" => 200],
]);
if (!$dry_check) {
    goto redirect;
}

$due_check = filter_input(INPUT_POST, "due_check", FILTER_VALIDATE_INT, [
    "options" => ["min_range" => 0, "max_range" => 50],
]);
if (!$due_check) {
    goto redirect;
}

$user_data = [
    ":id" => $user["id"],
    ":last_update" => time(),
    ":ges_period" => $_POST["ges_period"],
    ":preg_check" => $_POST["preg_check"],
    ":dry_check" => $_POST["dry_check"],
    ":due_check" => $_POST["due_check"],
];

$ok = update_user($connection, $user_data);

redirect:
redirect("/account");
