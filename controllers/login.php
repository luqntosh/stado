<?php
declare(strict_types=1);

function render_template(string $token, array $error_messages)
{
    require "../templates/login-template.php";
}

$msgs = get_flash_messages("login_errors");
$token = get_token();
render_template($token, $msgs);
