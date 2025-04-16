<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once('../db/latestUpdates_model.php');
    require_once("../db/mangaInfoPdo.php");
    $userID = $_SESSION['userID'] ?? null;
    $username = $_SESSION['username'] ?? null;
    $isLoggedIn = false;
    if ($userID !=null || $username!= null){
        $isLoggedIn = true;
    }

    $isLibrary = true; // Set flag for active menu item in sidebar

    $pathPrefix = '../'; // Define path prefix for includes relative to controller directory

    // Check if user is logged in, if not, show login required page
    if (!$isLoggedIn) {
        include("../PHP/login_required.php");
        exit;
    }

    // If user is logged in, continue with the library page
    $page = $_GET['page'] ?? 1;
    $currentPage = $page;
    $limit = 4;
    $offset = ($page - 1) * $limit;
    $manga = getLibrary($userID,1000);
    foreach($manga as $i => $m){
        $manga[$i]['tags'] = getTags($m["MangaID"]);
    }


    $manga = array_slice($manga, $offset, $limit);
    $totalPages = count($manga)/$limit;

    include("../PHP/library.php");
?>

