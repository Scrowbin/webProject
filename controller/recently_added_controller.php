<?php
// controller/recently_added_controller.php - Controller for Recently Added Manga page

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary base files
require('../db/account_db.php');
require_once('../db/latestUpdates_model.php');
require_once("../db/mangaInfoPdo.php");

// Set flag for sidebar active state
$isLibrary = false; // Not a library page
$isRecentlyAdded = true; // Set flag for active menu item in sidebar
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
$role = "user";
if ($isLoggedIn){
    $role = get_role($userID);
}
// Define path prefix for includes relative to controller directory
$pathPrefix = '../';

// Pagination
$page = $_GET['page'] ?? 1;
$currentPage = $page;
$limit = 12; // Show more manga per page
$offset = ($page - 1) * $limit;

// Get all manga for counting total
$allRecentManga = getRecent(1000);
$totalMangaCount = count($allRecentManga);

// Get manga for current page
$manga = getRecent(1000);
foreach($manga as $i => $m){
    $manga[$i]['tags'] = getTags($m["MangaID"]);
    $manga[$i]['authors'] = getMangaAuthors($m["MangaID"]);
    $manga[$i]['artists'] = getMangaArtists($m["MangaID"]);
}

// Slice for pagination
$manga = array_slice($manga, $offset, $limit);
$totalPages = ceil($totalMangaCount/$limit);

// Set page title
$pageTitle = "Recently Added Manga";

// Include the library view (reusing it for now)
include("../PHP/library.php");

