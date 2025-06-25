<?php
declare(strict_types=1);

function render_template(string $token, array $user, array $cow_data)
{
    require "../templates/account-template.php";
}

$token = get_token();
$data = get_cows_info($connection, $user["id"]);
render_template($token, $user, $data);
