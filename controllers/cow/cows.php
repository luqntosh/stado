<?php

declare(strict_types=1);

function render_template($cows)
{
    require "../templates/cows-template.php";
}

$cows = get_cows($connection, $user["id"]);
$cows = array_map(fn($data) => array_map("htmlspecialchars", $data), $cows);

render_template($cows);
