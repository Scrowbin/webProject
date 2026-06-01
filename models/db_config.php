<?php

/**
 * Legacy database bootstrap (uses .env via config/bootstrap.php).
 * Prefer requiring models/pdo.php in new code.
 */
require_once __DIR__ . '/pdo.php';

$dsn = sprintf(
    'mysql:host=%s;dbname=%s;charset=%s',
    env('DB_HOST', 'localhost'),
    env('DB_NAME', 'manga'),
    env('DB_CHARSET', 'utf8mb4')
);

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, env('DB_USER', 'root'), env('DB_PASS', ''), $options);
} catch (PDOException $e) {
    error_log('Database Connection Error: ' . $e->getMessage());
    die('Sorry, database connection failed. Please try again later.');
}
