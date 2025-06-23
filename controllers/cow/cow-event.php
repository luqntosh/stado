<?php
declare(strict_types=1);

require "../lib/validators.php";
require "../lib/lut.php";

$ok = consume_token($_POST["token"]);
if (!$ok) {
    goto redirect;
}
$ok = validate_date($_POST["event_date"]);
if (!$ok) {
    goto redirect;
}
$events = get_events();
if (!in_array($_POST["event"], $events)) {
    goto redirect;
}

$cow = get_cow($connection, $user["id"], $_POST["cow_id"]);

if (!$cow) {
    goto redirect;
}

$ins_date = $cow["ins_date"];
if (!$ins_date && in_array($_POST["event"], get_events_with_ins_req())) {
    set_flash_messages("cow_errors", ["Dla wybranego zdarzenia krowa musi posiadać datę inseminacji!"]);
    goto redirect;
} elseif (in_array($_POST["event"], get_events_with_check_req()) && $cow["status"] != "Sprawdzona") {
    set_flash_messages("cow_errors", ["Dla wybranego zdarzenia krowa musi być sprawdzona!"]);
    goto redirect;
}
$timestamp = strtotime($_POST["event_date"]);
$date = date("d-m-Y", $timestamp);

if ($_POST["event"] !== "Antybiotyk") {
    $cow["next_event"] = "";
}

switch ($_POST["event"]) {
    case "Ruja":
        $cow["ins_date"] = "";
        $cow["status"] = "Niezacielona";
        $cow["due_date"] = "";
        break;
    case "Inseminacja":
        $cow["ins_date"] = $date;
        $cow["status"] = "Zacielona";
        $cow["due_date"] = "";
        break;
    case "Niecielna (sprawdzenie)":
        $cow["ins_date"] = "";
        $cow["status"] = "Niezacielona";
        $cow["due_date"] = "";
        break;
    case "Cielna (sprawdzenie)":
        $dt = new DateTime();
        $timestamp = strtotime($cow["ins_date"]);
        $due_date = $dt->setTimestamp($timestamp)->add(new DateInterval("P287D"))->format("d-m-Y");
        $cow["status"] = "Sprawdzona";
        $cow["due_date"] = $due_date;
        break;
    case "Zasuszenie":
        $cow["status"] = "Zasuszona";
        break;
    case "Wycielenie":
        $cow["ins_date"] = "";
        $cow["status"] = "Niezacielona";
        $cow["due_date"] = "";
        break;
}

$cow_data = [];

foreach ($cow as $k => $v) {
    $cow_data[":" . $k] = $v;
}

$event_data = [
    ":cow_id" => $cow["id"],
    ":date" => $date,
    ":event" => $_POST["event"],
    ":text" => htmlspecialchars($_POST["text"]),
];

$result = update_cow($connection, $cow_data);
$result = add_event($connection, $event_data);

redirect:
redirect("/cow?id={$cow["cow_id"]}");
