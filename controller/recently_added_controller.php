<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once('../db/latestUpdates_model.php');
    require_once("../db/mangaInfoPdo.php");

    $isLibrary = false; // Set flag for active menu item in sidebar

    $pathPrefix = '../'; // Define path prefix for includes relative to controller directory


    $page = $_GET['page'] ?? 1;
    $currentPage = $page;
    $limit = 4;
    $offset = ($page - 1) * $limit;
    // Get all manga in library for counting total
    $allLibraryManga = getRecent(1000);
    $totalMangaCount = count($allLibraryManga);

    // Get manga for current page
    $manga = getRecent( 1000);
    foreach($manga as $i => $m){
        $manga[$i]['tags'] = getTags($m["MangaID"]);
    }

    // Slice for pagination
    $manga = array_slice($manga, $offset, $limit);
    $totalPages = ceil($totalMangaCount/$limit);

    include("../PHP/library.php");
?>

