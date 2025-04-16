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
        $isLoggedIn =true;
    }

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

