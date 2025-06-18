<?php

$path = __DIR__ . "/../app.db";
$exists = file_exists($path);
if ($exists) {
    echo "Baza danych juz istnieje!\n";
}

$connection = new PDO("sqlite:{$path}");

$connection->exec("PRAGMA foreign_keys = '1';");

$connection->exec("CREATE TABLE users (
	id	INTEGER NOT NULL,
	email	TEXT NOT NULL,
	password	TEXT NOT NULL,
	last_update	INTEGER NOT NULL,
	preg_check	INTEGER NOT NULL,
	dry_check	INTEGER NOT NULL,
	due_check	INTEGER NOT NULL,
	PRIMARY KEY(id AUTOINCREMENT)
);");
