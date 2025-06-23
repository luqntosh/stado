<?php
declare(strict_types=1);

function render_template(string $token, array $error_messages, array $data)
{
    extract($data);
    require "../templates/login-template.php";
}

$token = get_token();
$msgs = consume_flash_messages("login_errors");
$data = consume_form_data("login");
render_template($token, $msgs, $data);
