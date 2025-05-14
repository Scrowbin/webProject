<?php
/**
 * Random Manga Controller
 * Redirects to a random manga page
 */

require_once "../db/mangaInfoPdo.php";

// Get a random manga ID from the database

// Get a random manga ID
$randomManga = getRandomManga();

// Redirect to the manga info page
header("Location: ../manga/" . $randomManga);
exit;
?>
