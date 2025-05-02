<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require('../db/mangaInfoPdo.php');

$userID = $_SESSION['userID'] ?? null;
$username = $_SESSION['username'] ?? null;
if (!isset($_SESSION['userID'])) {
    if ($username != null){
        $userID = getUserID($_SESSION['username']);
        $_SESSION['userID'] = $userID;        
    }
}

$isLoggedIn = false;
if ($userID !=null || $username!= null){
    $isLoggedIn =true;
}



$mangaID = $_GET['MangaID'] ?? null;

if (!$mangaID) {
    die("Missing MangaID.");
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