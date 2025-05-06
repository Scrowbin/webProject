<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    header(header: 'Content-Type: application/json');

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