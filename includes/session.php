<?php
declare(strict_types=1);

function get_flash_messages(string $name): array
{
    if (!isset($_SESSION[$name])) {
        return [];
    }
    $data = $_SESSION[$name];
    unset($_SESSION[$name]);
    return $data;
}
