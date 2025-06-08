<?php
declare(strict_types=1);

function get_connection(): PDO
{
    return new PDO("sqlite:" . __DIR__ . "/../app.db");
}
