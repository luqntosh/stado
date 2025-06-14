<?php
declare(strict_types=1);

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
if (!$id) {
    redirect("/cows");
}
$result = $connection->exec(
    "DELETE FROM cows WHERE id = {$id} AND owner_id = {$user["id"]}"
);
redirect("/cows");
