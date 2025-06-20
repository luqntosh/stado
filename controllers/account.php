<?php
declare(strict_types=1);

function render_template(string $token, array $user)
{
    require "../templates/account-template.php";
}

$token = get_token();
render_template($token, $user);
