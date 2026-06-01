<?php

require_once __DIR__ . '/../config/bootstrap.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set the flag for active sidebar item
$isReadingHistory = true;
$pathPrefix = '../'; // Define path prefix for includes relative to controller directory

include __DIR__ . "/../views/reading_history.php";