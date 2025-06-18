<?php
declare(strict_types=1);

function render_template(array $error_messages)
{
    require "../templates/login-template.php";
}

$msgs = get_flash_messages("login_errors");
render_template($msgs);
