<?php
declare(strict_types=1);

function render_cows(array $cows)
{
    require "../templates/cows.php";
}

$connection = get_connection();

$statement = $connection->prepare(
    "SELECT id, cow_id, ins_date, state, due_date, owner_id FROM cows where owner_id = :owner_id"
);
$statement->execute([":owner_id" => $user["id"]]);
$cows = $statement->fetchAll(PDO::FETCH_ASSOC);
$cows = array_map(fn($data) => array_map("htmlspecialchars", $data), $cows);

render_cows($cows);

?>
