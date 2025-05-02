<?php
    // require('../db/LibraryAndRating.php');
    // session_start();

    // if (!isset($_SESSION['userID'])) {
    //     $userID = getUserID($_SESSION['username']);
    //     if ($userID==null){
    //         http_response_code(401);
    //         exit("You must be logged in to rate.");
    //     }
        
    //     $_SESSION['userID'] = $userID;        
    // }

    
    // $userID = $_SESSION['userID'];
    // $mangaID = $_POST['mangaID'] ?? null;
    // $rating = $_POST['rating'] ?? null;
    // $ratingInDB = getRating($userID,$mangaID);
    // if ($rating==0){
    //     removeRating($userID,$mangaID);
    // }
    // elseif($ratingInDB == 0)
    // {
    //     addRating($userID,$mangaID,$rating);
    // }
    // else {
    //     if ($rating!=$ratingInDB){
    //         alterRating($userID,$mangaID,$rating);
    //     }
    // }
    // header("Location: ../controller/mangaInfo_Controller.php?MangaID=$mangaID");
    // exit();
    session_start();
    header('Content-Type: application/json');

    require_once('../db/LibraryAndRating.php');

    // Check login
    if (!isset($_SESSION['userID'])) {
        $userID = getUserID($_SESSION['username']);
        if (!$userID) {
            http_response_code(401);
            echo json_encode(["success" => false, "message" => "Not logged in"]);
            exit;
        }
        $_SESSION['userID'] = $userID;
    }

    $userID = $_SESSION['userID'];
    $mangaID = $_POST['mangaID'] ?? null;
    $rating = $_POST['rating'] ?? null;

    if (!$mangaID || $rating === null) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Missing mangaID or rating"]);
        exit;
    }

    $ratingInDB = getRating($userID, $mangaID);

    // Apply rating logic
    if ($rating == 0) {
        removeRating($userID, $mangaID);
        echo json_encode(["success" => true, "rating" => 0]);
    } elseif ($ratingInDB == 0) {
        addRating($userID, $mangaID, $rating);
        echo json_encode(["success" => true, "rating" => (int)$rating]);
    } elseif ($rating != $ratingInDB) {
        alterRating($userID, $mangaID, $rating);
        echo json_encode(["success" => true, "rating" => (int)$rating]);
    } else {
        // No change
        echo json_encode(["success" => true, "rating" => (int)$ratingInDB]);
    }
    exit;
    
?>