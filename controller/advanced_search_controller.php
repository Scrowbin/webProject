<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../db/latestUpdates_model.php');
require_once("../db/mangaInfoPdo.php");
require_once("../db/search_model.php");

$userID = $_SESSION['userID'] ?? null;
$username = $_SESSION['username'] ?? null;

// If no userID but have username, get userID from username
if (!$userID && $username) {
    $userID = getUserID($username);
    if ($userID) {
        $_SESSION['userID'] = $userID;
    }
}

$isLoggedIn = false;
if ($userID != null || $username != null){
    $isLoggedIn = true;
}

$isAdvancedSearch = true; // Set flag for active menu item in sidebar
$pathPrefix = '../'; // Define path prefix for includes relative to controller directory

// Get search parameters from GET request
$searchQuery = $_GET['query'] ?? '';
$sortBy = $_GET['sort'] ?? 'none';
$contentRating = $_GET['content_rating'] ?? 'any';
$demographic = $_GET['demographic'] ?? 'any';
$originalLanguage = $_GET['language'] ?? 'any';
$publicationStatus = $_GET['status'] ?? 'any';
$publicationYear = $_GET['year'] ?? '';
// Process include and exclude tags
$includeTags = isset($_GET['include_tags']) && !empty($_GET['include_tags']) ? explode(',', $_GET['include_tags']) : [];
$excludeTags = isset($_GET['exclude_tags']) && !empty($_GET['exclude_tags']) ? explode(',', $_GET['exclude_tags']) : [];

// Remove empty values
$includeTags = array_filter($includeTags);
$excludeTags = array_filter($excludeTags);

// Debug
error_log("Controller - Include Tags: " . implode(', ', $includeTags));
error_log("Controller - Exclude Tags: " . implode(', ', $excludeTags));

$authorID = $_GET['author'] ?? 'any';
$artistID = $_GET['artist'] ?? 'any';

// Pagination
$page = $_GET['page'] ?? 1;
$currentPage = $page;
$limit = 12; // Show more manga per page
$offset = ($page - 1) * $limit;

// Get all tags for the filter UI
$allTags = getAllTags();
$tagsByGroup = [];
foreach ($allTags as $tag) {
    $tagsByGroup[$tag['TagGroup']][] = $tag;
}

// Get all authors and artists for the filter UI
$allAuthors = getAllAuthors();
$allArtists = getAllArtists();

// Search for manga based on filters
$searchResults = advancedSearchManga(
    $searchQuery,
    $sortBy,
    $contentRating,
    $demographic,
    $originalLanguage,
    $publicationStatus,
    $publicationYear,
    $includeTags,
    $excludeTags,
    $authorID,
    $artistID,
    1000, // Get all results for counting
    0
);

$totalMangaCount = count($searchResults);

// If no results found with filters, try a basic search
if ($totalMangaCount == 0 && !empty($searchQuery)) {
    error_log("No results with filters, trying basic search");
    $searchResults = searchManga($searchQuery, 1000);
    $totalMangaCount = count($searchResults);
}

// If still no results, get some manga to display
if ($totalMangaCount == 0) {
    error_log("No results at all, showing some manga");
    $searchResults = getAllMangaTest(10);
    $totalMangaCount = count($searchResults);
}

// Process manga data
$manga = array_slice($searchResults, $offset, $limit);
foreach($manga as $i => $m){
    $mangaID = $m["MangaID"];
    $manga[$i]['tags'] = getTags($mangaID);

    // Add real stats data
    $manga[$i]['CommentCount'] = getTotalComments($mangaID) ?? 0;
    $manga[$i]['FollowCount'] = getTotalFollows($mangaID) ?? 0;
    $manga[$i]['AvgRating'] = getAverageRating($mangaID) ?? 0;

    // Get the first chapter's comment section ID for direct comment link
    $firstChapter = getFirstChapter($mangaID);
    if ($firstChapter) {
        $commentSectionID = getCommentSectionID($firstChapter['ChapterID']);
        $manga[$i]['CommentSectionID'] = $commentSectionID;
    }
}

$totalPages = ceil($totalMangaCount/$limit);

// Include the advanced search view
include("../PHP/advanced_search.php");
?>
