<?php
declare(strict_types=1);

require "../lib/lut.php";

function render_template(string $token, array $error_messages, array $data)
{
    extract($data);
    require "../templates/cow-form-template.php";
}

$token = get_token();
$msgs = consume_flash_messages("cow_form_errors");
$data = consume_form_data("cow-form");
render_template($token, $msgs, $data);
