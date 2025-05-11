<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set the flag for active sidebar item
$isReadingHistory = true;
$pathPrefix = '../'; // Define path prefix for includes relative to controller directory

include("../PHP/reading_history.php");