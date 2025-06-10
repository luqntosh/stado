<?php
declare(strict_types=1);

function render_cows(array $cows)
{
    require "../templates/cows.php";
}

$connection = get_connection();

$statement = $connection->prepare(
    "SELECT id, cow_id, ins_date, state, due_date FROM cows"
);
$statement->execute();
$cows = $statement->fetchAll(PDO::FETCH_ASSOC);

$cows = array_map(fn($data) => array_map("htmlspecialchars", $data), $cows);

render_cows($cows);

?>
