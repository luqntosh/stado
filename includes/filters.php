<?php
declare(strict_types=1);

function validate_cow_id($value): ?string
{
    if (preg_match("/^[0-9]{4}$/", $value)) {
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
