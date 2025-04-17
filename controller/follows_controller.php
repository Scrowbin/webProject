<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once('../db/latestUpdates_model.php');
    $userID = $_SESSION['userID'] ?? null;
    $username = $_SESSION['username'] ?? null;
    $isLoggedIn = false;
    if ($userID !=null || $username!= null){
        $isLoggedIn = true;
    }

    $isFollows = true; // Set flag for active menu item in sidebar

    $pathPrefix = '../'; // Define path prefix for includes relative to controller directory

    // Check if user is logged in, if not, show login required page
    if (!$isLoggedIn) {
        include("../PHP/login_required.php");
        exit;
    }

    // If user is logged in, continue with the follows page
    $page = $_GET['page'] ?? 1;
    $limit = 4;
    $offset = ($page - 1) * $limit;
    $chapters = getUpdatesBookmark($userID,1000,0);

    // Group chapters by MangaID
    $grouped = [];
    foreach ($chapters as $chapter) {
        $manga = $chapter['MangaID'];
        $commentOfChapter = getComments($chapter['ChapterID']);
        $chapter['NumOfComments'] = $commentOfChapter["NumOfComments"] ?? 0;
        $chapter['CommentSectionID'] = $commentOfChapter["CommentSectionID"] ?? 0;
        $grouped[$manga][] = $chapter;
    }
        // Now sort and trim each manga's chapter list
    foreach ($grouped as $mangaID => &$chapterList) {
        // Sort chapters by ChapterNumber descending
        usort($chapterList, function ($a, $b) {
            return floatval($b['ChapterNumber']) <=> floatval($a['ChapterNumber']);
        });

        // Keep only the top 3 latest chapters
        $chapterList = array_slice($chapterList, 0, 3);
    }

    $grouped = array_values($grouped);
    //lấy 4 cái manga per pagination
    $totalManga = count($grouped); // <- for pagination logic
    $totalPages = ceil($totalManga / $limit);
    $currentPage = $_GET['page'] ?? 1;
    $grouped = array_slice($grouped, $offset, $limit);
    unset($chapterList);

    include("../PHP/latestUpdates.php");
?>