<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require('../db/mangaInfoPdo.php');
require('../db/account_db.php');

$userID = $_SESSION['userID'] ?? null;
$username = $_SESSION['username'] ?? null;

$isLoggedIn = isset($_SESSION['userID']);
$role = "user";
if ($isLoggedIn){
    $role = get_role($userID);
}

$slug = $_GET['slug'] ?? null;
$mangaID = getMangaIDFromSlug($slug) ?? null;

if (!$mangaID) {
    die("Invalid manga.");
}

$isBookmarked = false;
if ($userID) {
    $isBookmarked = isBookmarked($mangaID, $userID);
    $userRating = getRating($userID, $mangaID);
} else {
    $userRating = 0;
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
$commentSectionIDMap = [];
foreach ($counts as $row) {
    $countsMap[$row['ChapterID']] = $row['NumOfComments'];
    $commentSectionIDMap[$row['ChapterID']]=$row['CommentSectionID'] ;
}
$avgRating =  getAverageRating($mangaID) ?? "N/A";
if ($avgRating!=="N/A"){
    $avgRating = round($avgRating,2);
}
$follows = getTotalFollows($mangaID) ?? 0;
$totalCom = getTotalComments($mangaID)??0;

// Group chapters by volume
$grouped = [];
foreach ($chapters as $chapter) {
    $vol = $chapter['Volume'];
    $chapter['NumOfComments'] = $countsMap[$chapter['ChapterID']] ?? 0;
    $chapter['CommentSectionID'] = $commentSectionIDMap[$chapter['ChapterID']] ?? 0;
    $grouped[$vol][] = $chapter;
}

$pathPrefix = '../'; // Define path prefix for includes relative to controller directory

include('../PHP/mangaInfo.php');
?>