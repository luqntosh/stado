<?php
declare(strict_types=1);

function get_events(): array
{
    return [
        "Ruja",
        "Inseminacja",
        "Sprawdzenie, niezacielona",
        "Sprawdzenie, zacielona",
        "Zasuszenie",
        "Wycielenie",
        "Antybiotyk",
    ];
}

function get_statuses(): array
{
    return ["Niezacielona", "Zacielona", "Sprawdzona", "Zasuszona"];
}
