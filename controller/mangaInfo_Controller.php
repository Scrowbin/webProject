<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require('../db/mangaInfoPdo.php');

$userID = $_SESSION['userID'] ?? null;
$isLoggedIn = false;
if ($userID !=null){
    $isLoggedIn =true;
}
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

$counts = getCommentCountsPerChapter($mangaID);
$countsMap = [];
foreach ($counts as $row) {
    $countsMap[$row['ChapterID']] = $row['NumOfComments'];
}
var_dump($countsMap);

// Group chapters by volume
$grouped = [];
foreach ($chapters as $chapter) {
    $vol = $chapter['Volume'];
    $chapter['NumOfComments'] = $countsMap[$chapter['ChapterID']] ?? 0;
    $grouped[$vol][] = $chapter;
}

$userRating = 0;
if ($userID) {
    $userRating = getRating($userID, $mangaID);
}

include('../PHP/mangaInfo.php');
?>