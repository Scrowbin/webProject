<?php
// edit_manga.php
require '../db/edit_model.php'; // Your database connection
$mode = "edit";
$mangaID = $_GET['MangaID'] ?? null;
if (!$mangaID) {
    echo "No manga ID provided.";
    exit;
}


$manga = getMangaInfo($mangaID);
if (!$manga) {
    echo "Manga not found.";
    exit;
}


$authorsRaw = getMangaAuthors($mangaID);
$artistsRaw = getMangaArtists($mangaID);
$coverLink = "../IMG/" . $mangaID . "/" . $manga["CoverLink"];

$selectedTags = getTags($mangaID);
include("../PHP/create.php")
?>



