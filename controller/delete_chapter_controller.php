<?php
require('../db/mangaInfoPdo.php');
require_once('../db/account_db.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userID = $_SESSION['userID'] ?? null;
$isLoggedIn = false;
if ($userID !=null){
    $isLoggedIn =true;
}
else{
    exit('You must be logged in as an admin');
}

$role = get_role($userID);
if (!$isLoggedIn||$role !== "admin"){
    exit("You must be logged in as an admin");
}
if($role !== "admin"){
    exit('Must be admin');
}

$slug = $_GET['slug']??null;
$mangaID = getMangaIDFromSlug($slug) ?? null;

if (!$mangaID) {
    die("Missing Manga.");
}

$mangaInfo = getMangaInfo($mangaID);
if (!$mangaInfo) {
    die("Manga not found.");
}

$authorsRaw = getMangaAuthors($mangaID);
$artistsRaw = getMangaArtists($mangaID);
$tags = getTags($mangaID);
$chapters = getChapters($mangaID);

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

include("../PHP/deleteChapter.php");
