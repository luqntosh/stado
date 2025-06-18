<?php

function render_template(array $error_messages)
{
    require "../templates/signup-template.php";
}

$msgs = get_flash_messages("signup_errors");
render_template($msgs);
