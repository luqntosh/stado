<?php
declare(strict_types=1);

require "../lib/validators.php";

$ok = consume_token($_POST["token"]);
if (!$ok) {
    goto redirect;
}

$cow_id = filter_input(INPUT_POST, "cow_id", FILTER_CALLBACK, [
    "options" => "validate_cow_id",
]);
if ($cow_id === false || $cow_id === null) {
    goto redirect;
}

$cow = get_cow($connection, $user["id"], $cow_id);
if (!$cow) {
    goto redirect;
}

$statement = $connection->prepare("DELETE FROM cows WHERE cow_id = :cow_id AND owner_id = :owner_id");
$statement->execute([":cow_id" => $cow_id, ":owner_id" => $user["id"]]);

redirect:
redirect("/cows");
