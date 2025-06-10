<?php

function auth()
{
    if (!isset($_SESSION["user"])) {
        return false;
    }
    return true;
}
