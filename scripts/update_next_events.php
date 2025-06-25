<?php
declare(strict_types=1);

$seconds_in_day = 86400;
$connection = new PDO("sqlite:" . __DIR__ . "/../app.db");

$query = $connection->query("SELECT * FROM users", PDO::FETCH_ASSOC);
$users = $query->fetchAll();
foreach ($users as $user) {
    $update_querys = [];
    $query = $connection->query("SELECT * FROM cows WHERE owner_id = {$user["id"]}", PDO::FETCH_ASSOC);
    $cows = $query->fetchAll();
    foreach ($cows as $cow) {
        $next_event = "";
        switch ($cow["status"]) {
            case "Niezacielona":
                $query = $connection->query(
                    "SELECT * FROM events WHERE cow_id = {$cow["id"]} ORDER BY id DESC LIMIT 3",
                    PDO::FETCH_ASSOC
                );
                $events = $query->fetchAll();
                foreach ($events as $event) {
                    if ($event["event"] == "Ruja" && strtotime($event["date"]) + 20 * $seconds_in_day < time()) {
                        $next_event = "Inseminacja";
                        break;
                    } elseif (
                        $event["event"] == "Wycielenie" &&
                        strtotime($event["date"]) + 42 * $seconds_in_day < time()
                    ) {
                        $next_event = "Inseminacja";
                        break;
                    }
                }
                break;
            case "Zacielona":
                if (strtotime($cow["ins_date"]) + $user["preg_check"] * $seconds_in_day < time()) {
                    $next_event = "Sprawdzenie";
                }
                break;
            case "Sprawdzona":
                if (strtotime($cow["due_date"]) - $user["dry_check"] * $seconds_in_day < time()) {
                    $next_event = "Zasuszenie";
                }
                break;
            case "Zasuszona":
                if (strtotime($cow["due_date"]) - $user["due_check"] * $seconds_in_day < time()) {
                    $next_event = "Wycielenie";
                }
                break;
        }
        if ($next_event) {
            $update_querys[] = "UPDATE cows SET next_event = '{$next_event}' WHERE id = '{$cow["id"]}'";
        }
    }
    $data = implode("; ", $update_querys);
    $col = $connection->exec($data);
}
