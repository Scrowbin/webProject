<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once('../db/account_db.php');
    require_once('../db/latestUpdates_model.php');
    require_once("../db/mangaInfoPdo.php");

    $userID = $_SESSION['userID'] ?? null;
    $username = $_SESSION['username'] ?? null;

    // Nếu không có userID nhưng có username, lấy userID từ username
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

    $isLibrary = true; // Set flag for active menu item in sidebar
    $isRecentlyAdded = false;
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
    // Get all manga in library for counting total
    $allLibraryManga = getLibrary($userID, 1000);
    $totalMangaCount = count($allLibraryManga);

    // Get manga for current page
    $manga = getLibrary($userID, 1000);
    foreach($manga as $i => $m){
        $mangaID = $m["MangaID"];
        $manga[$i]['tags'] = getTags($mangaID);

        // Add real stats data
        $manga[$i]['CommentCount'] = getTotalComments($mangaID) ?? 0;
        $manga[$i]['FollowCount'] = getTotalFollows($mangaID) ?? 0;
        $manga[$i]['AvgRating'] = getAverageRating($mangaID) ?? 0;

        // Get the first chapter's comment section ID for direct comment link
        //thằng l vibe coder đánh m chết  quá
    }

    // Slice for pagination
    $manga = array_slice($manga, $offset, $limit);
    $totalPages = ceil($totalMangaCount/$limit);

    include("../PHP/library.php");
?>

