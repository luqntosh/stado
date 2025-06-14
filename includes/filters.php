<?php
declare(strict_types=1);

function validate_cow_id($value): ?string
{
    if (preg_match("/^[A-Z]{2}[0-9]{12}$/", $value)) {
        return $value;
    } else {
        return null;
    }
}

function validate_date(string $date): ?int
{
    $data = strtotime($date);
    if ($data) {
        return $data;
    }
    return null;
}

function validate_email(string $emial)
{
    return filter_var($emial, FILTER_VALIDATE_EMAIL);
}

function validate_password(string $password)
{
    $password = trim($password);
    return strlen($password) > 7;
}
