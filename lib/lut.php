<?php
declare(strict_types=1);

function get_events(): array
{
    return [
        "Ruja",
        "Inseminacja",
        "Niecielna (sprawdzenie)",
        "Cielna (sprawdzenie)",
        "Zasuszenie",
        "Wycielenie",
        "Antybiotyk",
    ];
}

function get_events_with_ins_req(): array
{
    return ["Niecielna (sprawdzenie)", "Cielna (sprawdzenie)"];
}

function get_events_with_check_req(): array
{
    return ["Zasuszenie"];
}

function get_statuses(): array
{
    return ["Niezacielona", "Zacielona", "Sprawdzona", "Zasuszona"];
}

function get_statuses_with_due_date(): array
{
    return ["Sprawdzona", "Zasuszona"];
}
