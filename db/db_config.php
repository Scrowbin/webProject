<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Default XAMPP username
define('DB_PASS', '');    // Default XAMPP password
define('DB_NAME', 'mangadaxlogin');
define('DB_CHARSET', 'utf8mb4');


$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Turn on errors in the form of exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Make the default fetch be an associative array
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Turn off emulation mode for real prepared statements
];

try {
     $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
     error_log("Database Connection Error: " . $e->getMessage());
     die("Sorry, database connection failed. Please try again later.");
}


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?> 