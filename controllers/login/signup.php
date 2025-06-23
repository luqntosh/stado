<?php

function render_template(string $token, array $error_messages, array $data)
{
    extract($data);
    require "../templates/signup-template.php";
}

$token = get_token();
$msgs = consume_flash_messages("signup_errors");
$data = consume_form_data("signup");
render_template($token, $msgs, $data);
