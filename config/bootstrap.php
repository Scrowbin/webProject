<?php

if (defined('APP_BOOTSTRAPPED')) {
    return;
}

define('APP_BOOTSTRAPPED', true);

require_once __DIR__ . '/env.php';

if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

load_dotenv(APP_ROOT . DIRECTORY_SEPARATOR . '.env');

require_once __DIR__ . '/paths.php';
require_once __DIR__ . '/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
