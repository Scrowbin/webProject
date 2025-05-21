<?php
// edit_manga.php
require '../db/edit_model.php'; // Your database connection
// Don't include mangaInfoPdo.php here to avoid function name conflicts

// Set mode to edit for the create.php template
$mode = "edit";
$slug = $_GET['slug'] ?? null;
$mangaID = getMangaIDFromSlug($slug) ?? null;
if (!$mangaID) {
    echo "No manga ID provided.";
    exit;
}

// Get manga information
$manga = getMangaInfo($mangaID);
// var_dump($manga);
if (!$manga) {
    echo "Manga not found.";
    exit;
}

// Get related data
$authorsRaw = explode(',', $manga['Authors']);
$artistsRaw = explode(',', $manga['Artists']);
$coverLink = "/IMG/" . $mangaID . "/" . $manga["CoverLink"];
$selectedTags = explode(',', $manga['Tags']);

// Define path prefix for includes (same as in create.php)
$pathPrefix = '../';

// Include the create.php template which will use navbar_minimal.php
include("../PHP/create.php");
?>



