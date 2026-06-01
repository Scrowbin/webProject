<?php

require_once __DIR__ . '/../config/bootstrap.php';
/**
 * Random Manga Controller
 * Redirects to a random manga page
 */

require_once __DIR__ . "/../models/mangaInfoPdo.php";

// Get a random manga ID from the database

// Get a random manga ID
$randomManga = getRandomManga();

// Redirect to the manga info page
header('Location: /manga/' . $randomManga);
exit;
?>
