<?php
    session_start();
    require('../db/mangaInfoPdo.php');
    header('Content-Type: application/json');

    if (!isset($_SESSION['userID'])) {
        echo json_encode(['rated' => false, 'loggedIn' => false]);
        exit;
    }

    $userID = $_SESSION['userID'];
    $mangaID = $_GET['MangaID'] ?? null;

    if (!$mangaID) {
        echo json_encode(['error' => 'Missing MangaID']);
        exit;
    }

    $hasRated = hasUserRatedManga($userID, $mangaID);
    echo json_encode(['rated' => $hasRated, 'loggedIn' => true]);
?>