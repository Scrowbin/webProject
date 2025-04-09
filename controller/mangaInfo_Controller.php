<?php
session_start();
require('../db/mangaInfoPdo.php');

$userID = $_SESSION['userID'] ?? null;
$mangaID = $_GET['MangaID'] ?? null;

if (!$mangaID) {
    die("Missing MangaID.");
}

$mangaInfo = getMangaInfo($mangaID);
if (!$mangaInfo) {
    die("Manga not found.");
}

$authorsRaw = getMangaAuthors($mangaID);
$artistsRaw = getMangaArtists($mangaID);
$tags = getTags($mangaID); 
$chapters = getChapters($mangaID);

// Group chapters by volume
$grouped = [];
foreach ($chapters as $chapter) {
    $vol = $chapter['Volume'];
    $grouped[$vol][] = $chapter;
}

$hasRated = false;
if ($userID) {
    $hasRated = hasUserRatedManga($userID, $mangaID);
}

echo json_encode(['rated' => $hasRated, 'loggedIn' => $userID !== null]);
include('../PHP/mangaInfo.php');
?>