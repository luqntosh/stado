<?php
declare(strict_types=1);

function render_template(string $token, array $error_messages, array $data)
{
    extract($data);
    require "../templates/login-template.php";
}

$data = consume_form_data("login");
$msgs = consume_flash_messages("login_errors");
$token = get_token();
render_template($token, $msgs, $data);
