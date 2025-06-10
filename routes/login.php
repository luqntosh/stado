<?php

function render_login()
{
    require "../templates/login.php";
}

function handle_get_request()
{
    render_login();
}

function handle_post_request()
{
    echo "Hello";
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    handle_get_request();
} else {
    handle_post_request();
}

?>
