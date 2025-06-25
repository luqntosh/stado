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
	ges_period  INTEGER NOT NULL,
	preg_check	INTEGER NOT NULL,
	dry_check	INTEGER NOT NULL,
	due_check	INTEGER NOT NULL,
	PRIMARY KEY(id AUTOINCREMENT)
);");

$connection->exec("CREATE TABLE cows (
	id	INTEGER NOT NULL,
	cow_id	TEXT NOT NULL,
	name    TEXT NOT NULL,
	ins_date	TEXT NOT NULL,
	status	TEXT NOT NULL,
	due_date	TEXT NOT NULL,
	next_event	TEXT NOT NULL,
	owner_id	INTEGER NOT NULL,
	FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE CASCADE,
	PRIMARY KEY(id AUTOINCREMENT)
);");

$connection->exec("CREATE TABLE events (
	id	INTEGER NOT NULL,
	cow_id	INTEGER NOT NULL,
	date	TEXT NOT NULL,
	event	TEXT NOT NULL,
	text	TEXT NOT NULL,
	PRIMARY KEY(id AUTOINCREMENT),
	FOREIGN KEY(cow_id) REFERENCES cows(id) ON DELETE CASCADE
);");
