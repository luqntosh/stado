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

function get_token(): string
{
    $token = bin2hex(openssl_random_pseudo_bytes(32));
    $_SESSION["tokens"][] = $token;
    return $token;
}

function consume_token(string $token): bool
{
    $index = array_search($token, $_SESSION["tokens"], true);
    if (gettype($index) == "boolean") {
        return false;
    }
    unset($_SESSION["tokens"][$index]);
    return true;
}
