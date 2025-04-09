<?php
    require('../db/LibraryAndRating.php');
    session_start();

    if (!isset($_SESSION['userID'])) {
        $userID = getUserID($_SESSION['username']);
        if ($userID==null){
            http_response_code(401);
            exit("You must be logged in to rate.");
        }
        
        $_SESSION['userID'] = $userID;        
    }

    
    $userID = $_SESSION['userID'];
    $mangaID = $_POST['mangaID'] ?? null;
    $rating = $_POST['rating'] ?? null;
    $ratingInDB = getRating($userID,$mangaID);
    if ($rating==0){
        removeRating($userID,$mangaID);
    }
    elseif($ratingInDB == 0)
    {
        addRating($userID,$mangaID,$rating);
    }
    else {
        if ($rating!=$ratingInDB){
            alterRating($userID,$mangaID,$rating);
        }
    }
    header("Location: ../controller/mangaInfo_Controller.php?MangaID=$mangaID");
    exit();

?>