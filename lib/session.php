<?php
declare(strict_types=1);

function set_flash_messages(string $name, array $messages)
{
    $_SESSION["_flash"][$name] = $messages;
}

function consume_flash_messages(string $name): array
{
    if (!isset($_SESSION["_flash"][$name])) {
        return [];
    }
    $data = $_SESSION["_flash"][$name];
    unset($_SESSION["_flash"][$name]);
    return $data;
}

function set_form_data(string $name, array $data)
{
    $_SESSION["_form"][$name] = $data;
}

function consume_form_data(string $name): array
{
    if (!isset($_SESSION["_form"][$name])) {
        return [];
    }
    $data = array_map("htmlspecialchars", $_SESSION["_form"][$name]);
    unset($_SESSION["_form"][$name]);
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
