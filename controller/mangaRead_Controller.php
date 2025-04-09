<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session if needed for user context
}

// Include necessary files
require_once __DIR__ . '/../db/pdo.php';
require_once __DIR__ . '/../db/mangaReadPdo.php';
require_once __DIR__ . '/../PHP/helper.php'; // Include helper functions needed by the view

// Get ChapterID from query string
$chapterID = filter_input(INPUT_GET, 'chapterID', FILTER_VALIDATE_INT);

if (!$chapterID) {
    // Handle invalid or missing ChapterID
    die('Invalid or missing ChapterID.');
}

// Database connection
$pdo = pdo_get_connection();

// Fetch required data using functions from mangaReadPdo.php
$pages = getPages($chapterID); // Removed $pdo
$chapterInfo = getChapterInfo($chapterID); // Removed $pdo
$mangaInfo = getMangaInfo($chapterID); // Removed $pdo
$commentSection = getCommentSection($chapterID); // Fetch comment section info

// Check if essential data was found
if (!$pages || !$chapterInfo || !$mangaInfo) {
    // Handle chapter or manga not found
    die("Chapter or associated Manga not found.");
}

// Extract MangaID from fetched data
$mangaID = $mangaInfo['MangaID']; 

// Fetch navigation chapters
$nextChapterID = getNextChapter($chapterID); // Removed $pdo
$prevChapterID = getPrevChapter($chapterID); // Removed $pdo

// Fetch all chapters for the dropdown
$chapters = getChapters($mangaID); // Use $chapters as expected by the view

// Prepare page data for the view
$pageLinks = [];
$pageValues = [];
$i = 1;
foreach($pages as $page){
    $pageLinks[] = $page['PageLink'];
    $pageValues[] = $i; // Create $pageValues array
    $i++;
}

// Include the view file, passing necessary variables
// Variables available: $pages, $chapterInfo, $mangaInfo, $commentSection, $mangaID, 
// $nextChapterID, $prevChapterID, $chapters, $pageLinks, $pageValues, $chapterID
include __DIR__ . '/../PHP/mangaRead.php';
?>