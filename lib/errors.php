<?php
declare(strict_types=1);

ob_start();

function exception_handler(Throwable $exception)
{
    ob_end_clean();
    http_response_code(500);
    exit();
}

function error_handler(int $code, string $message, string $file, int $line, array $context)
{
    ob_end_clean();
    http_response_code(500);
    exit();
}

function terminate_method(int $code)
{
    http_response_code($code);
    exit();
}

set_exception_handler("exception_handler");
set_error_handler("error_handler");
