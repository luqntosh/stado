<?php
declare(strict_types=1);

session_destroy();

$params = session_get_cookie_params();
setcookie("PHPSESSID", "", time() - 3600, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
redirect("/");
