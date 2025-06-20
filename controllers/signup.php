<?php

function render_template(string $token, array $error_messages)
{
    require "../templates/signup-template.php";
}

$token = get_token();
$msgs = get_flash_messages("signup_errors");
render_template($token, $msgs);
